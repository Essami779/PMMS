@extends('layouts.app')

@section('content')
<div class="space-y-5 pb-12 font-cairo" x-data="{ 
    selected: [],
    detailsModal: false,
    activeItem: null,
    openDetails(item) {
        this.activeItem = item;
        this.detailsModal = true;
    }
}">

    <!-- 1. الهيدر الفاخر لسجل التدقيق والأمان -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-sm p-4 sm:p-5">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-blue-700 text-white flex items-center justify-center shadow-md shadow-indigo-500/20 shrink-0 text-2xl font-bold">
                    🛡️
                </div>
                <div>
                    <h1 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white leading-tight font-readex">
                        مركز سجل التدقيق والرقابة الأمنية <span class="text-blue-600 dark:text-blue-400 font-mono text-base">(Audit & Security Trail)</span>
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        التوثيق الرقمي الشامل لكافة العمليات المالية والإدارية، وتعديلات القيود، ومحاولات تسجيل الدخول بالوقت الفعلي
                    </p>
                </div>
            </div>

            <!-- بطاقات مؤشرات سريعة -->
            <div class="flex items-center gap-2 flex-wrap">
                <div class="px-3.5 py-2 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 text-center">
                    <span class="text-[10px] font-bold text-slate-400 block">إجمالي السجلات</span>
                    <span class="text-xs font-black text-slate-800 dark:text-slate-100 font-readex">
                        {{ number_format($activities->total()) }}
                    </span>
                </div>
                <div class="px-3.5 py-2 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200/80 dark:border-emerald-800 text-center">
                    <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 block">حركات اليوم</span>
                    <span class="text-xs font-black text-emerald-700 dark:text-emerald-300 font-readex">
                        {{ number_format($activities->filter(fn($act) => $act->created_at?->isToday())->count()) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. شريط البحث والتصفية المتطورة -->
    @php
        $moduleNamesMap = [
            'auth' => ['label' => 'الأمان والمصادقة', 'icon' => '🔐', 'badge' => 'bg-amber-100 text-amber-800 dark:bg-amber-950/70 dark:text-amber-300 border-amber-200 dark:border-amber-800'],
            'treasury_general' => ['label' => 'الخزينة العامة', 'icon' => '🏛️', 'badge' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800'],
            'treasury_journal' => ['label' => 'يوميات الخزينة (35)', 'icon' => '📒', 'badge' => 'bg-teal-100 text-teal-800 dark:bg-teal-950/70 dark:text-teal-300 border-teal-200 dark:border-teal-800'],
            'loans' => ['label' => 'السلف والقروض', 'icon' => '🤝', 'badge' => 'bg-purple-100 text-purple-800 dark:bg-purple-950/70 dark:text-purple-300 border-purple-200 dark:border-purple-800'],
            'check_disbursements' => ['label' => 'أوامر صرف الشيكات', 'icon' => '📤', 'badge' => 'bg-rose-100 text-rose-800 dark:bg-rose-950/70 dark:text-rose-300 border-rose-200 dark:border-rose-800'],
            'incoming_checks' => ['label' => 'الشيكات الواردة', 'icon' => '📥', 'badge' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-950/70 dark:text-indigo-300 border-indigo-200 dark:border-indigo-800'],
            'memos' => ['label' => 'المذكرات الإدارية', 'icon' => '📋', 'badge' => 'bg-blue-100 text-blue-800 dark:bg-blue-950/70 dark:text-blue-300 border-blue-200 dark:border-blue-800'],
            'users' => ['label' => 'المستخدمين والصلاحيات', 'icon' => '👥', 'badge' => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-200 border-slate-300 dark:border-slate-700'],
            'lookups' => ['label' => 'الثوابت والإعدادات', 'icon' => '⚙️', 'badge' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-950/70 dark:text-cyan-300 border-cyan-200 dark:border-cyan-800'],
            'financial_documents' => ['label' => 'المرفقات والوثائق', 'icon' => '📎', 'badge' => 'bg-sky-100 text-sky-800 dark:bg-sky-950/70 dark:text-sky-300 border-sky-200 dark:border-sky-800'],
            'default' => ['label' => 'عام / غير محدد', 'icon' => '📌', 'badge' => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300 border-slate-200 dark:border-slate-700'],
        ];
    @endphp

    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-sm p-4">
        <form method="GET" action="{{ route('audit.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 items-end text-xs">
            
            <!-- البحث النصي -->
            <div class="md:col-span-2 space-y-1">
                <label class="block font-bold text-slate-600 dark:text-slate-300">بحث في الوصف، المرجع، التفاصيل، أو الـ IP:</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث برقم القيد، اسم الموظف، أو تفاصيل الحركة..."
                       class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>

            <!-- نوع القسم / النطاق -->
            <div class="space-y-1">
                <label class="block font-bold text-slate-600 dark:text-slate-300">النطاق / الموديول:</label>
                <select name="log_name" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-500 outline-none transition cursor-pointer">
                    <option value="">جميع النطاقات</option>
                    @foreach ($logNames as $name)
                        @php $info = $moduleNamesMap[$name] ?? ['label' => $name, 'icon' => '📌']; @endphp
                        <option value="{{ $name }}" {{ request('log_name') == $name ? 'selected' : '' }}>
                            {{ $info['icon'] }} {{ $info['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- المستخدم المنفذ -->
            <div class="space-y-1">
                <label class="block font-bold text-slate-600 dark:text-slate-300">المستخدم المنفذ:</label>
                <select name="user_id" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs focus:ring-2 focus:ring-blue-500 outline-none transition cursor-pointer">
                    <option value="">كافة المستخدمين</option>
                    @foreach ($allUsers as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                            {{ $u->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- أزرار الإجراءات -->
            <div class="flex items-center gap-2">
                <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2 h-9 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md transition hover:scale-[1.02] cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>تصفية النتائج</span>
                </button>
                <a href="{{ route('audit.index') }}"
                   class="h-9 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs border border-slate-200 dark:border-slate-700 transition flex items-center justify-center"
                   title="إعادة تعيين الفلاتر">
                    🔄
                </a>
            </div>

        </form>
    </div>

    <!-- 3. جدول سجل النشاط والتدقيق الشامل -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden">
        
        <!-- شريط أدوات السطور والإحصائيات وزر حذف المحدد بالأعلى -->
        <div class="px-5 py-3 bg-slate-50 dark:bg-slate-800/90 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
            
            <!-- الطرف الأيمن: التحكم بعدد السطور وإجمالي النتائج -->
            <div class="flex items-center gap-3 flex-wrap">
                <div class="flex items-center gap-2">
                    <label class="text-xs font-bold text-slate-600 dark:text-slate-300">عرض السطور:</label>
                    <select onchange="window.location.href = this.value" 
                            class="py-1 px-2.5 text-xs font-bold rounded-lg bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:outline-none cursor-pointer shadow-2xs">
                        @foreach([10 => '10 سجل', 15 => '15 سجل', 20 => '20 سجل', 50 => '50 سجل', 100 => '100 سجل', 250 => '250 سجل', 500 => '500 سجل', 'all' => 'الكل (إظهار كافة السطور)'] as $val => $label)
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => $val, 'page' => 1]) }}" {{ request('per_page', '20') == (string)$val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <span class="text-slate-300 dark:text-slate-600">|</span>
                <span class="text-xs text-slate-500 dark:text-slate-400 font-bold">
                    إجمالي النتائج المطابقة: <strong class="text-blue-600 dark:text-blue-400 font-readex">{{ number_format($activities->total()) }}</strong> حركة
                </span>
            </div>

            <!-- الطرف الأيسر: زر وإجراءات حذف المحدد بالأعلى (بارز وسريع الوصول) -->
            <div class="flex items-center gap-3">
                @can('audit.delete')
                <div class="flex items-center gap-2" x-show="selected.length > 0" x-cloak>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold text-rose-700 dark:text-rose-300 bg-rose-500/10 border border-rose-500/20 rounded-full">
                        تم تحديد <span class="font-black font-readex" x-text="selected.length"></span> سجل
                    </span>
                    <form method="POST" action="{{ route('audit.bulkDestroy') }}"
                          onsubmit="return confirm('هل أنت متأكد من حذف السجلات المحددة نهائياً من سجل التدقيق؟')">
                        @csrf
                        @method('DELETE')
                        <template x-for="id in selected" :key="id">
                            <input type="hidden" name="ids[]" :value="id">
                        </template>
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 h-8 px-3.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-full shadow-md transition hover:scale-105 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <span>حذف المحدد (<span x-text="selected.length"></span>)</span>
                        </button>
                    </form>
                </div>
                @endcan

                <div class="text-xs text-slate-500 dark:text-slate-400 font-medium" x-show="selected.length === 0">
                    عرض الصفحة <strong class="text-slate-800 dark:text-slate-200 font-readex">{{ $activities->currentPage() }}</strong> من <strong class="text-slate-800 dark:text-slate-200 font-readex">{{ $activities->lastPage() }}</strong>
                </div>
            </div>

        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs divide-y divide-slate-100 dark:divide-slate-800">
                <thead class="bg-slate-50/90 dark:bg-slate-800/60 text-slate-600 dark:text-slate-300 font-black border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="p-3 w-12 text-center">#</th>
                        <th class="p-3 w-36">النطاق / الموديول</th>
                        <th class="p-3">وصف وتفاصيل الحركة</th>
                        <th class="p-3 w-36">السجل المعني</th>
                        <th class="p-3 w-36">المستخدم المنفذ</th>
                        <th class="p-3 w-28 text-center">المصدر / IP</th>
                        <th class="p-3 w-36 text-center">التاريخ والتوقيت</th>
                        <th class="p-3 w-24 text-center">التفاصيل</th>
                        @can('audit.delete')
                        <th class="p-3 w-16 text-center">
                            <input type="checkbox" title="تحديد كل سجلات هذه الصفحة"
                                   @change="selected = $event.target.checked ? {{ json_encode($activities->pluck('id')->toArray()) }} : []"
                                   :checked="selected.length > 0 && selected.length === {{ $activities->count() }}"
                                   class="rounded border-slate-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500/40 cursor-pointer">
                        </th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-200">
                    @forelse($activities as $act)
                    @php
                        $lName = $act->log_name ?: 'default';
                        $modInfo = $moduleNamesMap[$lName] ?? ['label' => $lName, 'icon' => '📌', 'badge' => 'bg-slate-100 text-slate-800 border-slate-200'];
                        $props = $act->properties?->toArray() ?? [];
                        $ip = $props['ip'] ?? ($act->ip_address ?? '—');
                    @endphp
                    <tr class="hover:bg-blue-50/40 dark:hover:bg-slate-800/60 transition">
                        
                        <!-- 1. الرقم التسلسلي -->
                        <td class="p-3 text-center font-bold text-slate-400 font-readex">
                            #{{ $act->id }}
                        </td>

                        <!-- 2. النطاق والموديول -->
                        <td class="p-3 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $modInfo['badge'] }}">
                                <span>{{ $modInfo['icon'] }}</span>
                                <span>{{ $modInfo['label'] }}</span>
                            </span>
                        </td>

                        <!-- 3. وصف الحركة والحدث -->
                        <td class="p-3">
                            <div class="font-bold text-slate-900 dark:text-slate-100 text-xs leading-relaxed">
                                {{ $act->description }}
                            </div>
                            @if(!empty($act->event))
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-500 mt-1 inline-block">
                                حدث: {{ $act->event }}
                            </span>
                            @endif
                        </td>

                        <!-- 4. السجل المعني بالعملية -->
                        <td class="p-3 whitespace-nowrap">
                            @if ($act->subject instanceof \App\Models\CentralTreasuryEntry)
                                <a href="{{ route('treasury.general.show', $act->subject->id) }}" 
                                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 font-readex font-bold text-[11px] border border-emerald-200 dark:border-emerald-800 hover:scale-105 transition">
                                    🏛️ قيد #{{ sprintf('%02d', $act->subject->id) }}
                                </a>
                            @elseif ($act->subject instanceof \App\Models\TreasuryJournal)
                                <a href="{{ route('treasury.journals.show', $act->subject->id) }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-teal-50 text-teal-700 dark:bg-teal-950/60 dark:text-teal-300 font-readex font-bold text-[11px] border border-teal-200 dark:border-teal-800 hover:scale-105 transition">
                                    📒 يومية #{{ $act->subject->record_number ?: $act->subject->id }}
                                </a>
                            @elseif ($act->subject instanceof \App\Models\Loan)
                                <a href="{{ route('loans.show', $act->subject->id) }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-purple-50 text-purple-700 dark:bg-purple-950/60 dark:text-purple-300 font-readex font-bold text-[11px] border border-purple-200 dark:border-purple-800 hover:scale-105 transition">
                                    🤝 قرض #{{ $act->subject->loan_number ?: $act->subject->id }}
                                </a>
                            @elseif ($act->subject instanceof \App\Models\IncomingCheck)
                                <a href="{{ route('checks.incoming.show', $act->subject->id) }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300 font-readex font-bold text-[11px] border border-indigo-200 dark:border-indigo-800 hover:scale-105 transition">
                                    📥 شيك #{{ $act->subject->check_number ?: $act->subject->id }}
                                </a>
                            @elseif ($act->subject instanceof \App\Models\CheckDisbursement)
                                <a href="{{ route('checks.disbursements.show', $act->subject->id) }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 font-readex font-bold text-[11px] border border-rose-200 dark:border-rose-800 hover:scale-105 transition">
                                    📤 أمر #{{ $act->subject->order_number ?: $act->subject->id }}
                                </a>
                            @elseif ($act->subject instanceof \App\Models\Memo)
                                <a href="{{ route('memos.show', $act->subject->id) }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 font-readex font-bold text-[11px] border border-blue-200 dark:border-blue-800 hover:scale-105 transition">
                                    📋 مذكرة #{{ $act->subject->memo_number ?: $act->subject->id }}
                                </a>
                            @elseif ($act->subject_type)
                                <span class="text-[11px] font-mono text-slate-500 dark:text-slate-400">
                                    {{ class_basename($act->subject_type) }} #{{ $act->subject_id }}
                                </span>
                            @else
                                <span class="text-slate-400 font-bold">—</span>
                            @endif
                        </td>

                        <!-- 5. المستخدم المنفذ -->
                        <td class="p-3 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 flex items-center justify-center font-bold text-[10px] shrink-0">
                                    {{ $act->causer ? mb_substr($act->causer->name, 0, 1) : '🤖' }}
                                </div>
                                <span class="font-bold text-slate-800 dark:text-slate-200 text-xs">
                                    {{ $act->causer?->name ?: 'النظام / تلقائي' }}
                                </span>
                            </div>
                        </td>

                        <!-- 6. IP والمصدر -->
                        <td class="p-3 text-center whitespace-nowrap">
                            <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-mono text-[10.5px]">
                                {{ $ip }}
                            </span>
                        </td>

                        <!-- 7. التاريخ والتوقيت -->
                        <td class="p-3 text-center whitespace-nowrap">
                            <div class="font-bold font-readex text-slate-800 dark:text-slate-200 text-xs">
                                {{ $act->created_at?->format('Y-m-d') }}
                            </div>
                            <div class="text-[10px] text-slate-400 font-mono">
                                {{ $act->created_at?->format('h:i:s A') }}
                            </div>
                        </td>

                        <!-- 8. زر فحص تفاصيل التغييرات -->
                        <td class="p-3 text-center whitespace-nowrap">
                            <button type="button"
                                    @click="openDetails({{ json_encode([
                                        'id' => $act->id,
                                        'description' => $act->description,
                                        'log_name' => $modInfo['label'],
                                        'causer' => $act->causer?->name ?? 'النظام',
                                        'created_at' => $act->created_at?->format('Y-m-d H:i:s'),
                                        'properties' => $props,
                                    ]) }})"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-[10.5px] transition cursor-pointer">
                                <span>🔍</span>
                                <span>عرض</span>
                            </button>
                        </td>

                        <!-- 9. خانة التحديد والحذف -->
                        @can('audit.delete')
                        <td class="p-3 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1.5">
                                <input type="checkbox" value="{{ $act->id }}" x-model="selected"
                                       title="تحديد للحذف الجماعي"
                                       class="rounded border-slate-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500/40 cursor-pointer">
                                <form action="{{ route('audit.destroy', $act->id) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل التدقيقي؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 transition p-1" title="حذف السجل">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endcan

                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="p-10 text-center text-slate-400 font-bold text-xs space-y-2">
                            <div class="text-2xl">📋</div>
                            <p>لا توجد سجلات تدقيق مطابقة لمعايير البحث الحالية.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- تذييل الجدول وشريط الترقيم -->
        <div class="p-4 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                عرض <strong class="font-readex text-slate-800 dark:text-slate-200">{{ $activities->count() }}</strong> من إجمالي <strong class="font-readex text-slate-800 dark:text-slate-200">{{ number_format($activities->total()) }}</strong> حركة مسجلة
            </div>
            <div>
                {{ $activities->links() }}
            </div>
        </div>

    </div>

    <!-- 4. نافذة منبثقة لعرض التفاصيل الكاملة والتغييرات (Audit Details Modal) -->
    <div x-show="detailsModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl max-w-2xl w-full p-5 space-y-4 max-h-[85vh] overflow-y-auto"
             @click.away="detailsModal = false">
            
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 flex items-center justify-center text-sm font-bold">🔍</span>
                    <h3 class="text-sm font-black text-slate-900 dark:text-slate-100 font-readex">تفاصيل سجل التدقيق رقم #<span x-text="activeItem?.id"></span></h3>
                </div>
                <button type="button" @click="detailsModal = false" class="text-slate-400 hover:text-slate-600 text-lg font-bold">✕</button>
            </div>

            <div class="space-y-3 text-xs" x-show="activeItem">
                <div class="grid grid-cols-2 gap-2 bg-slate-50 dark:bg-slate-800/60 p-3 rounded-2xl border border-slate-200/80 dark:border-slate-700">
                    <div>
                        <span class="text-slate-400 block text-[10.5px]">النطاق:</span>
                        <strong class="text-slate-800 dark:text-slate-200" x-text="activeItem?.log_name"></strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10.5px]">المستخدم المنفذ:</span>
                        <strong class="text-slate-800 dark:text-slate-200" x-text="activeItem?.causer"></strong>
                    </div>
                    <div class="col-span-2">
                        <span class="text-slate-400 block text-[10.5px]">الوصف:</span>
                        <p class="text-slate-800 dark:text-slate-200 font-bold" x-text="activeItem?.description"></p>
                    </div>
                    <div class="col-span-2">
                        <span class="text-slate-400 block text-[10.5px]">التوقيت الدقيق:</span>
                        <span class="font-mono text-slate-700 dark:text-slate-300" x-text="activeItem?.created_at"></span>
                    </div>
                </div>

                <div class="space-y-1">
                    <span class="font-bold text-slate-700 dark:text-slate-300 block">البيانات والحمولة المسجلة (Payload Properties):</span>
                    <pre class="p-3 rounded-2xl bg-slate-950 text-emerald-400 font-mono text-[11px] overflow-x-auto leading-relaxed dir-ltr text-left border border-slate-800"
                         x-text="JSON.stringify(activeItem?.properties, null, 2)"></pre>
                </div>
            </div>

            <div class="pt-2 text-left">
                <button type="button" @click="detailsModal = false" class="px-4 py-1.5 rounded-xl bg-slate-200 hover:bg-slate-300 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs transition">
                    إغلاق
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
