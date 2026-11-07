@props(['status', 'size' => 'sm'])

@php
    $statusObj = is_object($status) ? $status : null;
    $name = trim($statusObj?->name ?? (is_string($status) ? $status : 'غير محدد'));
    $code = strtolower(trim($statusObj?->color_code ?? 'slate'));

    // Determine icon type based on name or code
    $iconType = $statusObj?->icon_type ?? 'default';
    if ($iconType === 'default') {
        if (str_contains($name, 'أولويات') || str_contains($name, 'الأولويات')) {
            $iconType = 'dot';
            if ($code === 'slate') $code = 'emerald';
        } elseif (str_contains($name, 'منجزة') || str_contains($name, 'مغلقة')) {
            $iconType = 'check-circle';
            if ($code === 'slate') $code = 'emerald';
        } elseif (str_contains($name, 'واردة') || str_contains($name, 'مسجلة')) {
            $iconType = 'inbox';
            if ($code === 'slate') $code = 'blue';
        } elseif (str_contains($name, 'اطلاع') || str_contains($name, 'إحاطة') || str_contains($name, 'متابعة')) {
            $iconType = 'eye';
            if ($code === 'slate') $code = 'orange';
        } elseif (str_contains($name, 'دراسة') || str_contains($name, 'معالجة')) {
            $iconType = 'hourglass';
            if ($code === 'slate') $code = 'purple';
        } elseif (str_contains($name, 'إحالة')) {
            $iconType = 'forward';
            if ($code === 'slate') $code = 'rose';
        } elseif (str_contains($name, 'مصادقة') || str_contains($name, 'اعتماد')) {
            $iconType = 'clock';
            if ($code === 'slate') $code = 'amber';
        } elseif (str_contains($name, 'مسودة')) {
            $iconType = 'pencil';
            if ($code === 'slate') $code = 'purple';
        } elseif (str_contains($name, 'مؤرشفة')) {
            $iconType = 'archive';
        } elseif (str_contains($name, 'مؤجلات') || str_contains($name, 'تأجيل')) {
            $iconType = 'pause';
            if ($code === 'slate') $code = 'cyan';
        }
    }

    $colorMap = [
        'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-300/80 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-700/60',
        'green'   => 'bg-emerald-50 text-emerald-700 border-emerald-300/80 dark:bg-emerald-950/40 dark:text-emerald-300 dark:border-emerald-700/60',
        'blue'    => 'bg-blue-50 text-blue-700 border-blue-300/80 dark:bg-blue-950/40 dark:text-blue-300 dark:border-blue-700/60',
        'sky'     => 'bg-sky-50 text-sky-700 border-sky-300/80 dark:bg-sky-950/40 dark:text-sky-300 dark:border-sky-700/60',
        'indigo'  => 'bg-indigo-50 text-indigo-700 border-indigo-300/80 dark:bg-indigo-950/40 dark:text-indigo-300 dark:border-indigo-700/60',
        'purple'  => 'bg-purple-50 text-purple-700 border-purple-300/80 dark:bg-purple-950/40 dark:text-purple-300 dark:border-purple-700/60',
        'violet'  => 'bg-purple-50 text-purple-700 border-purple-300/80 dark:bg-purple-950/40 dark:text-purple-300 dark:border-purple-700/60',
        'amber'   => 'bg-amber-50 text-amber-800 border-amber-300/80 dark:bg-amber-950/40 dark:text-amber-300 dark:border-amber-700/60',
        'orange'  => 'bg-orange-50 text-orange-800 border-orange-300/80 dark:bg-orange-950/40 dark:text-orange-300 dark:border-orange-700/60',
        'rose'    => 'bg-rose-50 text-rose-700 border-rose-300/80 dark:bg-rose-950/40 dark:text-rose-300 dark:border-rose-700/60',
        'red'     => 'bg-red-50 text-red-700 border-red-300/80 dark:bg-red-950/40 dark:text-red-300 dark:border-red-700/60',
        'teal'    => 'bg-teal-50 text-teal-700 border-teal-300/80 dark:bg-teal-950/40 dark:text-teal-300 dark:border-teal-700/60',
        'cyan'    => 'bg-cyan-50 text-cyan-700 border-cyan-300/80 dark:bg-cyan-950/40 dark:text-cyan-300 dark:border-cyan-700/60',
        'slate'   => 'bg-slate-100 text-slate-700 border-slate-300/80 dark:bg-slate-800/60 dark:text-slate-300 dark:border-slate-700/60',
    ];

    $colors = $colorMap[$code] ?? $colorMap['slate'];
    $sizeClass = $size === 'xs' 
        ? 'px-2 py-0.5 text-[10px] font-black' 
        : ($size === 'lg' ? 'px-3.5 py-1 text-xs font-black' : 'px-2.5 py-0.5 text-[11px] font-black');
    $iconClass = $size === 'xs' ? 'w-2.5 h-2.5' : ($size === 'lg' ? 'w-3.5 h-3.5' : 'w-3 h-3');
@endphp

<span class="{{ $colors }} {{ $sizeClass }} inline-flex items-center gap-1.5 rounded-full border shadow-2xs transition-all">
    @if ($statusObj)
        {!! $statusObj->svgIcon($iconClass) !!}
    @else
        @switch($iconType)
            @case('dot')
                <svg class="{{ $iconClass }} shrink-0" viewBox="0 0 20 20" fill="currentColor"><circle cx="10" cy="10" r="4.5"/></svg>
                @break
            @case('check-circle')
                <svg class="{{ $iconClass }} shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                @break
            @case('inbox')
                <svg class="{{ $iconClass }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                @break
            @case('eye')
                <svg class="{{ $iconClass }} shrink-0" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                @break
            @case('hourglass')
                <svg class="{{ $iconClass }} shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 3h14M5 21h14M7 3v4.586a1 1 0 00.293.707l4.414 4.414a1 1 0 01.293.707V21M17 3v4.586a1 1 0 01-.293.707l-4.414 4.414a1 1 0 00-.293.707V21"/></svg>
                @break
            @case('forward')
                <svg class="{{ $iconClass }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                @break
            @case('clock')
                <svg class="{{ $iconClass }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @break
            @case('pencil')
                <svg class="{{ $iconClass }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                @break
            @case('archive')
                <svg class="{{ $iconClass }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V8zm2 3h10"/></svg>
                @break
            @case('pause')
                <svg class="{{ $iconClass }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @break
            @default
                <svg class="{{ $iconClass }} shrink-0" viewBox="0 0 20 20" fill="currentColor"><circle cx="10" cy="10" r="3.5"/></svg>
        @endswitch
    @endif
    <span>{{ $name }}</span>
</span>

