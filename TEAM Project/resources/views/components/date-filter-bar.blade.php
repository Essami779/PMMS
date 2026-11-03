@props([
    'action' => request()->url(),
    'calType' => request('cal_type', 'gregorian'),
    'filterMonth' => request('filter_month', ''),
    'filterYear' => request('filter_year', ''),
    'dateFrom' => request('date_from'),
    'dateTo' => request('date_to'),
    'showRanges' => true,
    'showSubmit' => false,
    'extraInputs' => [],
])

@php
    $gregorianMonths = \App\Services\HijriDateService::$gregorianMonths;
    $hijriMonths = \App\Services\HijriDateService::$hijriMonths;
    $currentGYear = (int) date('Y');
    $currentGMonth = (int) date('n');
    $currentHYear = \App\Services\HijriDateService::currentHijriYear();
    $currentHMonth = \App\Services\HijriDateService::currentHijriMonth();

    $hijriYearRange = \App\Services\HijriDateService::getHijriYearRange($currentHYear);
    $defaultHijriFrom = $hijriYearRange['start'];
    $defaultHijriTo = $hijriYearRange['end'];

    $dateFromIsExplicit = request()->has('date_from');
    $dateToIsExplicit = request()->has('date_to');

    // Default to start and end of current Hijri year
    $dateFrom = $dateFrom ?: $defaultHijriFrom;
    $dateTo = $dateTo ?: $defaultHijriTo;

    // Pre-computed values to avoid escaped quotes inside Blade expressions
    $filterYearVal = $filterYear ?: ($calType === 'hijri' ? $currentHYear : $currentGYear);
    $defaultGregorianFrom = $defaultHijriFrom;
    $defaultGregorianTo = $defaultHijriTo;
@endphp

