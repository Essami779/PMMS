@extends('layouts.app')

@section('content')
    <div x-data="rolesManagement()" class="space-y-5 w-full max-w-full overflow-x-hidden" dir="rtl"
        style="font-family: 'Cairo', sans-serif !important;">

        {{-- ═══════════════════════════════════════════
    HEADER & KPI METRICS & ACTION BAR (متناسق وموزع بالتساوي)
    ══════════════════════════════════════════════ --}}
        <div
            class="relative overflow-hidden bg-gradient-to-br from-slate-100 via-white to-slate-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700/80 shadow-sm p-4 sm:p-5 space-y-4">

            {{-- خلفية زخرفية ناعمة --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div
                    class="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-purple-500/20 dark:bg-purple-500/10 blur-3xl">
                </div>
                <div class="absolute -bottom-16 -left-16 w-60 h-60 rounded-full bg-blue-500/20 dark:bg-blue-500/10 blur-3xl">
                </div>
            </div>

            <div class="relative space-y-4">

                {{-- الصف الأول: العنوان على اليمين ، كروت الإحصائيات على اليسار --}}
                <div
                    class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-4 border-b border-slate-200/80 dark:border-slate-700/60">

                    {{-- اليمين: العنوان والأيقونة والوسم --}}
                    <div class="flex items-center gap-3">
                        <div
                            class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-500 to-blue-600 flex items-center justify-center shadow-md shadow-purple-500/20 shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h1 class="text-xl font-black text-slate-800 dark:text-white leading-tight">مركز إدارة
                                    الأدوار والصلاحيات</h1>
                                <span
                                    class="px-2.5 py-0.5 rounded-full text-[10.5px] font-black bg-purple-500/10 text-purple-700 dark:text-purple-300 border border-purple-500/20">
                                    RBAC Matrix
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">التحكم بالأدوار الوظيفية ومصفوفة
                                الأذونات وتراخيص المنظومة</p>
                        </div>
                    </div>

                    {{-- اليسار: كروت الإحصاء الكلية (موزعة ومسحوبة لأقسى اليسار) --}}
                    <div class="flex items-center gap-2.5 flex-wrap justify-start lg:justify-end">

                        {{-- بطاقة 1: الأدوار الوظيفية --}}
                        <div
                            class="h-13 flex flex-col justify-center bg-white/80 dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700 backdrop-blur-sm rounded-xl px-4 text-center min-w-[95px] shadow-xs">
                            <p class="text-lg font-black text-purple-700 dark:text-purple-300 leading-none">
                                {{ number_format($stats['total_roles']) }}</p>
                            <p class="text-[10.5px] text-slate-500 dark:text-slate-400 mt-1 font-medium">الأدوار الوظيفية
                            </p>
                        </div>

                        {{-- بطاقة 2: إجمالي الصلاحيات --}}
                        <div
                            class="h-13 flex flex-col justify-center bg-emerald-50/80 dark:bg-emerald-950/40 border border-emerald-200/80 dark:border-emerald-700/50 backdrop-blur-sm rounded-xl px-4 text-center min-w-[105px] shadow-xs">
                            <p class="text-lg font-black text-emerald-700 dark:text-emerald-400 leading-none">
                                {{ number_format($stats['total_permissions']) }}</p>
                            <p class="text-[10.5px] text-emerald-600/80 dark:text-emerald-400/90 mt-1 font-medium">إجمالي
                                الصلاحيات</p>
                        </div>

                        {{-- بطاقة 3: المستخدمين المسجلين --}}
                        <div
                            class="h-13 flex flex-col justify-center bg-white/80 dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700 backdrop-blur-sm rounded-xl px-4 text-center min-w-[105px] shadow-xs">
                            <p class="text-lg font-black text-slate-800 dark:text-white leading-none">
                                {{ number_format($stats['total_users']) }}</p>
                            <p class="text-[10.5px] text-slate-500 dark:text-slate-400 mt-1 font-medium">المستخدمين المسجلين
                            </p>
                        </div>

                    </div>
                </div>

                {{-- الصف الثاني: التبويبات على اليمين ، أزرار العمليات وحفظ الصلاحيات على اليسار --}}
                <div class="flex flex-col md:flex-row items-center justify-between gap-3 pt-1">

                    {{-- اليمين: التبويبات الفاخرة --}}
                    <div
                        class="inline-flex items-center gap-1.5 p-1 rounded-full bg-slate-200/70 dark:bg-slate-800/90 border border-slate-300/60 dark:border-slate-700 no-scrollbar overflow-x-auto max-w-full">

                        <button type="button" @click="activeTab = 'matrix'"
                            :class="activeTab === 'matrix' ? 'btn-pill-indigo px-5 py-2 text-xs font-bold shadow-md' :
                                'tab-pill-inactive px-4 py-2 text-xs font-bold'">
                            <span class="flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>مصفوفة الصلاحيات التفاعلية</span>
                            </span>
                        </button>

                        <button type="button" @click="activeTab = 'roles'"
                            :class="activeTab === 'roles' ? 'btn-pill-indigo px-5 py-2 text-xs font-bold shadow-md' :
                                'tab-pill-inactive px-4 py-2 text-xs font-bold'">
                            <span class="flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span>بطاقات الأدوار الوظيفية</span>
                                <span
                                    class="badge-pill-yellow text-slate-950 w-5 h-5 min-w-[20px] text-[11px] rounded-full inline-flex items-center justify-center font-black">
                                    {{ count($roles) }}
                                </span>
                            </span>
                        </button>

                        <button type="button" @click="activeTab = 'registry'"
                            :class="activeTab === 'registry' ? 'btn-pill-indigo px-5 py-2 text-xs font-bold shadow-md' :
                                'tab-pill-inactive px-4 py-2 text-xs font-bold'">
                            <span class="flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>دليل تعاريف الأذونات</span>
                            </span>
                        </button>

                    </div>

                    {{-- اليسار: أزرار العمليات السريعة (إضافة دور + حفظ الصلاحيات!) --}}
                    <div class="flex items-center gap-2.5 shrink-0 flex-wrap">

                        {{-- زر حفظ مصفوفة الصلاحيات الفاخر (يظهر عند تبويب المصفوفة) --}}
                        <button type="button" @click="submitMatrixForm()" x-show="activeTab === 'matrix'"
                            class="btn-pill-sky inline-flex items-center gap-2.5 h-10 pr-3.5 pl-1.5 rounded-full text-xs font-bold transition-all shrink-0 cursor-pointer border border-transparent shadow-md hover:scale-[1.02] whitespace-nowrap">
                            <svg class="w-4 h-4 shrink-0 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="whitespace-nowrap px-0.5 text-white font-bold">حفظ مصفوفة الصلاحيات</span>
                            <span
                                class="badge-pill-yellow text-slate-950 w-6 h-6 min-w-[24px] rounded-full inline-flex items-center justify-center shrink-0 shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-slate-950" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                        </button>

                        {{-- زر إضافة دور وظيفي جديد --}}
                        <button type="button" @click="openCreateModal()"
                            class="btn-pill-emerald inline-flex items-center gap-2.5 h-10 pr-3.5 pl-1.5 rounded-full text-xs font-bold transition-all shrink-0 cursor-pointer border border-transparent shadow-md hover:scale-[1.02] whitespace-nowrap">
                            <svg class="w-4 h-4 shrink-0 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="whitespace-nowrap px-0.5 text-white font-bold">إضافة دور وظيفي</span>
                            <span
                                class="badge-pill-yellow text-slate-950 w-6 h-6 min-w-[24px] rounded-full inline-flex items-center justify-center shrink-0 shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-slate-950" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </span>
                        </button>

                    </div>
                </div>

            </div>
        </div>


        <!-- ========================================================= -->
        <!-- TAB 1: INTERACTIVE PERMISSIONS MATRIX -->
        <!-- ========================================================= -->
        <div x-show="activeTab === 'matrix'" x-transition:enter="transition ease-out duration-300"
            class="space-y-4 w-full">

            <form id="matrixForm" action="{{ route('roles.matrix.sync') }}" method="POST" class="w-full space-y-3">
                @csrf
                <!-- Toolbar: حقل البحث السريع وزر الحفظ الإضافي -->
                <div
                    class="w-full flex flex-col md:flex-row items-center justify-between gap-3 bg-white/90 dark:bg-slate-800/95 backdrop-blur-xl p-3.5 sm:p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs">

                    {{-- حقل البحث الأيمن --}}
                    <div class="relative w-full md:w-80 shrink-0">
                        <input type="text" x-model="searchQuery" placeholder="ابحث برمز الصلاحية أو المسمى..."
                            class="w-full h-10 pl-4 pr-9 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:border-purple-500 dark:focus:border-purple-400 focus:ring-1 focus:ring-purple-500 dark:focus:ring-purple-400 focus:outline-none transition">
                        <svg class="w-4 h-4 absolute right-3 top-3 text-slate-400 dark:text-slate-500 pointer-events-none" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    {{-- أزرار مسح وتطبيق على اليسار --}}
                    <div class="flex items-center gap-2 shrink-0 w-full md:w-auto justify-end flex-wrap">

                        {{-- زر مسح البحث --}}
                        <button type="button" x-show="searchQuery" @click="searchQuery = ''"
                            class="h-10 px-3.5 inline-flex items-center justify-center gap-1 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-200 text-xs font-bold rounded-xl transition border border-slate-200 dark:border-slate-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>مسح</span>
                        </button>
                    </div>
                </div>

                <!-- Matrix Table Wrapper -->
                <div
                    class="w-full overflow-hidden bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                    <div class="w-full max-h-[75vh] overflow-y-auto no-scrollbar">
                        <table class="w-full text-right border-collapse table-auto">
                            <!-- Sticky Table Header -->
                            <thead>
                                <tr
                                    class="bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs border-b-2 border-slate-200 dark:border-slate-700 sticky top-0 z-30">
                                    <th
                                        class="p-3.5 font-black w-2/5 sm:w-1/3 bg-slate-100 dark:bg-slate-800 border-l border-slate-200 dark:border-slate-700">
                                        <div class="flex items-center space-x-2 space-x-reverse">
                                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400 shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            <span class="text-slate-800 dark:text-slate-100 whitespace-nowrap">الموديول / الإذن الأمني</span>
                                        </div>
                                    </th>

                                    @foreach ($roles as $role)
                                        @php
                                            $meta = \App\Services\PermissionRegistry::getRoleMetadata($role->name);
                                            $roleBadgeColors = [
                                                'Super Admin' =>
                                                    'bg-rose-500/10 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300 border-rose-200 dark:border-rose-800/60',
                                                'Manager' =>
                                                    'bg-indigo-500/10 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-800/60',
                                                'Head of Section' =>
                                                    'bg-amber-500/10 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-800/60',
                                                'Secretary' =>
                                                    'bg-emerald-500/10 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800/60',
                                                'Viewer' =>
                                                    'bg-sky-500/10 dark:bg-sky-950/40 text-sky-700 dark:text-sky-300 border-sky-200 dark:border-sky-800/60',
                                            ];
                                            $badgeClass =
                                                $roleBadgeColors[$role->name] ??
                                                'bg-purple-500/10 dark:bg-purple-950/40 text-purple-700 dark:text-purple-300 border-purple-200 dark:border-purple-800/60';
                                        @endphp
                                        <th
                                            class="p-2.5 sm:p-3.5 font-bold text-center border-l border-slate-200/60 dark:border-slate-700/80">
                                            <div class="flex flex-col items-center justify-center space-y-1">
                                                <span
                                                    class="px-2.5 py-1 rounded-full text-[10.5px] sm:text-[11px] font-black border whitespace-nowrap {{ $badgeClass }}">
                                                    {{ $meta['label'] }}
                                                </span>
                                                <span class="text-[9.5px] sm:text-[10px] font-medium text-slate-500 dark:text-slate-400 whitespace-nowrap">
                                                    ({{ $role->users_count }} مستخدم)
                                                </span>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs">
                                @foreach ($modules as $modKey => $module)
                                    <!-- Module Section Header Row -->
                                    <tr
                                        class="bg-slate-100 dark:bg-slate-800 font-black text-slate-800 dark:text-slate-100 border-y border-slate-200 dark:border-slate-700">
                                        <td
                                            class="p-2.5 sm:p-3 bg-slate-100 dark:bg-slate-800 border-l border-slate-200 dark:border-slate-700">
                                            <div class="flex items-center space-x-2 space-x-reverse">
                                                <span class="w-2.5 h-2.5 rounded-full bg-purple-500 shadow-xs shrink-0"></span>
                                                <span class="text-xs font-bold text-slate-800 dark:text-slate-100">{{ $module['name'] }}</span>
                                            </div>
                                        </td>

                                        @foreach ($roles as $role)
                                            <td
                                                class="p-2.5 sm:p-3 text-center border-l border-slate-200/40 dark:border-slate-700/60">
                                                @if ($role->name !== 'Super Admin')
                                                    <button type="button"
                                                        @click="toggleModuleForRole('{{ $modKey }}', {{ $role->id }})"
                                                        class="px-2 py-0.5 rounded-full text-[10px] sm:text-[10.5px] font-bold bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-purple-600 hover:text-white dark:hover:bg-purple-600 dark:hover:text-white border border-slate-300 dark:border-slate-600 transition cursor-pointer shadow-2xs whitespace-nowrap">
                                                        تحديد/إلغاء الكل
                                                    </button>
                                                @else
                                                    <span
                                                        class="text-[10px] text-slate-400 dark:text-slate-400 font-bold whitespace-nowrap">مطلقة</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>

                                    <!-- Permissions Rows inside Module -->
                                    @foreach ($module['permissions'] as $permKey => $permDetails)
                                        <tr x-show="matchesSearch('{{ $permKey }}', '{{ $permDetails['label'] }}', '{{ $module['name'] }}')"
                                            class="hover:bg-slate-100/80 dark:hover:bg-slate-800 transition-colors border-b border-slate-100 dark:border-slate-800/60">

                                            <td
                                                class="p-2.5 sm:p-3 border-l border-slate-200 dark:border-slate-800 pr-4 sm:pr-6">
                                                <div class="font-bold text-slate-800 dark:text-slate-100 text-xs">
                                                    {{ $permDetails['label'] }}</div>
                                                <div
                                                    class="text-[10.5px] text-slate-400 dark:text-slate-400 font-mono mt-0.5 dir-ltr text-right">
                                                    {{ $permKey }}</div>
                                            </td>

                                            @foreach ($roles as $role)
                                                @php
                                                    $hasPerm = $role->permissions->contains('name', $permKey);
                                                    $isSuperAdmin = $role->name === 'Super Admin';
                                                @endphp
                                                <td
                                                    class="p-2.5 sm:p-3 text-center border-l border-slate-100 dark:border-slate-800/60">
                                                    <label
                                                        class="inline-flex items-center justify-center cursor-pointer p-1">
                                                        <input type="checkbox"
                                                            name="matrix[{{ $role->id }}][{{ $permKey }}]"
                                                            value="1" data-module="{{ $modKey }}"
                                                            data-role="{{ $role->id }}"
                                                            {{ $hasPerm || $isSuperAdmin ? 'checked' : '' }}
                                                            {{ $isSuperAdmin ? 'disabled' : '' }}
                                                            class="w-4.5 h-4.5 text-purple-600 dark:text-purple-500 rounded-md border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 checked:bg-purple-600 dark:checked:bg-purple-500 focus:ring-purple-500 dark:focus:ring-purple-400 focus:ring-offset-0 dark:focus:ring-offset-0 transition cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">
                                                    </label>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>


        <!-- ========================================================= -->
        <!-- TAB 2: ROLE CARDS GRID -->
        <!-- ========================================================= -->
        <div x-show="activeTab === 'roles'" x-transition:enter="transition ease-out duration-300"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 w-full">
            @foreach ($roles as $role)
                @php
                    $meta = \App\Services\PermissionRegistry::getRoleMetadata($role->name);
                    $roleTheme = [
                        'Super Admin' => [
                            'border' => 'border-rose-200 dark:border-rose-800/60',
                            'glow' => 'bg-rose-500/10 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400',
                            'badge' =>
                                'bg-rose-500/10 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300 border-rose-200 dark:border-rose-800/60',
                        ],
                        'Manager' => [
                            'border' => 'border-indigo-200 dark:border-indigo-800/60',
                            'glow' => 'bg-indigo-500/10 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400',
                            'badge' =>
                                'bg-indigo-500/10 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-800/60',
                        ],
                        'Head of Section' => [
                            'border' => 'border-amber-200 dark:border-amber-800/60',
                            'glow' => 'bg-amber-500/10 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400',
                            'badge' =>
                                'bg-amber-500/10 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-800/60',
                        ],
                        'Secretary' => [
                            'border' => 'border-emerald-200 dark:border-emerald-800/60',
                            'glow' => 'bg-emerald-500/10 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400',
                            'badge' =>
                                'bg-emerald-500/10 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800/60',
                        ],
                        'Viewer' => [
                            'border' => 'border-sky-200 dark:border-sky-800/60',
                            'glow' => 'bg-sky-500/10 dark:bg-sky-950/40 text-sky-600 dark:text-sky-400',
                            'badge' =>
                                'bg-sky-500/10 dark:bg-sky-950/40 text-sky-700 dark:text-sky-300 border-sky-200 dark:border-sky-800/60',
                        ],
                    ];
                    $theme = $roleTheme[$role->name] ?? [
                        'border' => 'border-purple-200 dark:border-purple-800/60',
                        'glow' => 'bg-purple-500/10 dark:bg-purple-950/40 text-purple-600 dark:text-purple-400',
                        'badge' =>
                            'bg-purple-500/10 dark:bg-purple-950/40 text-purple-700 dark:text-purple-300 border-purple-200 dark:border-purple-800/60',
                    ];
                @endphp

                <div
                    class="group relative bg-white dark:bg-slate-800 p-5 rounded-2xl border {{ $theme['border'] }} shadow-sm hover:shadow-lg dark:hover:shadow-xl dark:hover:shadow-black/40 transition-all duration-300 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <!-- Role Card Header -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <div
                                    class="w-11 h-11 rounded-xl {{ $theme['glow'] }} flex items-center justify-center group-hover:scale-105 transition duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base leading-tight">
                                        {{ $meta['label'] }}</h3>
                                    <p
                                        class="text-[11px] font-mono text-slate-400 dark:text-slate-400 dir-ltr text-right mt-0.5">
                                        {{ $role->name }}</p>
                                </div>
                            </div>

                            <span class="px-3 py-1 rounded-full text-xs font-black border {{ $theme['badge'] }}">
                                {{ $role->users_count }} مستخدم
                            </span>
                        </div>

                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed line-clamp-2">
                            {{ $meta['description'] }}
                        </p>

                        <!-- Permission Stats Counter -->
                        <div
                            class="pt-3 border-t border-slate-100 dark:border-slate-700/80 flex items-center justify-between text-xs">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">عدد الأذونات الممنوحة:</span>
                            <span class="font-black text-purple-700 dark:text-purple-300">
                                {{ $role->name === 'Super Admin' ? 'كافة الصلاحيات (مطلقة)' : $role->permissions->count() . ' إذن أمني' }}
                            </span>
                        </div>

                        <!-- Mini Permission Badges Preview -->
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            @foreach ($role->permissions->take(5) as $p)
                                <span
                                    class="px-2.5 py-0.5 rounded-lg text-[10.5px] font-bold bg-slate-100 dark:bg-slate-700/80 text-slate-700 dark:text-slate-200 border border-slate-200/60 dark:border-slate-600/60">
                                    {{ \App\Services\PermissionRegistry::getLabel($p->name) }}
                                </span>
                            @endforeach
                            @if ($role->permissions->count() > 5)
                                <span
                                    class="px-2.5 py-0.5 rounded-lg text-[10.5px] font-black bg-purple-500/10 dark:bg-purple-950/40 text-purple-700 dark:text-purple-300 border border-purple-500/20 dark:border-purple-800/60">
                                    +{{ $role->permissions->count() - 5 }} إضافية
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Role Action Buttons -->
                    <div
                        class="flex items-center space-x-2 space-x-reverse pt-3 border-t border-slate-100 dark:border-slate-700/80">
                        <button type="button"
                            @click="openEditModal({{ json_encode($role) }}, {{ json_encode($role->permissions->pluck('name')) }})"
                            class="btn-pill-sky flex-1 inline-flex items-center justify-center gap-2 h-9 px-4 rounded-full text-xs font-bold transition-all cursor-pointer border border-transparent shadow-xs hover:scale-[1.01]">
                            <span>تعديل الصلاحيات</span>
                        </button>

                        @if (!in_array($role->name, ['Super Admin', 'Manager', 'Head of Section', 'Secretary', 'Viewer']))
                            <form action="{{ route('roles.destroy', $role) }}" method="POST"
                                onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور الوظيفي؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn-pill-red inline-flex items-center justify-center h-9 w-9 rounded-full text-xs font-bold transition-all cursor-pointer shadow-xs hover:scale-[1.05]"
                                    title="حذف الدور">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>


        <!-- ========================================================= -->
        <!-- TAB 3: PERMISSIONS REGISTRY DIRECTORY -->
        <!-- ========================================================= -->
        <div x-show="activeTab === 'registry'" x-transition:enter="transition ease-out duration-300"
            class="space-y-5 w-full">
            @foreach ($modules as $modKey => $module)
                <div
                    class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                    <div
                        class="flex items-center space-x-3 space-x-reverse pb-4 border-b border-slate-100 dark:border-slate-700">
                        <div
                            class="w-10 h-10 rounded-xl bg-purple-500/10 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-800 dark:text-white text-base leading-tight">
                                {{ $module['name'] }}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-medium">
                                {{ $module['description'] }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5 mt-4">
                        @foreach ($module['permissions'] as $permKey => $permDetails)
                            <div
                                class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/60 dark:border-slate-700/80 space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-slate-800 dark:text-slate-100 text-xs">
                                        {{ $permDetails['label'] }}</h4>
                                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-300 leading-relaxed">
                                    {{ $permDetails['description'] }}</p>
                                <div class="pt-0.5">
                                    <span
                                        class="inline-block px-2 py-0.5 rounded-md bg-slate-200/70 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-mono text-[10.5px] border border-slate-300/50 dark:border-slate-600">
                                        {{ $permKey }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>


        <!-- ========================================================= -->
        <!-- CREATE ROLE MODAL -->
        <!-- ========================================================= -->
        <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showCreateModal" x-transition.opacity
                    class="fixed inset-0 bg-slate-950/70 backdrop-blur-md transition-opacity"
                    @click="showCreateModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showCreateModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200 dark:border-slate-700">

                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="p-6 space-y-5">
                            <div
                                class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-purple-500/10 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-black text-slate-800 dark:text-slate-100">إضافة دور وظيفي جديد
                                    </h3>
                                </div>
                                <button type="button" @click="showCreateModal = false"
                                    class="text-slate-400 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-2">مسمى الدور
                                    الوظيفي</label>
                                <input type="text" name="name" required
                                    placeholder="مثال: Quality Auditor / مدقق جودة"
                                    class="w-full h-11 px-4 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:border-purple-500 dark:focus:border-purple-400 focus:ring-1 focus:ring-purple-500 dark:focus:ring-purple-400 focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-2">تحديد
                                    الصلاحيات الممنوحة لهذا الدور:</label>
                                <div class="max-h-72 overflow-y-auto space-y-3.5 pr-1 scrollbar-thin">
                                    @foreach ($modules as $modKey => $module)
                                        <div
                                            class="bg-slate-50 dark:bg-slate-900/60 p-3.5 rounded-xl border border-slate-200/60 dark:border-slate-700/80 space-y-2">
                                            <div
                                                class="font-bold text-xs text-slate-800 dark:text-slate-100 flex items-center justify-between border-b border-slate-200/40 dark:border-slate-700/60 pb-2">
                                                <span>{{ $module['name'] }}</span>
                                            </div>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs pt-1">
                                                @foreach ($module['permissions'] as $permKey => $permDetails)
                                                    <label
                                                        class="flex items-center space-x-2 space-x-reverse cursor-pointer">
                                                        <input type="checkbox" name="permissions[]"
                                                            value="{{ $permKey }}"
                                                            class="w-4 h-4 text-purple-600 dark:text-purple-500 rounded-md border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 focus:ring-purple-500 dark:focus:ring-purple-400 cursor-pointer">
                                                        <span
                                                            class="text-slate-700 dark:text-slate-200 text-[11.5px] font-semibold">{{ $permDetails['label'] }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-slate-50 dark:bg-slate-900/80 px-6 py-4 flex items-center justify-end gap-2.5 border-t border-slate-100 dark:border-slate-700">
                            <button type="button" @click="showCreateModal = false"
                                class="h-10 px-4 inline-flex items-center justify-center bg-slate-200/80 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 text-xs font-bold rounded-xl transition">
                                إلغاء
                            </button>
                            <button type="submit"
                                class="btn-pill-emerald inline-flex items-center gap-2.5 h-10 pr-3.5 pl-1.5 rounded-full text-xs font-bold transition-all cursor-pointer border border-transparent shadow-md hover:scale-[1.02]">
                                <span class="whitespace-nowrap px-0.5 text-white font-bold">حفظ الدور الجديد</span>
                                <span
                                    class="badge-pill-yellow text-slate-950 w-6 h-6 min-w-[24px] rounded-full inline-flex items-center justify-center shrink-0 shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-slate-950" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- ========================================================= -->
        <!-- EDIT ROLE MODAL -->
        <!-- ========================================================= -->
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showEditModal" x-transition.opacity
                    class="fixed inset-0 bg-slate-950/70 backdrop-blur-md transition-opacity"
                    @click="showEditModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showEditModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200 dark:border-slate-700">

                    <form :action="'{{ url('/roles') }}/' + editingRole.id" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="p-6 space-y-5">
                            <div
                                class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-purple-500/10 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-black text-slate-800 dark:text-white">تعديل الدور والصلاحيات
                                    </h3>
                                </div>
                                <button type="button" @click="showEditModal = false"
                                    class="text-slate-400 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-2">مسمى الدور
                                    الوظيفي</label>
                                <input type="text" name="name" x-model="editingRole.name" required
                                    class="w-full h-11 px-4 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 focus:border-purple-500 dark:focus:border-purple-400 focus:ring-1 focus:ring-purple-500 dark:focus:ring-purple-400 focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-2">تحديث
                                    الأذونات المنسوبة للدور:</label>
                                <div class="max-h-72 overflow-y-auto space-y-3.5 pr-1 scrollbar-thin">
                                    @foreach ($modules as $modKey => $module)
                                        <div
                                            class="bg-slate-50 dark:bg-slate-900/60 p-3.5 rounded-xl border border-slate-200/60 dark:border-slate-700/80 space-y-2">
                                            <div
                                                class="font-bold text-xs text-slate-800 dark:text-slate-100 flex items-center justify-between border-b border-slate-200/40 dark:border-slate-700/60 pb-2">
                                                <span>{{ $module['name'] }}</span>
                                            </div>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs pt-1">
                                                @foreach ($module['permissions'] as $permKey => $permDetails)
                                                    <label
                                                        class="flex items-center space-x-2 space-x-reverse cursor-pointer">
                                                        <input type="checkbox" name="permissions[]"
                                                            value="{{ $permKey }}"
                                                            :checked="editingPermissions.includes('{{ $permKey }}')"
                                                            class="w-4 h-4 text-purple-600 dark:text-purple-500 rounded-md border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 focus:ring-purple-500 dark:focus:ring-purple-400 cursor-pointer">
                                                        <span
                                                            class="text-slate-700 dark:text-slate-200 text-[11.5px] font-semibold">{{ $permDetails['label'] }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-slate-50 dark:bg-slate-900/80 px-6 py-4 flex items-center justify-end gap-2.5 border-t border-slate-100 dark:border-slate-700">
                            <button type="button" @click="showEditModal = false"
                                class="h-10 px-4 inline-flex items-center justify-center bg-slate-200/80 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 text-xs font-bold rounded-xl transition">
                                إلغاء
                            </button>
                            <button type="submit"
                                class="btn-pill-sky inline-flex items-center gap-2.5 h-10 pr-3.5 pl-1.5 rounded-full text-xs font-bold transition-all cursor-pointer border border-transparent shadow-md hover:scale-[1.02]">
                                <span class="whitespace-nowrap px-0.5 text-white font-bold">حفظ التعديلات</span>
                                <span
                                    class="badge-pill-yellow text-slate-950 w-6 h-6 min-w-[24px] rounded-full inline-flex items-center justify-center shrink-0 shadow-2xs font-black text-xs">
                                    ✓
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- ========================================================= -->
    <!-- ALPINE MANAGEMENT SCRIPT -->
    <!-- ========================================================= -->
    <script>
        function rolesManagement() {
            return {
                activeTab: 'matrix',
                searchQuery: '',
                showCreateModal: false,
                showEditModal: false,
                editingRole: {},
                editingPermissions: [],

                openCreateModal() {
                    this.showCreateModal = true;
                },

                openEditModal(role, permissions) {
                    this.editingRole = role;
                    this.editingPermissions = permissions;
                    this.showEditModal = true;
                },

                submitMatrixForm() {
                    const form = document.getElementById('matrixForm');
                    if (form) form.submit();
                },

                toggleModuleForRole(moduleKey, roleId) {
                    const checkboxes = document.querySelectorAll(
                        `input[data-module="${moduleKey}"][data-role="${roleId}"]`);
                    if (!checkboxes.length) return;
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                    checkboxes.forEach(cb => {
                        if (!cb.disabled) {
                            cb.checked = !allChecked;
                        }
                    });
                },

                matchesSearch(key, label, moduleName) {
                    if (!this.searchQuery) return true;
                    const q = this.searchQuery.toLowerCase();
                    return key.toLowerCase().includes(q) || label.toLowerCase().includes(q) || moduleName.toLowerCase()
                        .includes(q);
                }
            }
        }
    </script>
@endsection
