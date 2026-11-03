@extends('layouts.app')

@section('content')
    <style>
        .lk-modern-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .lk-modern-table thead tr th {
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 900;
            background: linear-gradient(to left, #f1f5f9, #f8fafc);
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
            letter-spacing: 0.02em;
            color: #475569;
        }

        .dark .lk-modern-table thead tr th {
            background: linear-gradient(to left, #1e293b, #0f172a);
            border-bottom-color: #334155;
            color: #94a3b8;
        }

        .lk-modern-table tbody tr {
            transition: all 0.15s ease-in-out;
            border-bottom: 1px solid #f1f5f9;
        }

        .dark .lk-modern-table tbody tr {
            border-bottom-color: #1e293b;
        }

        .lk-modern-table tbody tr:nth-child(even) {
            background-color: rgba(248, 250, 252, 0.6);
        }

        .dark .lk-modern-table tbody tr:nth-child(even) {
            background-color: rgba(30, 41, 59, 0.3);
        }

        .lk-modern-table tbody tr:hover {
            background-color: rgba(224, 231, 255, 0.45) !important;
        }

        .dark .lk-modern-table tbody tr:hover {
            background-color: rgba(99, 102, 241, 0.15) !important;
        }

        .lk-modern-table tbody td {
            padding: 9px 14px;
            font-size: 12.5px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .lk-btn-action {
            width: 30px;
            height: 30px;
            min-width: 30px;
            min-height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
        }

        .lk-btn-action:hover {
            transform: translateY(-1px);
        }

        .lk-btn-action:active {
            transform: scale(0.92);
        }

        .color-circle {
            width: 22px;
            height: 22px;
            border-radius: 9999px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .color-circle:hover {
            transform: scale(1.18);
        }

        .color-circle.active {
            box-shadow: 0 0 0 2.5px #fff, 0 0 0 4.5px #4f46e5;
            transform: scale(1.15);
        }

        .dark .color-circle.active {
            box-shadow: 0 0 0 2.5px #0f172a, 0 0 0 4.5px #818cf8;
        }

        .lk-layout-flex {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            width: 100%;
            align-items: flex-start;
        }

        @media (min-width: 1024px) {
            .lk-layout-flex {
                flex-direction: row !important;
            }
            .lk-form-col {
                width: 360px !important;
                flex: 0 0 360px !important;
                max-width: 360px !important;
            }
            .lk-table-col {
                flex: 1 1 0% !important;
                min-width: 0 !important;
                width: calc(100% - 384px) !important;
            }
        }
    </style>

    @php
        $currentTab = request('tab', session('tab', 'units'));
        $colorsList = [
            ['key' => 'indigo', 'name' => 'نيلي / أرجواني', 'hex' => '#6366f1', 'bg' => 'bg-indigo-500'],
            ['key' => 'blue', 'name' => 'أزرق ملكي', 'hex' => '#3b82f6', 'bg' => 'bg-blue-500'],
            ['key' => 'emerald', 'name' => 'أخضر زمردي', 'hex' => '#10b981', 'bg' => 'bg-emerald-500'],
            ['key' => 'amber', 'name' => 'أصفر / كهرماني', 'hex' => '#f59e0b', 'bg' => 'bg-amber-500'],
            ['key' => 'purple', 'name' => 'بنفسجي ملكي', 'hex' => '#a855f7', 'bg' => 'bg-purple-500'],
            ['key' => 'rose', 'name' => 'أحمر وردي', 'hex' => '#f43f5e', 'bg' => 'bg-rose-500'],
            ['key' => 'teal', 'name' => 'تركوازي', 'hex' => '#14b8a6', 'bg' => 'bg-teal-500'],
            ['key' => 'cyan', 'name' => 'سماوي', 'hex' => '#06b6d4', 'bg' => 'bg-cyan-500'],
            ['key' => 'orange', 'name' => 'برتقالي ناري', 'hex' => '#f97316', 'bg' => 'bg-orange-500'],
            ['key' => 'slate', 'name' => 'رمادي محايد', 'hex' => '#64748b', 'bg' => 'bg-slate-500'],
        ];
    @endphp

    <div class="space-y-6 w-full max-w-7xl mx-auto pb-12"
        x-data="{
            tab: '{{ $currentTab }}',
            search: '',
            editModal: false,
            editType: '',
            editData: {},
            addName: '',
            addColor: 'indigo',
            addCode: '',
            openEdit(type, data) {
                this.editType = type;
                this.editData = Object.assign({}, data);
                this.editModal = true;
            }
        }">

        <!-- ================= 1. Header Banner ================= -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-l from-amber-500/10 via-amber-500/5 to-white dark:from-amber-950/60 dark:via-slate-900 dark:to-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-sm">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/30 flex items-center justify-center shadow-xs shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-black text-slate-800 dark:text-white font-readex tracking-tight">
                            إدارة القوائم المساعدة والترميز
                        </h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">
                            تخصيص وإدارة الأقسام والوحدات الإدارية، المحافظات والمناطق الجغرافية، والعملات المتعددة
                        </p>
                    </div>
                </div>

                <!-- Navigation Tabs Pills -->
                <div class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800/80 p-1.5 rounded-2xl border border-slate-200/80 dark:border-slate-700 self-start md:self-auto">
                    <button type="button" @click="tab = 'units'"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer"
                        :class="tab === 'units' ? 'bg-white dark:bg-slate-700 text-amber-900 dark:text-amber-300 shadow-md font-black' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                        🏢 الوحدات والأقسام ({{ $units->count() }})
                    </button>

                    <button type="button" @click="tab = 'governorates'"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer"
                        :class="tab === 'governorates' ? 'bg-white dark:bg-slate-700 text-amber-900 dark:text-amber-300 shadow-md font-black' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                        📍 المحافظات والمدن ({{ $governorates->count() }})
                    </button>

                    <button type="button" @click="tab = 'currencies'"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer"
                        :class="tab === 'currencies' ? 'bg-white dark:bg-slate-700 text-amber-900 dark:text-amber-300 shadow-md font-black' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                        💰 إدارة العملات ({{ $currencies->count() }})
                    </button>
                </div>
            </div>
        </div>

        <!-- ================= 2. TAB 1: Units & Departments ================= -->
        <div x-show="tab === 'units'" x-cloak class="lk-layout-flex">
            <!-- Add Form -->
            <div class="lk-form-col w-full bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 rounded-3xl p-5 shadow-xs">
                <div class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-100 dark:border-slate-700">
                    <span class="w-8 h-8 rounded-xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center font-bold text-sm">🏢</span>
                    <h3 class="text-sm font-black text-slate-800 dark:text-slate-100 font-readex">إضافة وحدة / قسم إداري</h3>
                </div>

                <form method="POST" action="{{ route('lookups.units.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">اسم القسم / الوحدة <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="مثال: إدارة تقنية المعلومات"
                            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">رمز / كود الوحدة</label>
                        <input type="text" name="code" placeholder="مثال: IT-01"
                            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">الوصف أو الملاحظات</label>
                        <textarea name="description" rows="2" placeholder="نبذة مختصرة عن مهام الوحدة..."
                            class="w-full px-3.5 py-2 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">لون التمييز البصري</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($colorsList as $c)
                                <label class="cursor-pointer">
                                    <input type="radio" name="color_code" value="{{ $c['key'] }}" class="hidden peer" {{ $loop->first ? 'checked' : '' }}>
                                    <span class="color-circle {{ $c['bg'] }} block peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-indigo-500" title="{{ $c['name'] }}"></span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs transition shadow-md flex items-center justify-center gap-2 cursor-pointer mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>حفظ الوحدة الإدارية</span>
                    </button>
                </form>
            </div>

            <!-- Table -->
            <div class="lk-table-col w-full bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 rounded-3xl p-5 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-black text-slate-800 dark:text-slate-100 font-readex">
                        قائمة الوحدات والأقسام الإدارية ({{ $units->count() }})
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="lk-modern-table text-right">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الوحدة / القسم</th>
                                <th>الكود</th>
                                <th>الوصف</th>
                                <th>اللون</th>
                                <th class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($units as $u)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-bold text-slate-900 dark:text-white">{{ $u->name }}</td>
                                    <td>
                                        <span class="font-mono text-xs px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                                            {{ $u->code ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="text-slate-500 dark:text-slate-400 text-xs">{{ $u->description ?? '—' }}</td>
                                    <td>
                                        <span class="inline-block w-3.5 h-3.5 rounded-full bg-{{ $u->color_code ?? 'indigo' }}-500 ring-2 ring-white dark:ring-slate-800"></span>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button type="button" @click="openEdit('unit', {{ $u->toJson() }})"
                                                class="lk-btn-action bg-blue-50 hover:bg-blue-100 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400" title="تعديل">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <form method="POST" action="{{ route('lookups.units.destroy', $u) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذه الوحدة؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="lk-btn-action bg-rose-50 hover:bg-rose-100 text-rose-600 dark:bg-rose-950/60 dark:text-rose-400" title="حذف">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-slate-400">لا توجد وحدات إدارية مضافة بعد.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ================= 3. TAB 2: Governorates & Locations ================= -->
        <div x-show="tab === 'governorates'" x-cloak class="lk-layout-flex">
            <!-- Add Form -->
            <div class="lk-form-col w-full bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 rounded-3xl p-5 shadow-xs">
                <div class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-100 dark:border-slate-700">
                    <span class="w-8 h-8 rounded-xl bg-blue-500/10 text-blue-600 flex items-center justify-center font-bold text-sm">📍</span>
                    <h3 class="text-sm font-black text-slate-800 dark:text-slate-100 font-readex">إضافة محافظة / منطقة</h3>
                </div>

                <form method="POST" action="{{ route('lookups.governorates.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">اسم المحافظة / المدينة <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="مثال: صنعاء"
                            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">الرمز / الكود</label>
                        <input type="text" name="code" placeholder="مثال: SNA"
                            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">لون التمييز البصري</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($colorsList as $c)
                                <label class="cursor-pointer">
                                    <input type="radio" name="color_code" value="{{ $c['key'] }}" class="hidden peer" {{ $loop->first ? 'checked' : '' }}>
                                    <span class="color-circle {{ $c['bg'] }} block peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-blue-500" title="{{ $c['name'] }}"></span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs transition shadow-md flex items-center justify-center gap-2 cursor-pointer mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>حفظ المحافظة</span>
                    </button>
                </form>
            </div>

            <!-- Table -->
            <div class="lk-table-col w-full bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 rounded-3xl p-5 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-black text-slate-800 dark:text-slate-100 font-readex">
                        قائمة المحافظات والمناطق ({{ $governorates->count() }})
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="lk-modern-table text-right">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المحافظة</th>
                                <th>الرمز</th>
                                <th>اللون</th>
                                <th class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($governorates as $g)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-bold text-slate-900 dark:text-white">{{ $g->name }}</td>
                                    <td>
                                        <span class="font-mono text-xs px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                                            {{ $g->code ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="inline-block w-3.5 h-3.5 rounded-full bg-{{ $g->color_code ?? 'blue' }}-500 ring-2 ring-white dark:ring-slate-800"></span>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button type="button" @click="openEdit('governorate', {{ $g->toJson() }})"
                                                class="lk-btn-action bg-blue-50 hover:bg-blue-100 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400" title="تعديل">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <form method="POST" action="{{ route('lookups.governorates.destroy', $g) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذه المحافظة؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="lk-btn-action bg-rose-50 hover:bg-rose-100 text-rose-600 dark:bg-rose-950/60 dark:text-rose-400" title="حذف">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-slate-400">لا توجد محافظات مضافة بعد.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ================= 4. TAB 3: Currencies ================= -->
        <div x-show="tab === 'currencies'" x-cloak class="lk-layout-flex">
            <!-- Add Form -->
            <div class="lk-form-col w-full bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 rounded-3xl p-5 shadow-xs">
                <div class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-100 dark:border-slate-700">
                    <span class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold text-sm">💰</span>
                    <h3 class="text-sm font-black text-slate-800 dark:text-slate-100 font-readex">إضافة عملة جديدة</h3>
                </div>

                <form method="POST" action="{{ route('lookups.currencies.store') }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">رمز العملة (ISO) <span class="text-rose-500">*</span></label>
                            <input type="text" name="code" required placeholder="USD" maxlength="10"
                                class="w-full px-3.5 py-2.5 rounded-xl text-xs uppercase font-mono font-bold border border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">علم الدولة (Emoji)</label>
                            <input type="text" name="flag" placeholder="🇺🇸" maxlength="10"
                                class="w-full px-3.5 py-2.5 rounded-xl text-xs text-center border border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">اسم العملة الكامل <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="الدولار الأمريكي"
                            class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">رمز العرض <span class="text-rose-500">*</span></label>
                            <input type="text" name="symbol" required placeholder="$"
                                class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">سعر الصرف <span class="text-rose-500">*</span></label>
                            <input type="number" step="0.0001" name="exchange_rate" value="1.0000" required
                                class="w-full px-3.5 py-2.5 rounded-xl text-xs font-mono border border-slate-200 dark:border-slate-700 dark:bg-slate-900 focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700 dark:text-slate-300">
                            <input type="checkbox" name="is_default" value="1" class="rounded text-emerald-600 focus:ring-emerald-500">
                            <span>العملة الافتراضية للنظام</span>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition shadow-md flex items-center justify-center gap-2 cursor-pointer mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>حفظ العملة</span>
                    </button>
                </form>
            </div>

            <!-- Table -->
            <div class="lk-table-col w-full bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 rounded-3xl p-5 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-black text-slate-800 dark:text-slate-100 font-readex">
                        العملات وأسعار الصرف المعرفة ({{ $currencies->count() }})
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="lk-modern-table text-right">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>العملة</th>
                                <th>الرمز</th>
                                <th>رمز العرض</th>
                                <th>سعر الصرف</th>
                                <th>الحالة</th>
                                <th class="text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($currencies as $c)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-bold text-slate-900 dark:text-white">
                                        <span class="mr-1">{{ $c->flag }}</span>
                                        <span>{{ $c->name }}</span>
                                        @if($c->is_default)
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-500/15 text-amber-700 dark:text-amber-300 border border-amber-500/30 mr-1.5">
                                                افتراضية
                                            </span>
                                        @endif
                                    </td>
                                    <td class="font-mono font-bold">{{ $c->code }}</td>
                                    <td>{{ $c->symbol }}</td>
                                    <td class="font-mono">{{ number_format($c->exchange_rate, 4) }}</td>
                                    <td>
                                        <span class="px-2 py-0.5 rounded-full text-[10.5px] font-bold {{ $c->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $c->is_active ? 'نشطة' : 'معطلة' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <button type="button" @click="openEdit('currency', {{ $c->toJson() }})"
                                                class="lk-btn-action bg-blue-50 hover:bg-blue-100 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400" title="تعديل">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            @if(!$c->is_default)
                                                <form method="POST" action="{{ route('lookups.currencies.destroy', $c) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذه العملة؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="lk-btn-action bg-rose-50 hover:bg-rose-100 text-rose-600 dark:bg-rose-950/60 dark:text-rose-400" title="حذف">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-8 text-slate-400">لا توجد عملات مضافة بعد.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ================= 5. Universal Edit Modal ================= -->
        <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
            <div @click.outside="editModal = false" class="bg-white dark:bg-slate-800 rounded-3xl p-6 w-full max-w-md shadow-2xl border border-slate-200 dark:border-slate-700 relative">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="text-base font-black text-slate-800 dark:text-slate-100 font-readex">
                        تعديل العنصر
                    </h3>
                    <button type="button" @click="editModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Unit Edit Form -->
                <template x-if="editType === 'unit'">
                    <form :action="'{{ url('/lookups/units') }}/' + editData.id" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">اسم القسم / الوحدة</label>
                            <input type="text" name="name" x-model="editData.name" required
                                class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">الكود</label>
                            <input type="text" name="code" x-model="editData.code"
                                class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">الوصف</label>
                            <textarea name="description" x-model="editData.description" rows="2"
                                class="w-full px-3.5 py-2 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900"></textarea>
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">إلغاء</button>
                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-black bg-indigo-600 hover:bg-indigo-700 text-white shadow-md">حفظ التغييرات</button>
                        </div>
                    </form>
                </template>

                <!-- Governorate Edit Form -->
                <template x-if="editType === 'governorate'">
                    <form :action="'{{ url('/lookups/governorates') }}/' + editData.id" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">اسم المحافظة</label>
                            <input type="text" name="name" x-model="editData.name" required
                                class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">الرمز / الكود</label>
                            <input type="text" name="code" x-model="editData.code"
                                class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900">
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">إلغاء</button>
                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-black bg-blue-600 hover:bg-blue-700 text-white shadow-md">حفظ التغييرات</button>
                        </div>
                    </form>
                </template>

                <!-- Currency Edit Form -->
                <template x-if="editType === 'currency'">
                    <form :action="'{{ url('/lookups/currencies') }}/' + editData.id" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">الرمز (ISO)</label>
                                <input type="text" name="code" x-model="editData.code" required
                                    class="w-full px-3.5 py-2.5 rounded-xl text-xs font-mono font-bold uppercase border border-slate-200 dark:border-slate-700 dark:bg-slate-900">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">علم الدولة</label>
                                <input type="text" name="flag" x-model="editData.flag"
                                    class="w-full px-3.5 py-2.5 rounded-xl text-xs text-center border border-slate-200 dark:border-slate-700 dark:bg-slate-900">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">اسم العملة</label>
                            <input type="text" name="name" x-model="editData.name" required
                                class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">رمز العرض</label>
                                <input type="text" name="symbol" x-model="editData.symbol" required
                                    class="w-full px-3.5 py-2.5 rounded-xl text-xs border border-slate-200 dark:border-slate-700 dark:bg-slate-900">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">سعر الصرف</label>
                                <input type="number" step="0.0001" name="exchange_rate" x-model="editData.exchange_rate" required
                                    class="w-full px-3.5 py-2.5 rounded-xl text-xs font-mono border border-slate-200 dark:border-slate-700 dark:bg-slate-900">
                            </div>
                        </div>
                        <div class="flex items-center gap-4 pt-1">
                            <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700 dark:text-slate-300">
                                <input type="checkbox" name="is_active" value="1" :checked="editData.is_active" class="rounded text-emerald-600">
                                <span>مفعلة وتظهر في القوائم</span>
                            </label>
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="editModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">إلغاء</button>
                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-black bg-emerald-600 hover:bg-emerald-700 text-white shadow-md">حفظ التغييرات</button>
                        </div>
                    </form>
                </template>
            </div>
        </div>

    </div>
@endsection