<div x-data="{
    calType: '{{ $calType }}',
    filterMonth: '{{ $filterMonth }}',
    filterYear: '{{ $filterYearVal }}',
    dateFrom: '{{ $dateFrom }}',
    dateTo: '{{ $dateTo }}',
    hijriFromText: '',
    hijriToText: '',
    gregorianMonths: {{ json_encode($gregorianMonths) }},
    hijriMonths: {{ json_encode($hijriMonths) }},
    defaultGregorianFrom: '{{ $defaultGregorianFrom }}',
    defaultGregorianTo: '{{ $defaultGregorianTo }}',
    defaultHijriFrom: '{{ $defaultHijriFrom }}',
    defaultHijriTo: '{{ $defaultHijriTo }}',
    defaultHijriYear: '{{ $currentHYear }}',
    defaultGregYear: '{{ $currentGYear }}',
    dateFromIsExplicit: {{ $dateFromIsExplicit ? 'true' : 'false' }},
    dateToIsExplicit: {{ $dateToIsExplicit ? 'true' : 'false' }},

    getCurrentHijriMonthRange() {
        const pad = (n) => n < 10 ? '0' + n : '' + n;
        const fmtDate = (d) => `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
        const fmt = new Intl.DateTimeFormat('en-u-ca-islamic-umalqura', { year: 'numeric', month: 'numeric', day: 'numeric' });
        const getParts = (date) => {
            const parts = fmt.formatToParts(date);
            return {
                year: parseInt(parts.find(p => p.type === 'year').value),
                month: parseInt(parts.find(p => p.type === 'month').value),
                day: parseInt(parts.find(p => p.type === 'day').value),
            };
        };
        const today = new Date();
        const todayHijri = getParts(today);
        const firstDay = new Date(today);
        firstDay.setDate(firstDay.getDate() - (todayHijri.day - 1));
        const day30 = new Date(firstDay);
        day30.setDate(day30.getDate() + 29);
        const day30Hijri = getParts(day30);
        const lastDay = (day30Hijri.month === todayHijri.month && day30Hijri.year === todayHijri.year) ?
            day30 :
            new Date(firstDay.getFullYear(), firstDay.getMonth(), firstDay.getDate() + 28);
        this.defaultHijriYear = todayHijri.year;
        this.filterYear = todayHijri.year;
        return { from: fmtDate(firstDay), to: fmtDate(lastDay) };
    },

    toggleCal(type) {
        if (this.calType !== type) {
            this.calType = type;
            this.filterMonth = '';
            if (type === 'hijri') {
                this.filterYear = this.defaultHijriYear;
                this.dateFrom = this.defaultHijriFrom;
                this.dateTo = this.defaultHijriTo;
                this.updateHijriFrom();
                this.updateHijriTo();
            } else {
                this.filterYear = this.defaultGregYear;
                this.dateFrom = this.defaultHijriFrom;
                this.dateTo = this.defaultHijriTo;
                this.updateHijriFrom();
                this.updateHijriTo();
            }
        }
    },

    hijriToGregorian(hy, hm, hd) {
        const jd = Math.floor((11 * hy + 3) / 30) + 354 * hy + 30 * hm - Math.floor((hm - 1) / 2) + hd + 1948440 - 385;
        const z = Math.floor(jd + 0.5);
        let a = Math.floor((z - 1867216.25) / 36524.25);
        a = z + 1 + a - Math.floor(a / 4);
        const b = a + 1524;
        const c = Math.floor((b - 122.1) / 365.25);
        const d = Math.floor(365.25 * c);
        const e = Math.floor((b - d) / 30.6001);
        const day = Math.floor(b - d - Math.floor(30.6001 * e));
        const month = e < 14 ? e - 1 : e - 13;
        const year = month > 2 ? c - 4716 : c - 4715;
        const pad = (n) => (n < 10 ? '0' + n : n);
        return `${year}-${pad(month)}-${pad(day)}`;
    },

    hijriToGregorianUmalqura(hy, hm, hd) {
        const fmt = new Intl.DateTimeFormat('en-u-ca-islamic-umalqura', { year: 'numeric', month: 'numeric', day: 'numeric' });
        const getParts = (date) => {
            const parts = fmt.formatToParts(date);
            return {
                year: parseInt(parts.find(p => p.type === 'year').value),
                month: parseInt(parts.find(p => p.type === 'month').value),
                day: parseInt(parts.find(p => p.type === 'day').value),
            };
        };
        const pad = (n) => n < 10 ? '0' + n : '' + n;
        const fmtDate = (d) => `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
        const approx = this.hijriToGregorian(hy, hm, hd);
        const aprParts = approx.split('-');
        const base = new Date(parseInt(aprParts[0]), parseInt(aprParts[1]) - 1, parseInt(aprParts[2]));
        for (let offset = -4; offset <= 4; offset++) {
            const candidate = new Date(base);
            candidate.setDate(candidate.getDate() + offset);
            const h = getParts(candidate);
            if (h.year === hy && h.month === hm && h.day === hd) return fmtDate(candidate);
        }
        return approx;
    },

    syncDatesFromMonthYear() {
        if (!this.filterYear) {
            this.filterYear = (this.calType === 'hijri') ? '{{ $currentHYear }}' : '{{ $currentGYear }}';
        }
        const year = parseInt(this.filterYear);
        const month = this.filterMonth ? parseInt(this.filterMonth) : 0;
        const pad = (n) => (n < 10 ? '0' + n : n);

        if (this.calType === 'gregorian') {
            if (month >= 1 && month <= 12) {
                this.dateFrom = `${year}-${pad(month)}-01`;
                const lastDay = new Date(year, month, 0).getDate();
                this.dateTo = `${year}-${pad(month)}-${pad(lastDay)}`;
            } else {
                this.dateFrom = `${year}-01-01`;
                this.dateTo = `${year}-12-31`;
            }
        } else if (this.calType === 'hijri') {
            const pad2 = (n) => n < 10 ? '0' + n : '' + n;
            const fmtLocal = (d) => `${d.getFullYear()}-${pad2(d.getMonth() + 1)}-${pad2(d.getDate())}`;
            if (month >= 1 && month <= 12) {
                this.dateFrom = this.hijriToGregorianUmalqura(year, month, 1);
                const nextHy = month === 12 ? year + 1 : year;
                const nextHm = month === 12 ? 1 : month + 1;
                const nextStart = this.hijriToGregorianUmalqura(nextHy, nextHm, 1);
                const dt = new Date(nextStart.split('-')[0], nextStart.split('-')[1] - 1, nextStart.split('-')[2]);
                dt.setDate(dt.getDate() - 1);
                this.dateTo = fmtLocal(dt);
            } else {
                this.dateFrom = this.hijriToGregorianUmalqura(year, 1, 1);
                const nextStart = this.hijriToGregorianUmalqura(year + 1, 1, 1);
                const dt = new Date(nextStart.split('-')[0], nextStart.split('-')[1] - 1, nextStart.split('-')[2]);
                dt.setDate(dt.getDate() - 1);
                this.dateTo = fmtLocal(dt);
            }
        }
        this.updateHijriFrom();
        this.updateHijriTo();
    },

    updateHijriFrom() {
        if (!this.dateFrom) { this.hijriFromText = ''; return; }
        try {
            const parts = this.dateFrom.split('-');
            if (parts.length === 3) {
                const d = new Date(parts[0], parts[1] - 1, parts[2]);
                let txt = new Intl.DateTimeFormat('ar-SA-u-ca-islamic-umalqura', { day: 'numeric', month: 'long', year: 'numeric' }).format(d);
                if (!txt.includes('هـ')) { txt += ' هـ'; }
                this.hijriFromText = txt;
            }
        } catch (e) { this.hijriFromText = ''; }
    },

    updateHijriTo() {
        if (!this.dateTo) { this.hijriToText = ''; return; }
        try {
            const parts = this.dateTo.split('-');
            if (parts.length === 3) {
                const d = new Date(parts[0], parts[1] - 1, parts[2]);
                let txt = new Intl.DateTimeFormat('ar-SA-u-ca-islamic-umalqura', { day: 'numeric', month: 'long', year: 'numeric' }).format(d);
                if (!txt.includes('هـ')) { txt += ' هـ'; }
                this.hijriToText = txt;
            }
        } catch (e) { this.hijriToText = ''; }
    }
}" x-init="if (calType === 'hijri' && !dateFromIsExplicit) {
    const range = getCurrentHijriMonthRange();
    dateFrom = range.from;
    dateTo = range.to;
}
updateHijriFrom();
updateHijriTo();"
    class="relative overflow-hidden rounded-xl border border-slate-200/90 dark:border-slate-700/80 shadow-2xs bg-gradient-to-br from-indigo-50/60 via-white to-purple-50/40 dark:from-slate-900 dark:via-slate-800/50 dark:to-slate-900">

    {{-- Decorative soft gradient blobs --}}
    <div
        class="pointer-events-none absolute -top-12 -left-12 w-36 h-36 rounded-full bg-gradient-to-br from-indigo-300/20 to-sky-300/10 blur-2xl">
    </div>
    <div
        class="pointer-events-none absolute -bottom-12 -right-12 w-36 h-36 rounded-full bg-gradient-to-br from-emerald-300/15 to-teal-300/10 blur-2xl">
    </div>

    <div class="relative p-2 sm:p-2.5">

        <div class="flex flex-col lg:flex-row items-stretch gap-2">

            {{-- ===== Calendar Toggle ===== --}}
            <div class="flex flex-col gap-1 shrink-0 justify-center">
                {{-- Toggle Pills --}}
                <div
                    class="flex gap-1 p-0.5 rounded-lg bg-white/80 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-700/60 shadow-inner">

                    <button type="button" @click="toggleCal('gregorian')"
                        class="relative flex items-center gap-1 px-2.5 py-1 rounded-md text-[10.5px] font-black transition-all duration-200 cursor-pointer"
                        :class="calType === 'gregorian'
                            ?
                            'bg-gradient-to-l from-indigo-500 to-blue-500 text-white shadow-sm shadow-indigo-500/25' :
                            'text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/40'">
                        <span class="text-xs leading-none">📅</span>
                        <span>ميلادي</span>
                    </button>

                    <button type="button" @click="toggleCal('hijri')"
                        class="relative flex items-center gap-1 px-2.5 py-1 rounded-md text-[10.5px] font-black transition-all duration-200 cursor-pointer"
                        :class="calType === 'hijri'
                            ?
                            'bg-gradient-to-l from-emerald-500 to-teal-500 text-white shadow-sm shadow-emerald-500/25' :
                            'text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-950/40'">
                        <span class="text-xs leading-none">🌙</span>
                        <span>هجري</span>
                    </button>
                </div>

                {{-- Active Mode Indicator --}}
                <div class="flex items-center justify-center gap-1 text-[9.5px] font-bold px-1">
                    <span class="w-1.5 h-1.5 rounded-full animate-pulse"
                        :class="calType === 'hijri' ? 'bg-emerald-400' : 'bg-indigo-400'"></span>
                    <span class="text-slate-400 dark:text-slate-500">النشط:</span>
                    <span class="font-black"
                        :class="calType === 'hijri' ? 'text-emerald-600 dark:text-emerald-400' :
                            'text-indigo-600 dark:text-indigo-400'"
                        x-text="calType === 'hijri' ? 'التقويم الهجري' : 'التقويم الميلادي'">
                    </span>
                </div>
            </div>

            <input type="hidden" name="cal_type" :value="calType">

            {{-- Separator --}}
            <div class="hidden lg:block w-px self-stretch bg-slate-100 dark:bg-slate-700/60"></div>

            {{-- ===== Filter Fields ===== --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 flex-1">

                {{-- Month --}}
                <div class="space-y-0.5">
                    <label class="flex items-center gap-1 text-[9.5px] font-black uppercase tracking-wide"
                        :class="calType === 'hijri' ? 'text-emerald-600 dark:text-emerald-400' :
                            'text-indigo-600 dark:text-indigo-400'">
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span x-text="calType === 'hijri' ? 'الشهر الهجري' : 'الشهر الميلادي'"></span>
                    </label>
                    <div class="relative">
                        <select name="filter_month" x-model="filterMonth" @change="syncDatesFromMonthYear()"
                            class="w-full h-8 text-xs py-1 pl-3 pr-6 rounded-lg border focus:outline-none focus:ring-1 transition appearance-none cursor-pointer dark:bg-slate-900 dark:text-slate-100"
                            :class="calType === 'hijri'
                                ?
                                'border-emerald-200 dark:border-emerald-800/50 focus:border-emerald-400 focus:ring-emerald-400/30 bg-emerald-50/40 dark:bg-emerald-950/20' :
                                'border-indigo-200 dark:border-indigo-800/50 focus:border-indigo-400 focus:ring-indigo-400/30 bg-indigo-50/40 dark:bg-indigo-950/20'">
                            <option value="">-- كل الأشهر --</option>
                            <template x-if="calType === 'gregorian'">
                                <template x-for="(name, num) in gregorianMonths" :key="'g-' + num">
                                    <option :value="num" x-text="num + ' — ' + name"
                                        :selected="filterMonth == num"></option>
                                </template>
                            </template>
                            <template x-if="calType === 'hijri'">
                                <template x-for="(name, num) in hijriMonths" :key="'h-' + num">
                                    <option :value="num" x-text="num + ' — ' + name"
                                        :selected="filterMonth == num"></option>
                                </template>
                            </template>
                        </select>
                        <svg class="w-3 h-3 absolute left-2 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                {{-- Year --}}
                <div class="space-y-0.5">
                    <label class="flex items-center gap-1 text-[9.5px] font-black uppercase tracking-wide"
                        :class="calType === 'hijri' ? 'text-emerald-600 dark:text-emerald-400' :
                            'text-indigo-600 dark:text-indigo-400'">
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <span x-text="calType === 'hijri' ? 'السنة الهجرية' : 'السنة الميلادية'"></span>
                    </label>
                    <input type="number" name="filter_year" x-model="filterYear" @input="syncDatesFromMonthYear()"
                        @change="syncDatesFromMonthYear()" :placeholder="calType === 'hijri' ? '1448' : '2026'"
                        class="w-full h-8 text-xs py-1 px-2.5 rounded-lg border focus:outline-none focus:ring-1 transition dark:bg-slate-900 dark:text-slate-100"
                        :class="calType === 'hijri'
                            ?
                            'border-emerald-200 dark:border-emerald-800/50 focus:border-emerald-400 focus:ring-emerald-400/30 bg-emerald-50/40 dark:bg-emerald-950/20' :
                            'border-indigo-200 dark:border-indigo-800/50 focus:border-indigo-400 focus:ring-indigo-400/30 bg-indigo-50/40 dark:bg-indigo-950/20'" />
                </div>

                @if ($showRanges)
                    {{-- Date From --}}
                    <div class="space-y-0.5">
                        <label
                            class="flex items-center gap-1 text-[9.5px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                            <svg class="w-2.5 h-2.5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                            </svg>
                            <span>من تاريخ</span>
                        </label>
                        <div class="flex items-center gap-1">
                            <input type="date" name="date_from" x-model="dateFrom" @input="updateHijriFrom()"
                                @change="updateHijriFrom()"
                                class="w-full min-w-[115px] h-8 text-xs py-1 px-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-900 dark:text-slate-100 focus:border-sky-400 focus:ring-1 focus:ring-sky-400/30 focus:outline-none transition font-readex" />
                            <div x-show="hijriFromText" x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                class="shrink-0 inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200/80 dark:border-emerald-800/60 px-1.5 py-1 rounded-lg shadow-2xs whitespace-nowrap"
                                :title="hijriFromText">
                                <span>🌙</span>
                                <span x-text="hijriFromText"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Date To --}}
                    <div class="space-y-0.5">
                        <label
                            class="flex items-center gap-1 text-[9.5px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                            <svg class="w-2.5 h-2.5 text-amber-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                            </svg>
                            <span>إلى تاريخ</span>
                        </label>
                        <div class="flex items-center gap-1">
                            <input type="date" name="date_to" x-model="dateTo" @input="updateHijriTo()"
                                @change="updateHijriTo()"
                                class="w-full min-w-[115px] h-8 text-xs py-1 px-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-900 dark:text-slate-100 focus:border-amber-400 focus:ring-1 focus:ring-amber-400/30 focus:outline-none transition font-readex" />
                            <div x-show="hijriToText" x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="shrink-0 inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200/80 dark:border-emerald-800/60 px-1.5 py-1 rounded-lg shadow-2xs whitespace-nowrap"
                                :title="hijriToText">
                                <span>🌙</span>
                                <span x-text="hijriToText"></span>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>

    @if ($showSubmit)
        <div
            class="px-3 py-2 border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/60 dark:bg-slate-800/40 flex items-center justify-end gap-2">
            <button type="submit"
                class="inline-flex items-center gap-1.5 h-8 px-4 rounded-lg text-xs font-black text-white bg-gradient-to-l from-indigo-600 to-blue-500 hover:from-indigo-700 hover:to-blue-600 shadow-md shadow-indigo-500/20 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span>تطبيق الفلترة</span>
            </button>
            @if (request()->hasAny(['filter_month', 'filter_year', 'date_from', 'date_to', 'cal_type']))
                <a href="{{ strtok(request()->fullUrl(), '?') }}"
                    class="inline-flex items-center gap-1 h-8 px-3 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-slate-100 dark:hover:bg-slate-600 border border-slate-200 dark:border-slate-600 transition">
                    إعادة ضبط
                </a>
            @endif
        </div>
    @endif
</div>
