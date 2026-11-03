<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Services\PermissionRegistry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'permissions'])->latest()->paginate(15);
        $roles = Role::all();
        $allPermissions = Permission::all();
        $modules = PermissionRegistry::getModules();

        return view('users.index', compact('users', 'roles', 'allPermissions', 'modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,name',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:3072',
            'direct_permissions' => 'nullable|array',
            'direct_permissions.*' => 'exists:permissions,name',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatarPath,
        ]);

        $user->assignRole($request->role);

        if ($request->has('direct_permissions')) {
            $user->syncPermissions($request->direct_permissions);
        }

        return back()->with('success', 'تم إنشاء حساب المستخدم وتعيين الصورة والدور والصلاحيات المباشرة بنجاح.');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->role]);

        return back()->with('success', 'تم تحديث صلاحيات المستخدم بنجاح.');
    }

    public function updatePermissions(Request $request, User $user)
    {
        $request->validate([
            'direct_permissions' => 'nullable|array',
            'direct_permissions.*' => 'exists:permissions,name',
        ]);

        if ($request->has('direct_permissions')) {
            $user->syncPermissions($request->direct_permissions);
        } else {
            $user->syncPermissions([]);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return back()->with('success', 'تم تحديث الصلاحيات المباشرة الاستثنائية للمستخدم بنجاح.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|exists:roles,name',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:3072',
            'direct_permissions' => 'nullable|array',
            'direct_permissions.*' => 'exists:permissions,name',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles([$request->role]);

        if ($request->has('direct_permissions')) {
            $user->syncPermissions($request->direct_permissions);
        }

        return back()->with('success', 'تم تحديث بيانات المستخدم وصورته ودوره وصلاحياته بنجاح.');
    }

    public function destroy(User $user)
    {
        // منع حذف المستخدم الحالي
        if ($user->id === auth()->id()) {
            return back()->with('error', 'لا يمكنك حذف حسابك الحالي.');
        }

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return back()->with('success', 'تم حذف المستخدم بنجاح.');
    }
}

