@extends('layouts.app')

@section('content')
<style>
    /* ===== أنماط جداول وبطاقات النسخ الاحتياطي الاحترافية ===== */
    .bk-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    .bk-table thead tr th {
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 900;
        background: linear-gradient(to left, #f1f5f9, #f8fafc);
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
        letter-spacing: 0.02em;
        color: #475569;
    }

    .dark .bk-table thead tr th {
        background: linear-gradient(to left, #1e293b, #0f172a);
        border-bottom-color: #334155;
        color: #94a3b8;
    }

    .bk-table tbody tr {
        transition: all 0.15s ease-in-out;
        border-bottom: 1px solid #f1f5f9;
    }

    .dark .bk-table tbody tr {
        border-bottom-color: #1e293b;
    }

    .bk-table tbody tr:nth-child(even) {
        background-color: rgba(248, 250, 252, 0.5);
    }

    .dark .bk-table tbody tr:nth-child(even) {
        background-color: rgba(30, 41, 59, 0.25);
    }

    .bk-table tbody tr:hover {
        background-color: rgba(238, 242, 255, 0.6) !important;
    }

    .dark .bk-table tbody tr:hover {
        background-color: rgba(99, 102, 241, 0.12) !important;
    }

    .bk-table tbody td {
        padding: 11px 16px;
        font-size: 12px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .bk-action-btn {
        height: 32px;
        padding: 0 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }

    .bk-action-btn:hover {
        transform: translateY(-1px);
    }

    .bk-action-btn:active {
        transform: scale(0.95);
    }

    /* حماية أبعاد أيقونات SVG لضمان عدم تمددها */
    svg {
        max-width: 100%;
        max-height: 100%;
    }
</style>

<div class="space-y-6 w-full"
    x-data="{
        filterType: 'all',
        search: '',
        selectedBackups: [],
        uploadModal: false,
        restoreModal: false,
        restoreTarget: null,
        isProcessing: false,
        processingTitle: '',
        processingDesc: '',

        startProcess(title, desc) {
            this.isProcessing = true;
            this.processingTitle = title;
            this.processingDesc = desc;
        },

        triggerRestore(backup) {
            this.restoreTarget = backup;
            this.restoreModal = true;
        },

        toggleSelectAll() {
            if (this.selectedBackups.length === this.filteredCount) {
                this.selectedBackups = [];
            } else {
                this.selectedBackups = this.getVisibleFilenames();
            }
        },

        getVisibleFilenames() {
            const list = {{ json_encode($backups) }};
            return list.filter(b => {
                const matchType = this.filterType === 'all' || (this.filterType === 'full' && b.is_full) || (this.filterType === 'sql' && !b.is_full);
                const matchSearch = !this.search || b.filename.toLowerCase().includes(this.search.toLowerCase());
                return matchType && matchSearch;
            }).map(b => b.filename);
        },

        get filteredCount() {
            return this.getVisibleFilenames().length;
        }
    }">

    <!-- ========================================================================= -->
    <!-- 1. EXECUTIVE HEALTH & ACTIONS HEADER -->
    <!-- ========================================================================= -->
    <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 md:p-6 shadow-sm shadow-slate-200/40 dark:shadow-none backdrop-blur-xl w-full relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-48 h-48 bg-gradient-to-br from-amber-500/10 via-indigo-500/5 to-transparent rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
            {{-- Title & Safety Badge --}}
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-900 via-indigo-900 to-indigo-800 flex items-center justify-center text-amber-400 shadow-xl shadow-blue-900/25 shrink-0 ring-2 ring-white/20">
                    <svg class="w-6 h-6 shrink-0" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h1 class="text-xl sm:text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight">
                            النسخ الاحتياطي وإدارة الطوارئ
                        </h1>

                        {{-- Live Safety Health Badge --}}
                        @if($backupSummary['safety_status'] === 'optimal')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>{{ $backupSummary['safety_label'] }}</span>
                            </span>
                        @elseif($backupSummary['safety_status'] === 'good')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200/80 dark:border-blue-800/60">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <span>{{ $backupSummary['safety_label'] }}</span>
                            </span>
                        @elseif($backupSummary['safety_status'] === 'warning')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800/60">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                                <span>{{ $backupSummary['safety_label'] }}</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 border border-rose-200/80 dark:border-rose-800/60">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                <span>{{ $backupSummary['safety_label'] }}</span>
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">
                        إنشاء وتنزيل واستعادة النسخ الاحتياطية لقاعدة البيانات والملفات لضمان سلامة وحفظ البيانات واستمرارية العمل
                    </p>
                </div>
            </div>

            {{-- 3 High-End Action Buttons --}}
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                {{-- زر رفع نسخة خارجية --}}
                <button type="button" @click="uploadModal = true"
                    class="h-10 px-4 rounded-xl text-xs font-black bg-slate-100 dark:bg-slate-700/70 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200/80 dark:border-slate-600 transition-all duration-200 inline-flex items-center gap-2 shadow-xs cursor-pointer active:scale-95">
                    <svg class="w-4 h-4 text-indigo-500 shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    <span>رفع نسخة من جهازك</span>
                </button>

                {{-- زر إنشاء نسخة شاملة ZIP للمشروع بالكامل --}}
                <form action="{{ route('backups.storeFull') }}" method="POST"
                    @submit="startProcess('جاري إنشاء النسخة الشاملة للمشروع (ZIP)...', 'يتم ضغط ملفات النظام والمرفقات وتصدير قاعدة البيانات بالكامل. قد يستغرق هذا بضع ثوانٍ...')">
                    @csrf
                    <button type="submit"
                        class="h-10 px-4 bg-gradient-to-l from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 font-black rounded-xl shadow-md shadow-amber-500/20 active:scale-[0.98] transition-all duration-200 inline-flex items-center gap-2 cursor-pointer text-xs">
                        <svg class="w-4 h-4 text-slate-950 shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 012-2h10a2 2 0 012 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        <span>نسخ كامل للمشروع (ZIP)</span>
                        <span class="w-5 h-5 rounded bg-slate-950/15 inline-flex items-center justify-center text-[10px]">📦</span>
                    </button>
                </form>

                {{-- زر إنشاء نسخة قاعدة البيانات SQL --}}
                <form action="{{ route('backups.store') }}" method="POST"
                    @submit="startProcess('جاري تصدير قاعدة البيانات (SQL)...', 'يتم استخراج وتوليد ملف تفريغ SQL لكافة الجداول والعلاقات بدقة وأمان...')">
                    @csrf
                    <button type="submit"
                        class="h-10 px-4 bg-gradient-to-l from-blue-900 via-indigo-900 to-indigo-800 hover:from-blue-950 hover:to-indigo-900 text-white font-black rounded-xl shadow-md shadow-blue-900/25 active:scale-[0.98] transition-all duration-200 inline-flex items-center gap-2 cursor-pointer text-xs">
                        <svg class="w-4 h-4 text-amber-400 shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                        </svg>
                        <span>نسخ قاعدة البيانات (SQL)</span>
                        <span class="w-5 h-5 rounded bg-white/20 text-amber-300 inline-flex items-center justify-center font-black text-xs">+</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 2. ENHANCED KPI STATS GRID (4 CARDS) -->
    <!-- ========================================================================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 w-full">
        {{-- بطاقة 1: قاعدة البيانات الحالية --}}
        <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-sm shadow-slate-200/30 dark:shadow-none flex items-center justify-between gap-3 backdrop-blur-xl">
            <div class="space-y-1">
                <p class="text-[11px] font-bold text-slate-400">قاعدة البيانات النشطة</p>
                <p class="text-sm font-black text-slate-800 dark:text-slate-100 font-mono tracking-tight">{{ $dbStats['db_name'] }}</p>
                <div class="flex items-center gap-1.5 text-[10px] text-emerald-600 dark:text-emerald-400 font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>محرك MySQL متصل بنجاح</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center border border-blue-200/60 dark:border-blue-800/50 shrink-0">
                <svg class="w-6 h-6 shrink-0" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                </svg>
            </div>
        </div>

        {{-- بطاقة 2: حجم البيانات والسجلات --}}
        <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-sm shadow-slate-200/30 dark:shadow-none flex items-center justify-between gap-3 backdrop-blur-xl">
            <div class="space-y-1">
                <p class="text-[11px] font-bold text-slate-400">حجم البيانات والسجلات</p>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-base font-black text-slate-800 dark:text-slate-100 font-mono">{{ $dbStats['total_size'] }}</span>
                    <span class="text-[11px] text-slate-400 font-medium">({{ $dbStats['table_count'] }} جدول)</span>
                </div>
                <p class="text-[10px] text-indigo-600 dark:text-indigo-400 font-bold font-mono">
                    {{ $dbStats['total_rows'] }} سجل مخزن
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center border border-emerald-200/60 dark:border-emerald-800/50 shrink-0">
                <svg class="w-6 h-6 shrink-0" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>

        {{-- بطاقة 3: إجمالي الأرشيف المحفوظ --}}
        <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-sm shadow-slate-200/30 dark:shadow-none flex items-center justify-between gap-3 backdrop-blur-xl">
            <div class="space-y-1">
                <p class="text-[11px] font-bold text-slate-400">سعة الأرشيف الاحتياطي</p>
                <div class="flex items-baseline gap-1.5">
                    <span class="text-base font-black text-slate-800 dark:text-slate-100 font-mono">{{ $backupSummary['total_storage'] }}</span>
                    <span class="text-[11px] text-slate-400 font-medium">({{ $backupSummary['total_count'] }} ملف)</span>
                </div>
                <p class="text-[10px] text-purple-600 dark:text-purple-400 font-bold">
                    {{ $backupSummary['sql_count'] }} SQL &bull; {{ $backupSummary['full_count'] }} ZIP
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center border border-purple-200/60 dark:border-purple-800/50 shrink-0">
                <svg class="w-6 h-6 shrink-0" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 012-2h10a2 2 0 012 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
            </div>
        </div>

        {{-- بطاقة 4: آخر نقطة استعادة --}}
        <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-sm shadow-slate-200/30 dark:shadow-none flex items-center justify-between gap-3 backdrop-blur-xl">
            <div class="space-y-1">
                <p class="text-[11px] font-bold text-slate-400">آخر نقطة استعادة متاحة</p>
                @if($backupSummary['latest'])
                    <p class="text-xs font-black text-slate-800 dark:text-slate-100 font-mono">
                        {{ $backupSummary['latest']['human_time'] }}
                    </p>
                    <p class="text-[10px] text-slate-400 font-mono">
                        {{ $backupSummary['latest']['created_date'] }}
                    </p>
                @else
                    <p class="text-xs font-bold text-rose-500">لم تنشأ بعد</p>
                    <p class="text-[10px] text-slate-400">اضغط لإنشاء الأولى</p>
                @endif
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center border border-amber-200/60 dark:border-amber-800/50 shrink-0">
                <svg class="w-6 h-6 shrink-0" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 3. ARCHIVE EXPLORER & MANAGEMENT TABLE -->
    <!-- ========================================================================= -->
    <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 shadow-md shadow-slate-200/30 dark:shadow-none overflow-hidden backdrop-blur-xl w-full">
        
        {{-- Toolbar: Tabs Filter + Search --}}
        <div class="p-4 bg-slate-50/70 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700/80 flex flex-col md:flex-row items-center justify-between gap-3.5">
            
            {{-- Tabs Filter --}}
            <div class="flex items-center gap-1.5 p-1 bg-slate-200/60 dark:bg-slate-900/80 rounded-2xl border border-slate-200 dark:border-slate-700 w-full sm:w-auto overflow-x-auto">
                <button type="button" @click="filterType = 'all'"
                    :class="filterType === 'all' ? 'bg-white dark:bg-slate-800 text-blue-900 dark:text-blue-400 font-black shadow-sm' : 'text-slate-600 dark:text-slate-400 font-bold hover:text-slate-900'"
                    class="px-3.5 py-1.5 rounded-xl text-xs flex items-center gap-2 transition cursor-pointer whitespace-nowrap">
                    <span>كافة النسخ</span>
                    <span class="px-1.5 py-0.2 rounded-md text-[10px] bg-slate-100 dark:bg-slate-700 font-mono font-black">{{ count($backups) }}</span>
                </button>

                <button type="button" @click="filterType = 'sql'"
                    :class="filterType === 'sql' ? 'bg-white dark:bg-slate-800 text-blue-900 dark:text-blue-400 font-black shadow-sm' : 'text-slate-600 dark:text-slate-400 font-bold hover:text-slate-900'"
                    class="px-3.5 py-1.5 rounded-xl text-xs flex items-center gap-2 transition cursor-pointer whitespace-nowrap">
                    <span>قواعد بيانات (SQL)</span>
                    <span class="px-1.5 py-0.2 rounded-md text-[10px] bg-blue-100 dark:bg-blue-950 text-blue-700 dark:text-blue-300 font-mono font-black">{{ $backupSummary['sql_count'] }}</span>
                </button>

                <button type="button" @click="filterType = 'full'"
                    :class="filterType === 'full' ? 'bg-white dark:bg-slate-800 text-blue-900 dark:text-blue-400 font-black shadow-sm' : 'text-slate-600 dark:text-slate-400 font-bold hover:text-slate-900'"
                    class="px-3.5 py-1.5 rounded-xl text-xs flex items-center gap-2 transition cursor-pointer whitespace-nowrap">
                    <span>حزم شاملة (ZIP)</span>
                    <span class="px-1.5 py-0.2 rounded-md text-[10px] bg-purple-100 dark:bg-purple-950 text-purple-700 dark:text-purple-300 font-mono font-black">{{ $backupSummary['full_count'] }}</span>
                </button>
            </div>

            {{-- Live Search Input --}}
            <div class="relative w-full md:w-80">
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4 shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" x-model="search" placeholder="بحث باسم الملف أو التاريخ..."
                    class="w-full pl-8 pr-9 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-xs font-medium focus:outline-none transition">
                <button type="button" x-show="search.length > 0" @click="search = ''"
                    class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 hover:text-slate-600">
                    <svg class="w-3.5 h-3.5 shrink-0" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Table --}}
        @if(count($backups) > 0)
            <div class="overflow-x-auto w-full">
                <table class="bk-table text-right">
                    <thead>
                        <tr>
                            <th class="w-12 text-center">
                                <input type="checkbox" @change="toggleSelectAll()"
                                    :checked="selectedBackups.length > 0 && selectedBackups.length === filteredCount"
                                    class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            </th>
                            <th>اسم ملف النسخة الاحتياطية</th>
                            <th>نوع الحزمة</th>
                            <th>الحجم التخزيني</th>
                            <th>تاريخ ووقت الإنشاء</th>
                            <th class="text-center w-48">إجراءات الأرشيف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($backups as $backup)
                            <tr class="group"
                                x-show="(filterType === 'all' || (filterType === 'full' && {{ $backup['is_full'] ? 'true' : 'false' }}) || (filterType === 'sql' && {{ !$backup['is_full'] ? 'true' : 'false' }})) && (!search || '{{ strtolower($backup['filename']) }} {{ $backup['created_at'] }}'.includes(search.toLowerCase()))">
                                
                                {{-- Checkbox --}}
                                <td class="text-center">
                                    <input type="checkbox" value="{{ $backup['filename'] }}" x-model="selectedBackups"
                                        class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                </td>

                                {{-- Filename --}}
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 {{ $backup['is_full'] ? 'bg-purple-100 dark:bg-purple-950/70 text-purple-600 dark:text-purple-400 border border-purple-200/70 dark:border-purple-800/60' : 'bg-blue-100 dark:bg-blue-950/70 text-blue-600 dark:text-blue-400 border border-blue-200/70 dark:border-blue-800/60' }}">
                                            @if($backup['is_full'])
                                                <svg class="w-4 h-4 shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 012-2h10a2 2 0 012 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-mono font-black text-slate-800 dark:text-slate-100 text-xs block select-all">{{ $backup['filename'] }}</span>
                                            <span class="text-[10px] text-slate-400 font-medium">
                                                {{ $backup['is_full'] ? 'أرشيف مضغوط ZIP شامل كود المشروع وقاعدة البيانات' : 'ملف تفريغ SQL مباشر لجداول قاعدة البيانات' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Type Badge --}}
                                <td>
                                    @if($backup['is_full'])
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 font-black border border-purple-200/70 dark:border-purple-800/60 text-[11px]">
                                            <span>📦</span>
                                            <span>حزمة كاملة ZIP</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 font-black border border-blue-200/70 dark:border-blue-800/60 text-[11px]">
                                            <span>💾</span>
                                            <span>قاعدة بيانات SQL</span>
                                        </span>
                                    @endif
                                </td>

                                {{-- File Size --}}
                                <td>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 font-mono text-xs font-black text-slate-700 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700">
                                        {{ $backup['size'] }}
                                    </span>
                                </td>

                                {{-- Creation Date & Hijri --}}
                                <td>
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-1.5 font-mono text-xs font-bold text-slate-700 dark:text-slate-300">
                                            <span>{{ $backup['created_date'] }}</span>
                                            <span class="text-slate-400 text-[10px]">{{ $backup['created_time'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-[10px] text-slate-400 mt-0.5 font-medium">
                                            <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $backup['human_time'] }}</span>
                                            <span>&bull;</span>
                                            <span class="text-emerald-600 dark:text-emerald-400 font-serif">🌙 {{ hijri_date($backup['created_at']) }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Action Buttons --}}
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        {{-- تنزيل --}}
                                        <a href="{{ route('backups.download', $backup['filename']) }}" title="تنزيل الملف"
                                            class="bk-action-btn bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/60 dark:hover:bg-blue-900/70 text-blue-700 dark:text-blue-300 border-blue-200/70 dark:border-blue-800/60">
                                            <svg class="w-3.5 h-3.5 shrink-0" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            <span>تحميل</span>
                                        </a>

                                        {{-- استعادة آمنة --}}
                                        <button type="button" @click="triggerRestore({{ json_encode($backup) }})" title="استعادة هذه النسخة"
                                            class="bk-action-btn bg-purple-50 hover:bg-purple-100 dark:bg-purple-950/60 dark:hover:bg-purple-900/70 text-purple-700 dark:text-purple-300 border-purple-200/70 dark:border-purple-800/60">
                                            <svg class="w-3.5 h-3.5 shrink-0" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            <span>استعادة</span>
                                        </button>

                                        {{-- حذف --}}
                                        <form action="{{ route('backups.destroy', $backup['filename']) }}" method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف ملف النسخة الاحتياطية نهائياً؟ لا يمكن التراجع عن هذا الإجراء.');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="حذف"
                                                class="bk-action-btn bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/60 dark:hover:bg-rose-900/70 text-rose-600 dark:text-rose-400 border-rose-200/70 dark:border-rose-800/60">
                                                <svg class="w-3.5 h-3.5 shrink-0" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                <span>حذف</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center space-y-3">
                <div class="w-16 h-16 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 shrink-0" width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s-8-1.79-8-4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                    </svg>
                </div>
                <h3 class="text-base font-black text-slate-800 dark:text-slate-100">لا توجد نسخ احتياطية محفوظة</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm mx-auto font-medium">
                    قم بإنشاء نسخة احتياطية جديدة أو رفع ملف من جهازك لبدء حماية بيانات النظام.
                </p>
            </div>
        @endif

        {{-- Floating Multi-Select Action Bar --}}
        <div x-show="selectedBackups.length > 0" x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="sticky bottom-4 z-40 mx-4 my-3 p-3.5 bg-slate-900/95 dark:bg-slate-950/95 text-white rounded-2xl shadow-2xl backdrop-blur-xl border border-slate-700/80 flex items-center justify-between gap-4">
            
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-xl bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 flex items-center justify-center font-mono font-black text-xs" x-text="selectedBackups.length"></span>
                <div>
                    <h4 class="text-xs font-black text-slate-100">تم تحديد <span x-text="selectedBackups.length"></span> ملف</h4>
                    <p class="text-[10px] text-slate-400">يمكنك حذف النسخ المحددة دفعة واحدة</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" @click="selectedBackups = []"
                    class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-bold transition">
                    إلغاء التحديد
                </button>

                <form action="{{ route('backups.bulkDestroy') }}" method="POST"
                    onsubmit="return confirm('تحذير نهائي: هل أنت متأكد من رغبتك في حذف النسخ الاحتياطية المحددة نهائياً؟');">
                    @csrf
                    @method('DELETE')
                    <template x-for="fn in selectedBackups" :key="fn">
                        <input type="hidden" name="filenames[]" :value="fn">
                    </template>
                    <button type="submit"
                        class="px-4 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-black transition flex items-center gap-1.5 shadow-md">
                        <svg class="w-3.5 h-3.5 shrink-0" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>حذف المحدد</span>
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- ========================================================================= -->
    <!-- 4. MODAL: UPLOAD EXTERNAL BACKUP -->
    <!-- ========================================================================= -->
    <div x-show="uploadModal" x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @keydown.escape.window="uploadModal = false">

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-2xl w-full max-w-lg overflow-hidden transform transition-all"
            @click.away="uploadModal = false">
            <div class="px-6 py-4 bg-gradient-to-l from-blue-900/10 via-indigo-900/5 to-transparent dark:from-slate-700/40 dark:to-slate-800 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-900 to-indigo-800 flex items-center justify-center text-amber-400 shadow-md shrink-0">
                        <svg class="w-4 h-4 shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-800 dark:text-slate-100">رفع نسخة احتياطية من جهازك</h3>
                        <p class="text-[10px] text-slate-400 mt-0.5 font-medium">اختر ملف SQL أو ZIP لحفظه في أرشيف السيرفر</p>
                    </div>
                </div>
                <button type="button" @click="uploadModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <svg class="w-5 h-5 shrink-0" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('backups.upload') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-xs"
                @submit="startProcess('جاري رفع ومعالجة ملف النسخة...', 'يتم التحقق من سلامة الملف وتهيئته للتخزين في أرشيف السيرفر...')">
                @csrf
                <div>
                    <label class="font-bold text-slate-700 dark:text-slate-300 block mb-2">اختر ملف النسخة (.sql أو .zip) *</label>
                    <div class="border-2 border-dashed border-slate-300 dark:border-slate-600 hover:border-indigo-500 rounded-2xl p-6 text-center transition bg-slate-50/50 dark:bg-slate-900/50">
                        <svg class="w-10 h-10 mx-auto text-indigo-400 mb-2 shrink-0" width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <input type="file" name="backup_file" required accept=".sql,.zip,.gz"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-2">الحد الأقصى لحجم الملف المسموح: 512 ميغابايت</p>
                    </div>
                </div>

                <div class="pt-3 flex justify-end gap-2.5">
                    <button type="button" @click="uploadModal = false" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-xl font-bold transition">إلغاء</button>
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-l from-blue-900 to-indigo-800 text-white font-bold rounded-xl shadow-md">بدء الرفع والحفظ</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 5. MODAL: SAFE RESTORE CONFIRMATION -->
    <!-- ========================================================================= -->
    <div x-show="restoreModal" x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @keydown.escape.window="restoreModal = false">

        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-rose-200 dark:border-rose-900/60 shadow-2xl w-full max-w-md overflow-hidden transform transition-all"
            @click.away="restoreModal = false">
            <div class="p-6 text-center space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto border border-rose-500/20">
                    <svg class="w-8 h-8 shrink-0" width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <div>
                    <h3 class="text-base font-black text-slate-800 dark:text-slate-100">تأكيد استعادة النسخة الاحتياطية</h3>
                    <p class="text-xs text-rose-600 dark:text-rose-400 font-bold mt-1">
                        ⚠️ تحذير: هذه العملية ستقوم باستبدال بيانات الجداول الحالية بالبيانات المحفوظة في هذه النسخة!
                    </p>
                </div>

                {{-- تفاصيل النسخة المستهدفة --}}
                <div class="bg-slate-50 dark:bg-slate-900/70 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 text-right text-xs space-y-1.5" x-show="restoreTarget">
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-bold">الملف:</span>
                        <span class="font-mono font-bold text-slate-700 dark:text-slate-200" x-text="restoreTarget ? restoreTarget.filename : ''"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-bold">الحجم:</span>
                        <span class="font-mono font-bold text-indigo-600 dark:text-indigo-400" x-text="restoreTarget ? restoreTarget.size : ''"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-bold">تاريخ الإنشاء:</span>
                        <span class="font-mono text-slate-600 dark:text-slate-300" x-text="restoreTarget ? restoreTarget.created_at : ''"></span>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-3 pt-2">
                    <button type="button" @click="restoreModal = false"
                        class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-xl font-bold text-xs transition">
                        إلغاء وتراجع
                    </button>

                    <template x-if="restoreTarget">
                        <form x-bind:action="'{{ url('backups') }}/' + restoreTarget.filename + '/restore'" method="POST"
                            @submit="restoreModal = false; startProcess('جاري تنفيذ استعادة قاعدة البيانات...', 'يتم قراءة وتنفيذ أوامر SQL وإعادة بناء الجداول والسجلات. يرجى عدم إغلاق المتصفح حتى الاكتمال...')">
                            @csrf
                            <button type="submit"
                                class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-black rounded-xl text-xs shadow-lg shadow-rose-600/30 transition">
                                نعم، استعد الآن
                            </button>
                        </form>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 6. HIGH-TECH PROCESSING OVERLAY (SPINNER & PROGRESS) -->
    <!-- ========================================================================= -->
    <div x-show="isProcessing" x-cloak
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4">
        
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-2xl p-8 max-w-md w-full text-center space-y-5">
            <div class="relative w-20 h-20 mx-auto">
                <div class="absolute inset-0 rounded-full border-4 border-indigo-500/20"></div>
                <div class="absolute inset-0 rounded-full border-4 border-indigo-500 border-t-transparent animate-spin"></div>
                <div class="absolute inset-3 rounded-full bg-gradient-to-br from-blue-900 to-indigo-800 flex items-center justify-center text-amber-400 shadow-inner">
                    <svg class="w-7 h-7 shrink-0 animate-pulse" width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                </div>
            </div>

            <div>
                <h3 class="text-base font-black text-slate-800 dark:text-slate-100" x-text="processingTitle"></h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed" x-text="processingDesc"></p>
            </div>

            <div class="p-3 bg-indigo-50 dark:bg-indigo-950/50 rounded-2xl border border-indigo-100 dark:border-indigo-800/50 text-[11px] text-indigo-700 dark:text-indigo-300 font-bold flex items-center justify-center gap-2">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-ping"></span>
                <span>العملية قيد التنفيذ بأمان، يرجى الانتظار...</span>
            </div>
        </div>
    </div>

</div>
@endsection
