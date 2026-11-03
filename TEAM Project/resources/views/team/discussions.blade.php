@extends('layouts.app')

@section('title', 'غرفة العمليات ونقاشات المشروع - ' . $team->name)

@section('content')
<div class="space-y-6 max-w-7xl mx-auto pb-12" x-data="{
    activeCategory: 'all',
    searchQuery: '',
    newTopicModal: false,
    openReplyId: null,
    
    toggleReply(id) {
        this.openReplyId = this.openReplyId === id ? null : id;
    }
}">

    <!-- Top Team Navigation Bar -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-2.5 flex items-center justify-between flex-wrap gap-2 shadow-2xs">
        <div class="flex items-center gap-1 sm:gap-2 flex-wrap">
            <a href="{{ route('team.workspace') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition flex items-center gap-1.5">
                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>مساحة العمل ومتابعة الفريق</span>
            </a>
            <a href="{{ route('team.discussions') }}" class="px-3.5 py-2 rounded-xl text-xs font-black bg-indigo-600 text-white shadow-sm flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                <span>غرفة العمليات والنقاشات</span>
            </a>
            <a href="{{ route('team.consultations') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition flex items-center gap-1.5">
                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                <span>استشارات وخبراء المشروع</span>
            </a>
        </div>
        <a href="{{ route('team.report', $team) }}" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 transition flex items-center gap-1.5">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>طباعة التقرير الشامل</span>
        </a>
    </div>

    <!-- Executive Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-950 border border-slate-800 p-6 sm:p-8 text-white shadow-xl">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                        ⚡ غرفة العمليات والقرارات الهندسية (War Room)
                    </span>
                    <span class="text-xs text-slate-400 font-bold">فريق: {{ $team->name }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">
                    غرفة عمليات ونقاشات المشروع
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    منصة حوارية وتنسيقية فورية لأعضاء الفريق؛ لمناقشة القرارات المعمارية (ADRs)، معالجة العوائق التقنية (Blockers)، مشاركة الروابط والشيفرات، وتوجيهات القيادة.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <button type="button"
                        @click="newTopicModal = true"
                        class="px-5 py-3 rounded-2xl bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 font-black text-xs sm:text-sm shadow-lg shadow-indigo-600/30 flex items-center gap-2 transition hover:scale-[1.02] cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/></svg>
                    <span>فتح موضوع نقاش جديد</span>
                </button>
            </div>
        </div>

        <!-- Metric Counter Tiles -->
        <div class="mt-8 pt-6 border-t border-slate-800/80 grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                <span class="block text-xs font-bold text-slate-400">إجمالي المواضيع</span>
                <span class="text-2xl font-black text-white font-readex mt-1">{{ $stats['total'] }}</span>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                <span class="block text-xs font-bold text-amber-300">مواضيع مثبتة (Pinned)</span>
                <span class="text-2xl font-black text-amber-400 font-readex mt-1">{{ $stats['pinned'] }}</span>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                <span class="block text-xs font-bold text-rose-300">عوائق حرجة (Blockers)</span>
                <span class="text-2xl font-black text-rose-400 font-readex mt-1">{{ $stats['blockers'] }}</span>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                <span class="block text-xs font-bold text-emerald-300">إجمالي الردود والمشاركات</span>
                <span class="text-2xl font-black text-emerald-400 font-readex mt-1">{{ $stats['replies'] }}</span>
            </div>
        </div>
    </div>

    <!-- Controls & Category Filters -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs">
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0 custom-scrollbar">
            <button type="button" @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-indigo-600 text-white font-black shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200'"
                    class="px-3.5 py-1.5 rounded-xl text-xs whitespace-nowrap transition cursor-pointer">
                الكل ({{ $discussions->count() }})
            </button>
            <button type="button" @click="activeCategory = 'announcement'"
                    :class="activeCategory === 'announcement' ? 'bg-indigo-600 text-white font-black shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200'"
                    class="px-3.5 py-1.5 rounded-xl text-xs whitespace-nowrap transition cursor-pointer">
                📢 التوجيهات والإعلانات
            </button>
            <button type="button" @click="activeCategory = 'blocker'"
                    :class="activeCategory === 'blocker' ? 'bg-rose-600 text-white font-black shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200'"
                    class="px-3.5 py-1.5 rounded-xl text-xs whitespace-nowrap transition cursor-pointer">
                🚨 العوائق (Blockers)
            </button>
            <button type="button" @click="activeCategory = 'architecture'"
                    :class="activeCategory === 'architecture' ? 'bg-purple-600 text-white font-black shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200'"
                    class="px-3.5 py-1.5 rounded-xl text-xs whitespace-nowrap transition cursor-pointer">
                📐 القرارات المعمارية
            </button>
            <button type="button" @click="activeCategory = 'security'"
                    :class="activeCategory === 'security' ? 'bg-emerald-600 text-white font-black shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200'"
                    class="px-3.5 py-1.5 rounded-xl text-xs whitespace-nowrap transition cursor-pointer">
                🛡️ الأمان والامتثال
            </button>
            <button type="button" @click="activeCategory = 'general'"
                    :class="activeCategory === 'general' ? 'bg-indigo-600 text-white font-black shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-200'"
                    class="px-3.5 py-1.5 rounded-xl text-xs whitespace-nowrap transition cursor-pointer">
                💬 نقاش عام
            </button>
        </div>

        <div class="relative w-full sm:w-72">
            <input type="text" x-model="searchQuery" placeholder="بحث في موضوعات النقاش..."
                   class="w-full h-9.5 pr-9 pl-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500 transition">
            <svg class="w-4 h-4 absolute right-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </div>

    <!-- Discussions Thread List -->
    <div class="space-y-4">
        @if($discussions->isEmpty())
            <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-3xl p-12 text-center space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 mx-auto flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <h4 class="text-base font-black text-slate-900 dark:text-white">لا توجد أي مواضيع نقاش مفتوحة حالياً</h4>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    ابدأ أول نقاش أو اطرح قراراً معمارياً أو استفساراً تقنياً مع زملائك في الفريق لتعزيز سرعة الإنجاز والشفافية.
                </p>
                <button type="button" @click="newTopicModal = true" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-xs shadow-md">
                    فتح أول موضوع
                </button>
            </div>
        @else
            @foreach($discussions as $disc)
                <div x-show="(activeCategory === 'all' || activeCategory === '{{ $disc->category }}') && ('{{ $disc->title }} {{ $disc->author->name }} {{ $disc->content }}').toLowerCase().includes(searchQuery.toLowerCase())"
                     x-transition
                     class="bg-white dark:bg-slate-900 border {{ $disc->is_pinned ? 'border-amber-300 dark:border-amber-500/50 shadow-md ring-1 ring-amber-400/20' : 'border-slate-200/90 dark:border-slate-800 shadow-2xs' }} rounded-3xl p-6 transition-all space-y-4">
                    
                    <!-- Thread Header -->
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-xs">
                                {{ mb_substr($disc->author->name ?? 'عضو', 0, 2) }}
                            </div>
                            <div class="space-y-0.5">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-xs font-black text-slate-900 dark:text-white">{{ $disc->author->name }}</span>
                                    <span class="text-[11px] text-slate-500 dark:text-slate-400">({{ $disc->author->profile->job_title ?? 'عضو الفريق' }})</span>
                                    <span class="text-[10px] text-slate-400 font-readex">{{ $disc->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex items-center gap-2 pt-0.5">
                                    <span class="px-2.5 py-0.5 rounded-md text-[10.5px] font-bold bg-{{ $disc->category_color }}-50 dark:bg-{{ $disc->category_color }}-950/80 text-{{ $disc->category_color }}-700 dark:text-{{ $disc->category_color }}-300 border border-{{ $disc->category_color }}-200 dark:border-{{ $disc->category_color }}-800">
                                        {{ $disc->category_label }}
                                    </span>
                                    @if($disc->is_pinned)
                                        <span class="px-2 py-0.5 rounded-md text-[10.5px] font-bold bg-amber-50 dark:bg-amber-950/80 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800 flex items-center gap-1">
                                            <span>📌</span>
                                            <span>مثبت في قمة الغرفة</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Leader / Author Actions -->
                        <div class="flex items-center gap-2">
                            @if($isLeader)
                                <form action="{{ route('team.discussions.pin', $disc) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $disc->is_pinned ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }} hover:bg-amber-200 transition">
                                        {{ $disc->is_pinned ? 'إلغاء التثبيت' : '📌 تثبيت' }}
                                    </button>
                                </form>
                            @endif

                            @if($isLeader || $disc->user_id === auth()->id())
                                <form action="{{ route('team.discussions.destroy', $disc) }}" method="POST" onsubmit="return confirm('هل تريد حذف هذا الموضوع نهائياً؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-500 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Thread Title & Body -->
                    <div class="space-y-2">
                        <h3 class="text-base font-black text-slate-900 dark:text-white leading-snug">
                            {{ $disc->title }}
                        </h3>
                        <p class="text-xs text-slate-700 dark:text-slate-300 whitespace-pre-line leading-relaxed bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800">
                            {{ $disc->content }}
                        </p>
                    </div>

                    <!-- Replies Counter & Quick Expand -->
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <button type="button" 
                                @click="toggleReply({{ $disc->id }})"
                                class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                            <span>{{ $disc->replies->count() }} مشاركات وردود</span>
                            <span class="text-[10px]" x-text="openReplyId === {{ $disc->id }} ? '▲ إغلاق' : '▼ فتح'"></span>
                        </button>
                        <span class="text-[11px] text-slate-400">
                            آخر نشاط: {{ $disc->replies->first() ? $disc->replies->first()->created_at->diffForHumans() : $disc->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <!-- Replies Drawer & Reply Form -->
                    <div x-show="openReplyId === {{ $disc->id }}" x-collapse class="space-y-4 pt-3">
                        @if($disc->replies->isNotEmpty())
                            <div class="space-y-3 pr-4 border-r-2 border-indigo-200 dark:border-indigo-800">
                                @foreach($disc->replies as $reply)
                                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/70 dark:border-slate-700/70 space-y-1.5">
                                        <div class="flex items-center justify-between text-xs">
                                            <div class="flex items-center gap-2">
                                                <span class="font-black text-slate-800 dark:text-slate-100">{{ $reply->author->name }}</span>
                                                <span class="text-[10px] text-slate-400 font-readex">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold">
                                                {{ $reply->author->profile->job_title ?? 'عضو' }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line">
                                            {{ $reply->content }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Post Reply Box -->
                        <form action="{{ route('team.discussions.reply', $disc) }}" method="POST" class="flex items-start gap-2 pt-2">
                            @csrf
                            <textarea name="content" rows="2" required
                                      placeholder="أضف ردك أو مقترحك التقني على هذا الموضوع..."
                                      class="flex-1 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500"></textarea>
                            <button type="submit" 
                                    class="px-4 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/30 shrink-0 cursor-pointer">
                                إرسال
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        @endif
    </div>

    <!-- ============================================================
         MODAL: CREATE NEW DISCUSSION THREAD
         ============================================================ -->
    <div x-show="newTopicModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl relative"
             @click.outside="newTopicModal = false">
            
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <h3 class="text-base font-black text-slate-900 dark:text-white">فتح موضوع نقاش في غرفة العمليات</h3>
                </div>
                <button @click="newTopicModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1">✕</button>
            </div>

            <form action="{{ route('team.discussions.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">عنوان الموضوع:</label>
                    <input type="text" name="title" required
                           placeholder="مثال: اعتماد نمط State Management لتطبيق الموبايل"
                           class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">تصنيف الموضوع:</label>
                    <select name="category" required class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500">
                        <option value="general">💬 نقاش عام وتنسيق بين الأعضاء</option>
                        <option value="announcement">📢 إعلان وتوجيه رسمي من القيادة</option>
                        <option value="blocker">🚨 عائق تقني حرج (Blocker Issue)</option>
                        <option value="architecture">📐 قرار وتصميم معماري (ADR / System Design)</option>
                        <option value="security">🛡️ تنبيه أمني واختبارات حماية</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">التفاصيل والشيفرات أو التوجيهات:</label>
                    <textarea name="content" rows="4" required
                              placeholder="اشرح المشكلة، البدائل المقترحة، الروابط المرجعية، أو توجيهات التنفيذ..."
                              class="w-full p-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500 leading-relaxed"></textarea>
                </div>

                @if($isLeader)
                    <div class="flex items-center gap-2 pt-1">
                        <input type="checkbox" name="is_pinned" id="is_pinned" value="1" class="w-4 h-4 text-indigo-600 rounded">
                        <label for="is_pinned" class="text-xs font-bold text-slate-700 dark:text-slate-300 cursor-pointer">
                            تثبيت الموضوع في قمة غرفة العمليات (Pinned)
                        </label>
                    </div>
                @endif

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" @click="newTopicModal = false" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800">
                        إلغاء
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-md shadow-indigo-600/30">
                        نشر الموضوع
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

