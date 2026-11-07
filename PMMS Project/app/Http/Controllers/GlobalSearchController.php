<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unit;
use App\Models\Governorate;
use App\Models\Currency;
use Spatie\Permission\Models\Role;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GlobalSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('q', ''));
        $categoryFilter = $request->input('category', 'all');

        if (empty($query)) {
            if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
                return response()->json([
                    'status' => 'success',
                    'query' => '',
                    'total_count' => 0,
                    'categories' => [],
                    'results' => []
                ]);
            }

            return view('search.index', [
                'query' => '',
                'totalCount' => 0,
                'categories' => [],
                'resultsByCategory' => [],
                'allResults' => [],
                'selectedCategory' => 'all',
            ]);
        }

        $resultsByCategory = [
            'navigation' => [
                'title' => 'شاشات النظام والإعدادات',
                'badge' => 'تنقل سريع',
                'icon' => 'compass',
                'color' => 'indigo',
                'items' => []
            ],
            'users' => [
                'title' => 'المستخدمين والحسابات',
                'badge' => 'مستخدمين',
                'icon' => 'users',
                'color' => 'blue',
                'items' => []
            ],
            'roles' => [
                'title' => 'الأدوار والصلاحيات',
                'badge' => 'أدوار',
                'icon' => 'shield-check',
                'color' => 'emerald',
                'items' => []
            ],
            'lookups' => [
                'title' => 'القوائم المساعدة والعملات',
                'badge' => 'قوائم وترميز',
                'icon' => 'table-cells',
                'color' => 'amber',
                'items' => []
            ],
            'audit' => [
                'title' => 'سجل التدقيق والأمان',
                'badge' => 'تدقيق وأمان',
                'icon' => 'shield-exclamation',
                'color' => 'rose',
                'items' => []
            ],
        ];

        // 1. Navigation Pages
        $navScreens = [
            ['title' => 'لوحة التحكم الرئيسية والإحصائيات', 'route' => route('dashboard'), 'tags' => 'dashboard statistics لوحة التحكم الإحصائيات مؤشرات', 'category' => 'الرئيسية'],
            ['title' => 'إدارة المستخدمين والحسابات', 'route' => route('users.index'), 'tags' => 'users accounts مستخدمين حسابات كلمات مرور', 'category' => 'إعدادات النظام'],
            ['title' => 'مركز الأدوار والصلاحيات', 'route' => route('roles.index'), 'tags' => 'roles permissions أدوار صلاحيات مصفوفة تراخيص', 'category' => 'إعدادات النظام'],
            ['title' => 'إدارة القوائم المساعدة والترميز', 'route' => route('lookups.index'), 'tags' => 'lookups units governorates currencies قوائم أقسام محافظات عملات', 'category' => 'إعدادات النظام'],
            ['title' => 'سجل التدقيق والأمان والنشاطات', 'route' => route('audit.index'), 'tags' => 'audit activity log سجل تدقيق أمان نشاطات أحداث', 'category' => 'إعدادات النظام'],
            ['title' => 'إدارة النسخ الاحتياطي لقاعدة البيانات والمشروع', 'route' => route('backups.index'), 'tags' => 'backups database sql zip نسخ احتياطي قاعدة بيانات', 'category' => 'إعدادات النظام'],
            ['title' => 'سلة المهملات والمحذوفات', 'route' => route('trash.index'), 'tags' => 'trash recycle bin مهملات محذوفات استعادة', 'category' => 'إعدادات النظام'],
            ['title' => 'الملف الشخصي وإعدادات الحساب', 'route' => route('profile.edit'), 'tags' => 'profile account ملف شخصي حساب كلمة مرور', 'category' => 'الحساب'],
        ];

        foreach ($navScreens as $screen) {
            if (stripos($screen['title'], $query) !== false || stripos($screen['tags'], $query) !== false) {
                $resultsByCategory['navigation']['items'][] = [
                    'id' => 'nav_' . md5($screen['route']),
                    'title' => $screen['title'],
                    'subtitle' => $screen['category'],
                    'url' => $screen['route'],
                    'badge' => 'شاشة نظام',
                    'date' => null,
                ];
            }
        }

        // 2. Users
        if (Auth::user()?->can('users.manage')) {
            $users = User::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->take(6)
                ->get();

            foreach ($users as $u) {
                $resultsByCategory['users']['items'][] = [
                    'id' => 'user_' . $u->id,
                    'title' => $u->name,
                    'subtitle' => $u->email . ' (' . ($u->getRoleNames()->first() ?? 'مستخدم') . ')',
                    'url' => route('users.index', ['search' => $u->name]),
                    'badge' => $u->getRoleNames()->first() ?? 'مستخدم',
                    'date' => $u->created_at?->format('Y-m-d'),
                ];
            }
        }

        // 3. Roles
        if (Auth::user()?->can('roles.manage')) {
            $roles = Role::where('name', 'like', "%{$query}%")->take(5)->get();
            foreach ($roles as $r) {
                $resultsByCategory['roles']['items'][] = [
                    'id' => 'role_' . $r->id,
                    'title' => 'الدور الوظيفي: ' . $r->name,
                    'subtitle' => 'عدد الصلاحيات: ' . $r->permissions()->count(),
                    'url' => route('roles.index'),
                    'badge' => 'دور وظيفي',
                    'date' => null,
                ];
            }
        }

        // 4. Lookups (Units, Governorates, Currencies)
        if (Auth::user()?->can('lookups.manage')) {
            $units = Unit::where('name', 'like', "%{$query}%")->orWhere('code', 'like', "%{$query}%")->take(4)->get();
            foreach ($units as $unit) {
                $resultsByCategory['lookups']['items'][] = [
                    'id' => 'unit_' . $unit->id,
                    'title' => 'الوحدة/القسم: ' . $unit->name,
                    'subtitle' => $unit->code ? "الكود: {$unit->code}" : 'وحدة إدارية',
                    'url' => route('lookups.index', ['tab' => 'units']),
                    'badge' => 'وحدة إدارية',
                    'date' => null,
                ];
            }

            $currencies = Currency::where('name', 'like', "%{$query}%")->orWhere('code', 'like', "%{$query}%")->take(4)->get();
            foreach ($currencies as $curr) {
                $resultsByCategory['lookups']['items'][] = [
                    'id' => 'curr_' . $curr->id,
                    'title' => 'العملة: ' . $curr->name . ' (' . $curr->code . ')',
                    'subtitle' => "الرمز: {$curr->symbol} | الصرف: {$curr->exchange_rate}",
                    'url' => route('lookups.index', ['tab' => 'currencies']),
                    'badge' => 'عملة',
                    'date' => null,
                ];
            }
        }

        // 5. Audit Log
        if (Auth::user()?->can('audit.view')) {
            $activities = Activity::with('causer')
                ->where('description', 'like', "%{$query}%")
                ->orWhere('properties', 'like', "%{$query}%")
                ->latest()
                ->take(5)
                ->get();

            foreach ($activities as $act) {
                $resultsByCategory['audit']['items'][] = [
                    'id' => 'act_' . $act->id,
                    'title' => $act->description,
                    'subtitle' => 'بواسطة: ' . ($act->causer?->name ?? 'النظام'),
                    'url' => route('audit.index', ['search' => $query]),
                    'badge' => $act->log_name ?? 'تدقيق',
                    'date' => $act->created_at?->format('Y-m-d H:i'),
                ];
            }
        }

        // Filter empty categories
        $categories = [];
        $allResults = [];
        $totalCount = 0;

        foreach ($resultsByCategory as $key => $cat) {
            $catCount = count($cat['items']);
            if ($catCount > 0) {
                $categories[$key] = [
                    'key' => $key,
                    'title' => $cat['title'],
                    'badge' => $cat['badge'],
                    'icon' => $cat['icon'],
                    'color' => $cat['color'],
                    'count' => $catCount,
                ];
                $totalCount += $catCount;
                foreach ($cat['items'] as $item) {
                    $allResults[] = array_merge($item, ['category_key' => $key, 'category_title' => $cat['title']]);
                }
            }
        }

        if ($request->ajax() || $request->wantsJson() || $request->has('ajax')) {
            return response()->json([
                'status' => 'success',
                'query' => $query,
                'total_count' => $totalCount,
                'categories' => $categories,
                'results_by_category' => $resultsByCategory,
                'results' => $allResults,
            ]);
        }

        return view('search.index', [
            'query' => $query,
            'totalCount' => $totalCount,
            'categories' => $categories,
            'resultsByCategory' => $resultsByCategory,
            'allResults' => $allResults,
            'selectedCategory' => $categoryFilter,
        ]);
    }
}
