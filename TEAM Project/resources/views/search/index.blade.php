@extends('layouts.app')

@section('title', 'نتائج البحث الشامل: ' . ($query ?: 'كل السجلات'))

@section('content')
<div class="space-y-6 max-w-7xl mx-auto py-2" x-data="{ currentTab: 'all' }">

    <!-- Top Search Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-l from-amber-500/15 via-slate-100 to-white dark:from-amber-500/10 dark:via-slate-900 dark:to-slate-900/90 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-sm">
        
        <div class="relative z-10 max-w-3xl">
            <div class="flex items-center gap-2 mb-2">
                <span class="p-2 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <span class="text-xs font-black tracking-wide uppercase text-amber-600 dark:text-amber-400">
                    البحث المركزي الشامل
                </span>
            </div>

            <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-slate-50 tracking-tight">
                نتائج البحث عن: <span class="text-amber-600 dark:text-amber-400 underline decoration-amber-500/40">{{ $query ?: 'كافة السجلات' }}</span>
            </h1>

            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                تم العثور على <span class="font-bold text-slate-900 dark:text-slate-100">{{ number_format($totalCount) }}</span> نتيجة مطابقة عبر كافة قطاعات وإدارات المنظومة.
            </p>

            <!-- Search Form Input Inside Banner for easy re-querying -->
            <form method="GET" action="{{ route('global.search') }}" class="mt-5 flex items-center gap-2 max-w-xl">
                <div class="relative flex-1">
                    <input
                        type="text"
                        name="q"
                        value="{{ $query }}"
                        placeholder="ابحث برقم الشيك، المذكرة، البيان، اسم المستفيد، أو الشاشة..."
                        class="w-full h-11 pr-10 pl-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500/40 shadow-sm"
                        autofocus>
                    <svg class="w-4 h-4 text-slate-400 absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button type="submit" class="h-11 px-5 rounded-2xl bg-amber-500 hover:bg-amber-600 active:scale-95 text-white font-black text-xs sm:text-sm transition-all shadow-md shadow-amber-500/20 flex items-center gap-1.5 shrink-0">
                    <span>بحث</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </form>
        </div>

    </div>

    @if($totalCount > 0)
        <!-- Category Filter Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 custom-scrollbar border-b border-slate-200 dark:border-slate-800">
            <!-- All Tab -->
            <button
                @click="currentTab = 'all'"
                class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2 shrink-0"
                :class="currentTab === 'all'
                    ? 'bg-amber-500 text-white shadow-md shadow-amber-500/25'
                    : 'bg-white dark:bg-slate-800/80 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700/80'">
                <span>كافة النتائج</span>
                <span class="px-1.5 py-0.2 rounded-full text-[11px] font-black"
                    :class="currentTab === 'all' ? 'bg-white/25 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300'">
                    {{ $totalCount }}
                </span>
            </button>

            <!-- Loop Categories as Tabs -->
            @foreach($categories as $catKey => $catData)
                @if(count($catData['items']) > 0)
                    <button
                        @click="currentTab = '{{ $catKey }}'"
                        class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2 shrink-0"
                        :class="currentTab === '{{ $catKey }}'
                            ? 'bg-amber-500 text-white shadow-md shadow-amber-500/25'
                            : 'bg-white dark:bg-slate-800/80 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700/80'">
                        <span>{{ $catData['title'] }}</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[11px] font-black"
                            :class="currentTab === '{{ $catKey }}' ? 'bg-white/25 text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300'">
                            {{ count($catData['items']) }}
                        </span>
                    </button>
                @endif
            @endforeach
        </div>

        <!-- Results Sections -->
        <div class="space-y-8">
            @foreach($categories as $catKey => $catData)
                @if(count($catData['items']) > 0)
                    <div
                        x-show="currentTab === 'all' || currentTab === '{{ $catKey }}'"
                        x-cloak
                        class="space-y-3">
                        
                        <!-- Section Heading -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-{{ $catData['color'] }}-500"></span>
                                <h3 class="text-base font-black text-slate-800 dark:text-slate-100">
                                    {{ $catData['title'] }}
                                </h3>
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                    {{ count($catData['items']) }} نتيجة
                                </span>
                            </div>
                        </div>

                        <!-- Cards Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
                            @foreach($catData['items'] as $item)
                                <div class="group bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 hover:border-amber-500/50 dark:hover:border-amber-500/40 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                                    
                                    <div>
                                        <!-- Top Badge & ID Row -->
                                        <div class="flex items-center justify-between gap-2 mb-2.5">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-{{ $catData['color'] }}-500/10 text-{{ $catData['color'] }}-700 dark:text-{{ $catData['color'] }}-400 border border-{{ $catData['color'] }}-500/20">
                                                {{ $item['badge'] }}
                                            </span>
                                            <span class="text-[11px] text-slate-400 dark:text-slate-500 font-semibold truncate">
                                                {{ $item['meta'] }}
                                            </span>
                                        </div>

                                        <!-- Title -->
                                        <h4 class="text-sm font-black text-slate-900 dark:text-slate-100 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors line-clamp-1">
                                            {{ $item['title'] }}
                                        </h4>

                                        <!-- Subtitle -->
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                                            {{ $item['subtitle'] }}
                                        </p>
                                    </div>

                                    <!-- Bottom Action Link -->
                                    <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                                        <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300 transition">
                                            عرض التفاصيل
                                        </span>
                                        <a href="{{ $item['url'] }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 group-hover:bg-amber-500 group-hover:text-white text-xs font-black transition-all">
                                            <span>فتح السجل</span>
                                            <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </a>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                    </div>
                @endif
            @endforeach
        </div>

    @else
        <!-- No Results Found State -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-12 text-center max-w-xl mx-auto shadow-sm">
            <div class="w-16 h-16 rounded-3xl bg-amber-500/10 text-amber-500 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            
            <h3 class="text-base font-black text-slate-800 dark:text-slate-100 mb-1">
                لم يتم العثور على أي نتائج مطابقة
            </h3>
            
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-6 leading-relaxed">
                لم نجد أي سجلات تطابق عبارة البحث "<strong class="text-amber-600 dark:text-amber-400">{{ $query }}</strong>".
                يرجى التأكد من كتابة الكلمات بدقة أو تجربة البحث برقم المستند أو جزء من الاسم.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-2">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200 transition">
                    العودة للرئيسية
                </a>
                <a href="{{ route('memos.index') }}" class="px-4 py-2 rounded-xl bg-amber-500/10 text-amber-700 dark:text-amber-400 text-xs font-bold hover:bg-amber-500/20 transition">
                    سجل المذكرات
                </a>
                <a href="{{ route('checks.incoming.index') }}" class="px-4 py-2 rounded-xl bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 text-xs font-bold hover:bg-emerald-500/20 transition">
                    الشيكات الواردة
                </a>
                <a href="{{ route('treasury.journals.index') }}" class="px-4 py-2 rounded-xl bg-blue-500/10 text-blue-700 dark:text-blue-400 text-xs font-bold hover:bg-blue-500/20 transition">
                    يومية الصندوق
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
