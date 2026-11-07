<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Services\PermissionRegistry;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with(['permissions', 'users'])->withCount('users')->get();
        $allPermissions = Permission::all();
        $modules = PermissionRegistry::getModules();
        $totalUsers = User::count();

        // Calculate statistics
        $stats = [
            'total_roles' => $roles->count(),
            'total_permissions' => $allPermissions->count(),
            'total_users' => $totalUsers,
            'modules_count' => count($modules),
        ];

        return view('roles.index', compact('roles', 'allPermissions', 'modules', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'name.required' => 'يرجى إدخال مسمى الدور الوظيفي.',
            'name.unique' => 'هذا الدور الوظيفي موجود بالفعل.',
        ]);

        $role = Role::create([
            'name' => trim($request->name),
            'guard_name' => 'web',
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return back()->with('success', "تم إنشاء الدور الوظيفي ('{$role->name}') بنجاح وتعيين الصلاحيات المحددة.");
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        // Prevent renaming Super Admin to keep system integrity
        if ($role->name === 'Super Admin' && $request->name !== 'Super Admin') {
            return back()->with('error', 'لا يمكن تغيير مسمى دور مدير النظام الفائق (Super Admin).');
        }

        $role->update(['name' => trim($request->name)]);

        if ($role->name === 'Super Admin') {
            $role->syncPermissions(Permission::all());
        } elseif ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return back()->with('success', "تم تحديث بيانات الدور الوظيفي ('{$role->name}') والصلاحيات بنجاح.");
    }

    public function destroy(Role $role)
    {
        $protectedRoles = ['Super Admin', 'Manager', 'Head of Section', 'Secretary', 'Viewer'];

        if (in_array($role->name, $protectedRoles)) {
            return back()->with('error', "لا يمكن حذف الدور الأساسي النظامي ('{$role->name}').");
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', "لا يمكن حذف الدور ('{$role->name}') لأنه مخصص لعدد ({$role->users()->count()}) من المستخدمين حالياً.");
        }

        $roleName = $role->name;
        $role->delete();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return back()->with('success', "تم حذف الدور الوظيفي ('{$roleName}') بنجاح.");
    }

    /**
     * Bulk update matrix permissions for all roles.
     */
    public function syncMatrix(Request $request)
    {
        $matrix = $request->input('matrix', []); // array of [role_id => [perm_name => 1]]

        $roles = Role::all();

        DB::beginTransaction();
        try {
            foreach ($roles as $role) {
                // Super Admin always retains all permissions
                if ($role->name === 'Super Admin') {
                    $role->syncPermissions(Permission::all());
                    continue;
                }

                $rolePermissions = isset($matrix[$role->id]) ? array_keys($matrix[$role->id]) : [];
                $role->syncPermissions($rolePermissions);
            }

            DB::commit();
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            return back()->with('success', 'تم حفظ وتحديث مصفوفة الصلاحيات لجميع الأدوار بنجاح.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء حفظ مصفوفة الصلاحيات: ' . $e->getMessage());
        }
    }
}
