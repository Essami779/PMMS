@props([
    'currencies' => null,
    'currencyStats' => [],
    'selectedCurrency' => request('currency', 'all'),
    'title' => 'تصفية التقرير المالي حسب نوع العملة',
    'subtitle' => 'عزل وتخصيص التحليل المالي والمؤشرات ومعدلات الصرف بحسب العملة المحددة',
    'badgeText' => 'فصل السيولة المالي',
    'totalCount' => null,
    'incomingLabel' => 'التوريد الوارد',
    'disburseLabel' => 'المنصرف الفعلي',
    'remainingLabel' => 'المتبقي الدفتري',
    'unitLabel' => 'شيك وأمر مسجل',
    'showCards' => true,
    'urlParam' => 'currency',
])

@php
    // تحضير العملات إذا لم يتم تمريرها
    if (empty($currencies)) {
        if (function_exists('system_currencies')) {
            $currencies = system_currencies();
        } else {
            $currencies = [
                (object)['code' => 'YER', 'name' => 'الريال اليمني', 'hex_color' => '#2563eb'],
                (object)['code' => 'SAR', 'name' => 'الريال السعودي', 'hex_color' => '#d97706'],
                (object)['code' => 'USD', 'name' => 'الدولار الأمريكي', 'hex_color' => '#059669'],
            ];
        }
    }

    $currentCur = $selectedCurrency ?: 'all';
    if (empty($currentCur)) {
        $currentCur = 'all';
    }

    // دوال مساعدة لإنشاء الأعلام الفيكتورية فائقة الجودة
    $getFlagSvg = function($code, $size = 'sm') {
        $w = $size === 'lg' ? 'w-6.5 h-4.5' : 'w-5 h-3.5';
        return match(strtoupper($code)) {
            'YER', 'YE' => '<svg class="' . $w . ' rounded overflow-hidden shadow-2xs shrink-0 border border-slate-300/40" viewBox="0 0 3 2"><rect width="3" height="2" fill="#000000"/><rect width="3" height="1.333" fill="#FFFFFF"/><rect width="3" height="0.667" fill="#CE1126"/></svg>',
            'SAR', 'SA' => '<svg class="' . $w . ' rounded overflow-hidden shadow-2xs shrink-0 border border-emerald-700/40" viewBox="0 0 30 20"><rect width="30" height="20" fill="#006C35"/><g fill="#FFFFFF"><path d="M7 5.5h1.2v4.5H7zm2.5-1h1.2v5.5H9.5zm2.5.8h1.2v4.7H12zm2.5-.5h1.2v5.2h-1.2zm2.5.8h1.2v4.4H17zm2.5-.8h1.2v5.2h-1.2zm2.5.5h1.2v4.7H22z" opacity="0.95"/><path d="M6 9.8h18v1.1H6z" opacity="0.9"/><path d="M6.5 13.2h15l-1.5-1.2h1.8l2 1.5-2 1.5h-1.8l1.5-1.2H6.5c-.5 0-.8-.3-.8-.6s.3-.6.8-.6z"/><path d="M6.2 11.8v2.8h-.8v-2.8h.8z"/><circle cx="5.2" cy="13.2" r="0.6"/></g></svg>',
            'USD', 'US' => '<svg class="' . $w . ' rounded overflow-hidden shadow-2xs shrink-0 border border-blue-900/40" viewBox="0 0 19 10"><rect width="19" height="10" fill="#B22234"/><path d="M0 1.538h19M0 3.077h19M0 4.615h19M0 6.154h19M0 7.692h19M0 9.231h19" stroke="#FFFFFF" stroke-width="0.769"/><rect width="7.6" height="5.385" fill="#3C3B6E"/><text x="3.8" y="3.8" font-size="3.5" fill="#FFFFFF" text-anchor="middle">★</text></svg>',
            default => '<span class="text-xs font-black">' . $code . '</span>'
        };
    };

    // حساب إجمالي كافة السجلات إذا لم يمرر
    if ($totalCount === null) {
        $calcTotal = 0;
        foreach ($currencies as $curItem) {
            $cCode = is_array($curItem) ? ($curItem['code'] ?? '') : ($curItem->code ?? '');
            $stat = $currencyStats[$cCode] ?? null;
            if ($stat) {
                $calcTotal += ($stat['count'] ?? $stat['total_count'] ?? (($stat['incoming_count'] ?? 0) + ($stat['disburse_count'] ?? 0)) ?? (($stat['in_count'] ?? 0) + ($stat['disb_count'] ?? 0)) ?? 0);
            }
        }
        $totalCount = $calcTotal > 0 ? $calcTotal : 'الكل';
    }
