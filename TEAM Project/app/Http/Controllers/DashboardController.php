<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unit;
use App\Models\Governorate;
use App\Models\Currency;
use Spatie\Permission\Models\Role;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ─── 1. الإحصائيات الأساسية (Key Metrics) ───────────────────────────
        $totalUsers = User::count();
        $totalRoles = Role::count();
        $totalUnits = Unit::count();
        $totalGovernorates = Governorate::count();
        $totalCurrencies = Currency::active()->count();
        $totalLogs = Activity::count();

        // ─── 2. بيانات النسخ الاحتياطي ومساحة التخزين ───────────────────────
        $backupDir = storage_path('app/backups');
        $backupsCount = 0;
        $totalBackupSize = 0;
        if (File::exists($backupDir)) {
            $backupFiles = File::files($backupDir);
            $backupsCount = count($backupFiles);
            foreach ($backupFiles as $bf) {
                $totalBackupSize += $bf->getSize();
            }
        }
        $formattedBackupSize = $this->formatBytes($totalBackupSize);

        // ─── 3. توزيع المستخدمين حسب الأدوار (Roles Distribution Doughnut Chart) ─
        $rolesWithUsers = Role::withCount('users')->get();
        $roleLabels = $rolesWithUsers->map(fn($r) => \App\Services\PermissionRegistry::getRoleMetadata($r->name)['label'] ?? $r->name)->values();
        $roleCounts = $rolesWithUsers->pluck('users_count')->values();
        $roleColors = $rolesWithUsers->map(function ($r) {
            $color = \App\Services\PermissionRegistry::getRoleMetadata($r->name)['color'] ?? 'indigo';
            return match ($color) {
                'rose' => '#f43f5e',
                'indigo' => '#6366f1',
                'amber' => '#f59e0b',
                'emerald' => '#10b981',
                'sky' => '#0ea5e9',
                'purple' => '#a855f7',
                default => '#64748b',
            };
        })->values();

        // ─── 4. مخطط نشاط العمليات خلال آخر 7 أيام (Activity Trend Chart) ───
        $activityDays = [];
        $activityCounts = [];
        $arabicDayNames = [
            'Sunday' => 'الأحد',
            'Monday' => 'الاثنين',
            'Tuesday' => 'الثلاثاء',
            'Wednesday' => 'الأربعاء',
            'Thursday' => 'الخميس',
            'Friday' => 'الجمعة',
            'Saturday' => 'السبت',
        ];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateStr = $date->toDateString();
            $dayEnglish = $date->format('l');
            $dayArabic = $arabicDayNames[$dayEnglish] ?? $dayEnglish;
            
            $count = Activity::whereDate('created_at', $dateStr)->count();
            
            $activityDays[] = $dayArabic . ' (' . $date->format('m/d') . ')';
            $activityCounts[] = $count;
        }

        // ─── 5. أحدث سجلات النشاط والتدقيق (Recent System Events) ───────────
        $recentActivities = Activity::with(['causer', 'subject'])
            ->latest()
            ->take(6)
            ->get();

        // ─── 6. قائمة أحدث المستخدمين المنضمين (Recent Users) ───────────────
        $recentUsers = User::with('roles')
            ->latest()
            ->take(5)
            ->get();

        // ─── 7. معلومات الخادم وصحة النظام (Server Health & Environment) ───
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_os' => php_uname('s') . ' (' . php_uname('r') . ')',
            'database_driver' => config('database.default'),
            'app_timezone' => config('app.timezone', 'Asia/Aden'),
            'app_env' => config('app.env', 'production'),
            'cache_driver' => config('cache.default', 'file'),
        ];

        return view('dashboard', compact(
            'totalUsers',
            'totalRoles',
            'totalUnits',
            'totalGovernorates',
            'totalCurrencies',
            'totalLogs',
            'backupsCount',
            'formattedBackupSize',
            'roleLabels',
            'roleCounts',
            'roleColors',
            'activityDays',
            'activityCounts',
            'recentActivities',
            'recentUsers',
            'systemInfo'
        ));
    }

    private function formatBytes($bytes, $precision = 2): string
    {
        if ($bytes <= 0) return '0 بايت';
        $units = ['بايت', 'كيلوبايت', 'ميجابايت', 'جيجابايت', 'تيرابايت'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
