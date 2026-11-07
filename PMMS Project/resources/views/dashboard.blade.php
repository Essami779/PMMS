@extends('layouts.app')

@section('content')
    <div class="space-y-6 w-full max-w-7xl mx-auto pb-10">

        <!-- ================= 1. Welcome & Greeting Banner (Light & Dark Adaptive) ================= -->
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-l from-indigo-500/10 via-purple-500/5 to-white dark:from-indigo-950/60 dark:via-slate-900 dark:to-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-sm">
            <!-- Decorative Ambient Glows -->
            <div
                class="absolute -left-16 -top-16 w-64 h-64 bg-indigo-500/10 dark:bg-blue-500/20 rounded-full blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute -right-16 -bottom-16 w-64 h-64 bg-purple-500/10 dark:bg-indigo-400/20 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <!-- Welcome Info -->
                <div class="space-y-2">
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-black bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 shadow-2xs">
                            مرحباً بك مجدداً 👋
                        </span>
                        <span
                            class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300">
                            المنظومة تعمل بكفاءة 100%
                        </span>
                    </div>

                    <h1
                        class="text-xl sm:text-2xl lg:text-3xl font-black text-slate-800 dark:text-white font-readex tracking-tight">
                        {{ auth()->user()->name }}
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-300 font-medium max-w-xl leading-relaxed">
                        لوحة التحكم المركزية للمشروع — إدارة المستخدمين، النسخ الاحتياطي، وسجلات التدقيق والأمان.
                    </p>
                </div>

                <!-- Quick Action Buttons -->
                <div class="flex items-center gap-2.5 flex-wrap shrink-0">
                    @can('users.manage')
                        <a href="{{ route('users.index') }}"
                            class="px-4 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs transition-all shadow-md shadow-indigo-500/20 hover:scale-105 flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>إضافة مستخدم</span>
                        </a>
                    @endcan

                    @can('backups.manage')
                        <form method="POST" action="{{ route('backups.store') }}">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2.5 rounded-2xl bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-750 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 font-black text-xs transition-all shadow-xs hover:scale-105 flex items-center gap-2 cursor-pointer">
                                <svg class="w-4 h-4 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                                </svg>
                                <span>نسخ احتياطي فوري</span>
                            </button>
                        </form>
                    @endcan

                    @can('roles.manage')
                        <a href="{{ route('roles.index') }}"
                            class="px-4 py-2.5 rounded-2xl bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-750 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 font-black text-xs transition-all shadow-xs hover:scale-105 flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>مصفوفة الصلاحيات</span>
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- ================= 2. Key Metric Cards Grid (4 Cards) ================= -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            <!-- Card 1: Users -->
            <div
                class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400">إجمالي المستخدمين</p>
                        <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">
                            {{ number_format($totalUsers) }}
                        </h3>
                        <p class="text-[11px] font-bold text-cyan-600 dark:text-cyan-400 mt-1">
                            {{ $totalRoles }} أدوار معرفة
                        </p>
                    </div>
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-cyan-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                @can('users.manage')
                    <div
                        class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-xs">
                        <a href="{{ route('users.index') }}"
                            class="font-bold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                            <span>إدارة الحسابات</span>
                            <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        <span class="text-slate-400 text-[10px]">نشط الآن</span>
                    </div>
                @endcan
            </div>

            <!-- Card 2: Roles & Permissions -->
            <div
                class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400">الأدوار والمجموعات</p>
                        <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">
                            {{ number_format($totalRoles) }}
                        </h3>
                        <p class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 mt-1">
                            نظام صلاحيات متقدم (Spatie)
                        </p>
                    </div>
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>
                @can('roles.manage')
                    <div
                        class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-xs">
                        <a href="{{ route('roles.index') }}"
                            class="font-bold text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-1">
                            <span>تعديل الصلاحيات</span>
                            <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        <span class="text-slate-400 text-[10px]">مصفوفة حية</span>
                    </div>
                @endcan
            </div>

            <!-- Card 3: Backups & Storage -->
            <div
                class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400">النسخ الاحتياطية</p>
                        <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">
                            {{ number_format($backupsCount) }}
                        </h3>
                        <p class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 mt-1">
                            الحجم: {{ $formattedBackupSize }}
                        </p>
                    </div>
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                        </svg>
                    </div>
                </div>
                @can('backups.manage')
                    <div
                        class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-xs">
                        <a href="{{ route('backups.index') }}"
                            class="font-bold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                            <span>مركز النسخ والاستعادة</span>
                            <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        <span class="text-slate-400 text-[10px]">SQL / ZIP</span>
                    </div>
                @endcan
            </div>

            <!-- Card 4: Audit Log -->
            <div
                class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400">سجل التدقيق والأمان</p>
                        <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">
                            {{ number_format($totalLogs) }}
                        </h3>
                        <p class="text-[11px] font-bold text-rose-600 dark:text-rose-400 mt-1">
                            تتبع مباشر ومؤتمت
                        </p>
                    </div>
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-500 to-amber-600 flex items-center justify-center text-white shadow-lg shadow-rose-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                @can('audit.view')
                    <div
                        class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-xs">
                        <a href="{{ route('audit.index') }}"
                            class="font-bold text-rose-600 dark:text-rose-400 hover:underline flex items-center gap-1">
                            <span>عرض سجل النشاطات</span>
                            <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                        <span class="text-slate-400 text-[10px]">محدث فوراً</span>
                    </div>
                @endcan
            </div>

        </div>

        <!-- ================= 3. Interactive Charts Grid (2 Columns) ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Chart 1: Activity Volume (2 Cols) -->
            <div
                class="lg:col-span-2 rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-9 h-9 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-black text-slate-800 dark:text-slate-100 font-readex">
                                    حركة النشاط والعمليات (آخر 7 أيام)
                                </h3>
                                <p class="text-xs text-slate-400 font-medium">معدل العمليات وسجلات التدقيق المنجزة يومياً
                                </p>
                            </div>
                        </div>
                        <span
                            class="px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                            محدث تلقائياً
                        </span>
                    </div>

                    <div class="h-64 relative w-full">
                        <canvas id="activityTrendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Chart 2: Roles Distribution (1 Col) -->
            <div
                class="rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-9 h-9 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-black text-slate-800 dark:text-slate-100 font-readex">
                                    توزيع الأدوار
                                </h3>
                                <p class="text-xs text-slate-400 font-medium">نسب المستخدمين حسب الرتب</p>
                            </div>
                        </div>
                    </div>

                    <div class="h-56 relative w-full flex items-center justify-center">
                        <canvas id="rolesDoughnutChart"></canvas>
                    </div>

                    <!-- Role Badges Legend -->
                    <div class="mt-4 flex flex-wrap gap-1.5 justify-center">
                        @foreach($roleLabels as $index => $label)
                            <span
                                class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10.5px] font-bold bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-600">
                                <span class="w-2 h-2 rounded-full"
                                    style="background-color: {{ $roleColors[$index] ?? '#6366f1' }};"></span>
                                <span>{{ $label }} ({{ $roleCounts[$index] ?? 0 }})</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= 4. Recent Activity Feed & Server Info ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Recent Activity Stream (2 Cols) -->
            <div
                class="lg:col-span-2 rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-6 shadow-xs">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-9 h-9 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-800 dark:text-slate-100 font-readex">
                                أحدث سجلات النشاط والتدقيق
                            </h3>
                            <p class="text-xs text-slate-400 font-medium">العمليات المنفذة مؤخراً في المنظومة</p>
                        </div>
                    </div>
                    @can('audit.view')
                        <a href="{{ route('audit.index') }}"
                            class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                            عرض الكل &larr;
                        </a>
                    @endcan
                </div>

                @if($recentActivities->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full text-right">
                            <thead>
                                <tr
                                    class="text-[11px] font-black text-slate-400 border-b border-slate-100 dark:border-slate-700/80">
                                    <th class="py-2.5 px-3">المستخدم</th>
                                    <th class="py-2.5 px-3">الإجراء / العملية</th>
                                    <th class="py-2.5 px-3">القسم</th>
                                    <th class="py-2.5 px-3">التوقيت</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 text-xs font-medium">
                                @foreach($recentActivities as $activity)
                                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-750/50 transition">
                                        <td class="py-3 px-3">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-7 h-7 rounded-lg bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 font-black text-[11px] flex items-center justify-center shrink-0">
                                                    {{ mb_substr($activity->causer?->name ?? 'ن', 0, 1) }}
                                                </div>
                                                <span class="font-bold text-slate-800 dark:text-slate-200 truncate max-w-[120px]">
                                                    {{ $activity->causer?->name ?? 'النظام الآلي' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 text-slate-700 dark:text-slate-300">
                                            {{ $activity->description }}
                                        </td>
                                        <td class="py-3 px-3">
                                            <span
                                                class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                                                {{ $activity->log_name ?? 'عام' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 text-[11px] text-slate-400 whitespace-nowrap">
                                            {{ $activity->created_at?->locale('ar')->diffForHumans() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-12 text-center text-slate-400 text-xs">
                        لا توجد سجلات نشاط مسجلة حتى الآن.
                    </div>
                @endif
            </div>

            <!-- Server & Health Status Widget (1 Col) -->
            <div
                class="rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-6 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-black text-slate-800 dark:text-slate-100 font-readex">
                                    بيئة التشغيل والخادم
                                </h3>
                                <p class="text-xs text-slate-400 font-medium">مؤشرات الأداء وصحة المنظومة</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div
                            class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-750/60 border border-slate-100 dark:border-slate-700/50">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">إصدار PHP</span>
                            <span
                                class="font-mono font-bold text-slate-800 dark:text-slate-200">v{{ $systemInfo['php_version'] }}</span>
                        </div>

                        <div
                            class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-750/60 border border-slate-100 dark:border-slate-700/50">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">إصدار Laravel</span>
                            <span
                                class="font-mono font-bold text-slate-800 dark:text-slate-200">v{{ $systemInfo['laravel_version'] }}</span>
                        </div>

                        <div
                            class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-750/60 border border-slate-100 dark:border-slate-700/50">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">قاعدة البيانات</span>
                            <span
                                class="font-mono font-bold text-slate-800 dark:text-slate-200">{{ strtoupper($systemInfo['database_driver']) }}</span>
                        </div>

                        <div
                            class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-750/60 border border-slate-100 dark:border-slate-700/50">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">المنطقة الزمنية</span>
                            <span
                                class="font-mono font-bold text-slate-800 dark:text-slate-200">{{ $systemInfo['app_timezone'] }}</span>
                        </div>

                        <div
                            class="flex items-center justify-between p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-750/60 border border-slate-100 dark:border-slate-700/50">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">حالة البيئة</span>
                            <span
                                class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                {{ strtoupper($systemInfo['app_env']) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 border-t border-slate-100 dark:border-slate-700/60 text-center">
                    <span
                        class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center justify-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                        الخادم يعمل بكفاءة عالية وبدون مشاكل
                    </span>
                </div>
            </div>

        </div>

    </div>

    <!-- ================= Chart.js Initializations ================= -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const isDark = document.documentElement.classList.contains('dark');
                const gridColor = isDark ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.05)';
                const textColor = isDark ? '#94a3b8' : '#64748b';

                // 1. Activity Trend Chart
                const ctxActivity = document.getElementById('activityTrendChart');
                if (ctxActivity) {
                    const activityChart = new Chart(ctxActivity.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: @json($activityDays),
                            datasets: [{
                                label: 'عدد العمليات والنشاطات',
                                data: @json($activityCounts),
                                borderColor: '#6366f1',
                                backgroundColor: 'rgba(99, 102, 241, 0.15)',
                                fill: true,
                                tension: 0.35,
                                borderWidth: 3,
                                pointBackgroundColor: '#6366f1',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: 5,
                                pointHoverRadius: 7
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    rtl: true,
                                    bodyFont: { family: 'Cairo' },
                                    titleFont: { family: 'Cairo' }
                                }
                            },
                            scales: {
                                x: {
                                    grid: { color: gridColor },
                                    ticks: { color: textColor, font: { family: 'Cairo', size: 11 } }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: { color: gridColor },
                                    ticks: {
                                        color: textColor,
                                        font: { family: 'Cairo', size: 11 },
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                }

                // 2. Roles Doughnut Chart
                const ctxRoles = document.getElementById('rolesDoughnutChart');
                if (ctxRoles) {
                    const rolesChart = new Chart(ctxRoles.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: @json($roleLabels),
                            datasets: [{
                                data: @json($roleCounts),
                                backgroundColor: @json($roleColors),
                                borderWidth: isDark ? 2 : 1,
                                borderColor: isDark ? '#1e293b' : '#ffffff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    rtl: true,
                                    bodyFont: { family: 'Cairo' },
                                    titleFont: { family: 'Cairo' }
                                }
                            },
                            cutout: '70%'
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection