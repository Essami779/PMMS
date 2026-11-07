@props([
    'name',
    'label',
    'value' => '',
    'required' => false,
    'helpText' => null
])

<div x-data="{
    gDate: '{{ old($name, $value) }}',
    hijriText: '',
    updateHijri() {
        if (!this.gDate) {
            this.hijriText = '';
            return;
        }
        try {
            const parts = this.gDate.split('-');
            if (parts.length === 3) {
                const d = new Date(parts[0], parts[1] - 1, parts[2]);
                const formatter = new Intl.DateTimeFormat('ar-SA-u-ca-islamic-umalqura', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                let txt = formatter.format(d);
                if (!txt.includes('هـ')) { txt += ' هـ'; }
                this.hijriText = txt;
            }
        } catch(e) {
            this.hijriText = '';
        }
    }
}" x-init="updateHijri()">

    <label for="{{ $name }}" class="flex items-center gap-1.5 text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">
        <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span>{{ $label }}</span>
        @if ($required) <span class="text-rose-500">*</span> @endif
    </label>

    <div class="relative">
        <input type="date" 
               name="{{ $name }}" 
               id="{{ $name }}" 
               x-model="gDate" 
               @input="updateHijri()"
               @change="updateHijri()"
               {{ $required ? 'required' : '' }}
               class="w-full text-xs rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 focus:border-indigo-500 focus:ring-indigo-500 py-2.5 px-3">
    </div>

    <!-- المعاينة الهجرية اللحظية -->
    <div x-show="hijriText" x-transition class="mt-1.5 flex items-center space-x-1.5 space-x-reverse text-[11px] font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-lg border border-emerald-500/20 w-fit">
        <span>🌙</span>
        <!-- <span>الهجري:</span> -->
        <strong x-text="hijriText"></strong>
    </div>

    @if ($helpText)
        <p class="text-[10px] text-slate-400 mt-1">{{ $helpText }}</p>
    @endif

    @error($name)
        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
    @enderror
</div>