@endphp

<!-- Dynamic Multi-Currency Filter & Breakdown Section -->
<div class="space-y-1.5 font-cairo my-1">

    <!-- 1. Multi-Currency Executive Switcher Bar -->
    <div class="relative overflow-hidden p-2 sm:p-2.5 rounded-xl backdrop-blur-md shadow-xs flex flex-wrap items-center justify-between gap-2 curr-switcher-bar">
        <div class="flex items-center gap-2 relative z-10">
            <div class="relative">
                <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800 text-white flex items-center justify-center shrink-0 shadow-sm shadow-indigo-500/25 border border-white/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-900 shadow-2xs" title="تصفية نشطة ومحدثة"></span>
            </div>
            <div>
                <div class="flex items-center gap-1.5 flex-wrap">
                    <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white tracking-tight">{{ $title }}</h3>
                    @if($badgeText)
                        <span class="hidden sm:inline-flex items-center gap-0.5 px-1.5 py-0.2 rounded-full text-[9.5px] font-black bg-indigo-50 text-indigo-700 dark:bg-indigo-950/70 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800/60">
                            <span>{{ $badgeText }}</span>
                        </span>
                    @endif
                </div>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 font-bold mt-0.2">{{ $subtitle }}</p>
            </div>
        </div>

        <div class="relative z-10 inline-flex items-center gap-1 p-1 rounded-lg text-xs shadow-inner overflow-x-auto no-scrollbar max-w-full curr-switcher-group">
            <!-- All Currencies Pill -->
            <a href="{{ request()->fullUrlWithQuery([$urlParam => 'all', 'page' => 1]) }}"
                class="group px-2.5 py-1 rounded-md font-black text-xs transition-all flex items-center gap-1.5 whitespace-nowrap {{ $currentCur === 'all' ? 'bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 text-white shadow-sm shadow-indigo-500/25 scale-[1.01]' : 'curr-pill-inactive hover:scale-[1.01]' }}"
                title="عرض السجلات بكافة العملات">
                <svg class="w-3.5 h-3.5 shrink-0 {{ $currentCur === 'all' ? 'text-white' : 'text-indigo-500 dark:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                </svg>
                <span>كافة العملات</span>
                <span class="inline-flex items-center justify-center min-w-[20px] h-4.5 px-1.5 rounded-full text-[10px] font-black font-num shadow-2xs transition-transform group-hover:scale-105 {{ $currentCur === 'all' ? 'bg-white/30 text-white border border-white/40' : 'bg-slate-200/80 text-slate-800 dark:bg-slate-700 dark:text-slate-200 border border-slate-300/60 dark:border-slate-600/60' }}">
                    {{ is_numeric($totalCount) ? number_format($totalCount) : $totalCount }}
                </span>
            </a>

            <!-- Individual Currency Pills -->
            @if(!empty($currencies))
                @foreach($currencies as $c)
                    @php
                        $cCode = is_array($c) ? ($c['code'] ?? '') : ($c->code ?? '');
                        $cName = is_array($c) ? ($c['name'] ?? $cCode) : ($c->name ?? $cCode);
                        $cStat = $currencyStats[$cCode] ?? null;
                        $currHex = match(strtoupper($cCode)) {
                            'USD', 'US' => '#059669',
                            'SAR', 'SA' => '#d97706',
                            'YER', 'YE' => '#2563eb',
                            default => (is_array($c) ? ($c['hex_color'] ?? '#6366f1') : ($c->hex_color ?? '#6366f1'))
                        };
                        $isSelected = ($currentCur === $cCode);
                        $totalOps = $cStat ? ($cStat['count'] ?? $cStat['total_count'] ?? (($cStat['incoming_count'] ?? 0) + ($cStat['disburse_count'] ?? 0)) ?? (($cStat['in_count'] ?? 0) + ($cStat['disb_count'] ?? 0)) ?? 0) : 0;
                    @endphp
                    <a href="{{ request()->fullUrlWithQuery([$urlParam => $cCode, 'page' => 1]) }}"
                        class="group px-2.5 py-1 rounded-md font-black text-xs transition-all flex items-center gap-1.5 whitespace-nowrap {{ $isSelected ? 'text-white shadow-sm font-black scale-[1.01]' : 'curr-pill-inactive hover:scale-[1.01]' }}"
                        style="{{ $isSelected ? 'background: linear-gradient(135deg, ' . $currHex . ', ' . $currHex . 'dd); box-shadow: 0 2px 8px ' . $currHex . '35;' : '' }}"
                        title="تصفية حسب {{ $cName }}">
                        <span class="shrink-0 flex items-center">{!! $getFlagSvg($cCode, 'sm') !!}</span>
                        <span style="{{ !$isSelected ? 'color: ' . $currHex . ';' : '' }}">{{ $cName }}</span>
                        <span class="inline-flex items-center justify-center min-w-[20px] h-4.5 px-1.5 rounded-full text-[10px] font-black font-num shadow-2xs transition-transform group-hover:scale-105 {{ $isSelected ? 'bg-white/30 text-white border border-white/40' : 'bg-slate-200/80 text-slate-800 dark:bg-slate-700 dark:text-slate-200 border border-slate-300/60 dark:border-slate-600/60' }}">
                            {{ number_format($totalOps) }}
                        </span>
                    </a>
                @endforeach
            @endif
        </div>
    </div>

    <!-- 2. Multi-Currency Summary Breakdown Cards -->
    @if($showCards && !empty($currencies))
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            @foreach($currencies as $c)
                @php
                    $cCode = is_array($c) ? ($c['code'] ?? '') : ($c->code ?? '');
                    $cName = is_array($c) ? ($c['name'] ?? $cCode) : ($c->name ?? $cCode);
                    $cStat = $currencyStats[$cCode] ?? null;
                    
                    $currHex = match(strtoupper($cCode)) {
                        'USD', 'US' => '#059669',
                        'SAR', 'SA' => '#d97706',
                        'YER', 'YE' => '#2563eb',
                        default => (is_array($c) ? ($c['hex_color'] ?? '#6366f1') : ($c->hex_color ?? '#6366f1'))
                    };
                    $isSelected = ($currentCur === $cCode);

                    $incomingVal = $cStat ? (
                        $cStat['total_incoming'] ?? 
                        $cStat['inflow'] ?? 
                        $cStat['in_total'] ?? 
                        $cStat['total_amount'] ?? 
                        $cStat['total_receipts'] ?? 
                        $cStat['total_loans_amount'] ?? 
                        $cStat['treasury_net'] ?? 
                        $cStat['incoming'] ?? 
                        $cStat['gross_amount'] ?? 
                        0
                    ) : 0;

                    $disbursedVal = $cStat ? (
                        $cStat['total_net'] ?? 
                        $cStat['outflow'] ?? 
                        $cStat['out_total'] ?? 
                        $cStat['spent_amount'] ?? 
                        $cStat['repaid_amount'] ?? 
                        $cStat['total_deposits'] ?? 
                        $cStat['total_repaid_amount'] ?? 
                        $cStat['checks_remaining'] ?? 
                        $cStat['disb_total'] ?? 
                        $cStat['disbursed'] ?? 
                        $cStat['net_amount'] ?? 
                        0
                    ) : 0;

                    $remainingVal = $cStat ? (
                        $cStat['total_remaining'] ?? 
                        $cStat['closing'] ?? 
                        $cStat['remaining_balance'] ?? 
                        $cStat['remaining_amount'] ?? 
                        $cStat['total_remaining_amount'] ?? 
                        $cStat['liquid_cash'] ?? 
                        $cStat['loans_outstanding'] ?? 
                        $cStat['closing_balance'] ?? 
                        $cStat['net'] ?? 
                        ($incomingVal - $disbursedVal)
                    ) : 0;

                    $opsCount = $cStat ? (
                        $cStat['count'] ?? 
                        $cStat['total_count'] ?? 
                        (($cStat['incoming_count'] ?? 0) + ($cStat['disburse_count'] ?? 0)) ?? 
                        (($cStat['in_count'] ?? 0) + ($cStat['disb_count'] ?? 0)) ?? 
                        0
                    ) : 0;

                    $hasActivity = ($opsCount > 0) || ($incomingVal > 0) || ($disbursedVal > 0);
                @endphp

                <div class="group relative rounded-xl transition-all duration-200 p-2.5 flex flex-col justify-between space-y-1.5 overflow-hidden border curr-outer-card-{{ $cCode }} {{ $isSelected ? 'ring-2 ring-offset-1 dark:ring-offset-slate-900 shadow-sm' : 'hover:shadow-sm hover:-translate-y-0.5' }}"
                    style="border-color: {{ $isSelected ? $currHex : ($currHex . '45') }}; {{ $isSelected ? ('ring-color: ' . $currHex . ';') : '' }}">

                    <!-- Card Header: Flag, Name, ISO, Status -->
                    <div class="relative z-10 flex items-center justify-between">
                        <a href="{{ request()->fullUrlWithQuery([$urlParam => $cCode, 'page' => 1]) }}"
                            class="flex items-center gap-2 group/link">
                            <div class="w-7.5 h-7.5 rounded-lg flex items-center justify-center shadow-2xs border border-white/90 dark:border-slate-700 bg-white/90 dark:bg-slate-800/90 transition-transform duration-200 group-hover/link:scale-105 shrink-0">
                                {!! $getFlagSvg($cCode, 'sm') !!}
                            </div>
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-xs sm:text-[13px] font-black text-slate-900 dark:text-white group-hover/link:underline transition">
                                        {{ $cName }}
                                    </span>
                                    <span class="px-1.5 py-0.2 rounded text-[9px] font-black text-white shadow-2xs"
                                        style="background: linear-gradient(135deg, {{ $currHex }}, {{ $currHex }}dd);">
                                        {{ $cCode }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1 mt-0.2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $hasActivity ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300 dark:bg-slate-600' }}"></span>
                                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold">
                                        {{ number_format($opsCount) }} {{ $unitLabel }}
                                    </span>
                                </div>
                            </div>
                        </a>

                        <!-- Active State Indicator Pill -->
                        @if($isSelected)
                            <span class="inline-flex items-center gap-0.5 px-2 py-0.2 rounded text-[9.5px] font-black text-white shadow-xs"
                                style="background-color: {{ $currHex }};">
                                <svg class="w-2.5 h-2.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                <span>محدد</span>
                            </span>
                        @else
                            <span class="w-2 h-2 rounded-full shrink-0 border border-white dark:border-slate-800"
                                style="background-color: {{ $currHex }}; box-shadow: 0 0 6px {{ $currHex }};"></span>
                        @endif
                    </div>

                    <!-- Micro-Financial Metrics Grid (التوريد الوارد، المنصرف الفعلي، المتبقي الدفتري) -->
                    <div class="relative z-10 grid grid-cols-3 gap-1 text-center">

                        <!-- 1. Metric 1: Incoming / Total Amount (+) -->
                        <div class="curr-card-subbox p-1.5 rounded-lg relative overflow-hidden border border-emerald-300/40 dark:border-emerald-800/40 bg-emerald-50/20 dark:bg-emerald-950/20">
                            <div class="flex items-center justify-center gap-0.5 mb-0.5">
                                <span class="w-3.5 h-3.5 rounded bg-emerald-500/15 dark:bg-emerald-500/25 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                </span>
                                <span class="text-[9.5px] text-emerald-700 dark:text-emerald-300 font-black truncate">{{ $incomingLabel }}</span>
                            </div>
                            <span class="text-xs sm:text-[13px] font-black font-readex text-emerald-600 dark:text-emerald-400 block tracking-tight">
                                +{{ number_format($incomingVal) }}
                            </span>
                        </div>

                        <!-- 2. Metric 2: Disbursed / Spent / Outflow (-) -->
                        <div class="curr-card-subbox p-1.5 rounded-lg relative overflow-hidden border border-rose-300/40 dark:border-rose-800/40 bg-rose-50/20 dark:bg-rose-950/20">
                            <div class="flex items-center justify-center gap-0.5 mb-0.5">
                                <span class="w-3.5 h-3.5 rounded bg-rose-500/15 dark:bg-rose-500/25 text-rose-600 dark:text-rose-400 flex items-center justify-center shrink-0">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"/></svg>
                                </span>
                                <span class="text-[9.5px] text-rose-700 dark:text-rose-300 font-black truncate">{{ $disburseLabel }}</span>
                            </div>
                            <span class="text-xs sm:text-[13px] font-black font-readex text-rose-600 dark:text-rose-400 block tracking-tight">
                                -{{ number_format($disbursedVal) }}
                            </span>
                        </div>

                        <!-- 3. Metric 3: Remaining / Net Balance (=) -->
                        <div class="curr-card-subbox p-1.5 rounded-lg relative overflow-hidden border" style="border-color: {{ $currHex }}35;">
                            <div class="flex items-center justify-center gap-0.5 mb-0.5">
                                <span class="w-3.5 h-3.5 rounded flex items-center justify-center shrink-0" style="background-color: {{ $currHex }}20; color: {{ $currHex }};">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </span>
                                <span class="text-[9.5px] font-black truncate" style="color: {{ $currHex }};">{{ $remainingLabel }}</span>
                            </div>
                            <span class="text-xs sm:text-[13px] font-black font-readex block tracking-tight" style="color: {{ $currHex }};">
                                {{ number_format($remainingVal) }}
                            </span>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
