@extends('layouts.frontend')

@section('title', 'دليل الفرق والمشاريع التقنية والريادية - منصة TEAM Hub')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto pb-10" x-data="{ 
    selectedCategory: 'الكل',
    searchQuery: '',
    joinModal: false,
    selectedTeam: null,
    openJoinModal(team) {
        this.selectedTeam = team;
        this.joinModal = true;
    }
}">

    <!-- 1. Executive Luxury Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-l from-indigo-500/15 via-purple-500/5 to-white dark:from-indigo-950/60 dark:via-slate-900 dark:to-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-sm">
        <!-- Ambient Decorative Glows -->
        <div class="absolute -left-16 -top-16 w-64 h-64 bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-purple-500/10 dark:bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2 max-w-3xl">
                <div class="flex items-center gap-2.5 flex-wrap">
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 shadow-2xs">
                        🚀 مسار الفرق والمشاريع التقنية والريادية
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300">
                        {{ count($sampleTeams) }} فرق نشطة متاحة
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    دليل الفرق والمشاريع التقنية والريادية
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    تصفح نخبة المشاريع والفرق البرمجية والريادية، تواصل مع قادة الفرق، انضم كعضو متخصص، أو قدم الرعاية والتمويل والاستثمار المؤسسي.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('register', ['track' => 'team']) }}" 
                   class="px-5 py-3 rounded-2xl bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-black text-xs sm:text-sm shadow-lg shadow-indigo-600/30 flex items-center gap-2 transition-all hover:scale-[1.02] cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>تسجيل فريق أو مشروع جديد</span>
                </a>
            </div>
        </div>

        <!-- Category Filter Tabs -->
        <div class="mt-6 pt-5 border-t border-slate-200/70 dark:border-slate-800/80 flex items-center gap-2 overflow-x-auto pb-1 custom-scrollbar">
            @foreach($categories as $category)
                <button type="button" 
                        @click="selectedCategory = '{{ $category }}'"
                        :class="selectedCategory === '{{ $category }}' 
                            ? 'bg-indigo-600 text-white font-black shadow-md shadow-indigo-600/30 ring-2 ring-indigo-600/40' 
                            : 'bg-white/80 dark:bg-slate-800/80 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-indigo-400 hover:text-indigo-600'"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all duration-200 cursor-pointer">
                    {{ $category }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- 2. Search & Controls Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs">
        <div class="flex items-center gap-2 text-xs font-bold text-slate-700 dark:text-slate-300">
            <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
            <span>عرض المشاريع حسب التصنيف:</span>
            <span class="text-indigo-600 dark:text-indigo-400 font-black" x-text="selectedCategory"></span>
        </div>

        <div class="relative w-full sm:w-80">
            <input type="text" 
                   x-model="searchQuery" 
                   placeholder="بحث باسم الفريق، المشروع، الجهة أو التقنية..." 
                   class="w-full h-10 pr-9 pl-4 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder:text-slate-400 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">
            <svg class="w-4 h-4 absolute right-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- 3. Teams Grid Showcase -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($sampleTeams as $team)
            <div x-show="(selectedCategory === 'الكل' || selectedCategory === '{{ $team['category'] }}') && ('{{ $team['name'] }} {{ $team['project_title'] }} {{ $team['university'] }} {{ implode(' ', $team['tags']) }}').toLowerCase().includes(searchQuery.toLowerCase())"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 flex flex-col justify-between shadow-xs hover:shadow-xl hover:border-indigo-500/40 dark:hover:border-indigo-500/40 transition-all duration-300 group">
                
                <div>
                    <!-- Top Category & Sponsorship Badge -->
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 dark:bg-indigo-950/80 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800/60">
                            {{ $team['category'] }}
                        </span>
                        <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-md border border-emerald-200/50 dark:border-emerald-800/50">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span>{{ $team['sponsorship_status'] }}</span>
                        </span>
                    </div>

                    <!-- Project & Team Title -->
                    <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white mb-2 leading-snug group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        {{ $team['name'] }}
                    </h3>

                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mb-4 line-clamp-2">
                        {{ $team['project_title'] }}
                    </p>

                    <!-- Tech Stack Tags -->
                    <div class="flex flex-wrap gap-1.5 mb-5">
                        @foreach($team['tags'] as $tag)
                            <span class="text-[10.5px] font-semibold px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700/60">
                                #{{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Footer Meta Info & Actions -->
                <div class="border-t border-slate-100 dark:border-slate-800 pt-4 mt-2">
                    <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 mb-4">
                        <div class="overflow-hidden">
                            <span class="block font-bold text-slate-800 dark:text-slate-200 truncate">{{ $team['leader'] }}</span>
                            <span class="text-[11px] truncate block">{{ $team['university'] }}</span>
                        </div>
                        <div class="text-left shrink-0">
                            <span class="block font-bold text-indigo-600 dark:text-indigo-400 font-readex">{{ $team['members_count'] }} أعضاء</span>
                            @if($team['members_needed'] > 0)
                                <span class="text-[10px] text-amber-600 dark:text-amber-400 font-bold">مطلوب {{ $team['members_needed'] }} عضو</span>
                            @else
                                <span class="text-[10px] text-slate-400">الفريق مكتمل</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <button type="button"
                                @click="openJoinModal({{ json_encode($team) }})"
                                class="py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-bold text-xs text-center transition-colors cursor-pointer">
                            طلب انضمام
                        </button>
                        <a href="{{ route('register', ['track' => 'company']) }}" 
                           class="py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs text-center shadow-md shadow-indigo-600/20 transition-all cursor-pointer">
                            تقديم رعاية
                        </a>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    <!-- 4. Interactive Join Modal -->
    <div x-show="joinModal" 
         x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 max-w-md w-full shadow-2xl relative"
             @click.outside="joinModal = false">
            
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white">تقديم طلب انضمام للفريق</h4>
                </div>
                <button @click="joinModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <template x-if="selectedTeam">
                <div class="space-y-4">
                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60">
                        <p class="text-xs font-black text-slate-800 dark:text-slate-100" x-text="selectedTeam.name"></p>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5" x-text="selectedTeam.project_title"></p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">الدور المطلوب أو المهارة التي ستقدمها:</label>
                        <input type="text" placeholder="مثال: مطور واجهات أمامية، باحث بيانات، مهندس شبكات..." class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white outline-none focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">رسالة تعريفية لقائد الفريق:</label>
                        <textarea rows="3" placeholder="نبذة مختصرة عن خبرتك ورابط ملف أعمالك..." class="w-full p-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white outline-none focus:border-indigo-500"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" @click="joinModal = false" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                            إلغاء
                        </button>
                        <a href="{{ route('register', ['track' => 'team']) }}" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/25">
                            إرسال الطلب
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </div>

</div>
@endsection
