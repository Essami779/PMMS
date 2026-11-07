@props(['type', 'size' => 'sm'])

@php
    $colors = $type?->badge_classes ?? 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 ring-indigo-500/20';
    $sizeClass = $size === 'xs' ? 'px-2 py-0.5 text-[10px]' : 'px-2.5 py-1 text-xs';
    $iconClass = $size === 'xs' ? 'w-3 h-3' : 'w-3.5 h-3.5';
@endphp

<span class="{{ $colors }} {{ $sizeClass }} inline-flex items-center gap-1 rounded-md font-bold ring-1 ring-inset">
    <svg class="{{ $iconClass }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
    {{ $type?->name ?? 'غير محدد' }}
</span>
