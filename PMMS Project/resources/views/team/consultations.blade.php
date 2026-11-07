@extends('layouts.app')

@section('title', 'استشارات وخبراء توجيه المشروع - ' . $team->name)

@section('content')
<div class="space-y-6 max-w-7xl mx-auto pb-12" x-data="{
    activeTab: 'all',
    requestModal: false,
    reviewModal: false,
    selectedConsultation: null,
    selectedAdvisor: { name: '', title: '', category: 'technical' },
    
    openAdvisorModal(advisor) {
        this.selectedAdvisor = advisor;
        this.requestModal = true;
    },
    openReviewModal(consultation) {
        this.selectedConsultation = consultation;
        this.reviewModal = true;
    }
}">

    <!-- Top Team Navigation Bar -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-2.5 flex items-center justify-between flex-wrap gap-2 shadow-2xs">
        <div class="flex items-center gap-1 sm:gap-2 flex-wrap">
            <a href="{{ route('team.workspace') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition flex items-center gap-1.5">
                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>مساحة العمل ومتابعة الفريق</span>
            </a>
            <a href="{{ route('team.discussions') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition flex items-center gap-1.5">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                <span>غرفة العمليات والنقاشات</span>
            </a>
            <a href="{{ route('team.consultations') }}" class="px-3.5 py-2 rounded-xl text-xs font-black bg-indigo-600 text-white shadow-sm flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                <span>استشارات وخبراء المشروع</span>
            </a>
        </div>
        <a href="{{ route('team.report', $team) }}" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 transition flex items-center gap-1.5">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>طباعة التقرير الشامل</span>
        </a>
    </div>

    <!-- Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-950 border border-slate-800 p-6 sm:p-8 text-white shadow-xl">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                        👨‍🏫 مركز الإرشاد والاستشارات الاستراتيجية
                    </span>
                    <span class="text-xs text-slate-400 font-bold">مشروع: {{ $team->project_title }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">
                    استشارات وخبراء توجيه المشروع
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    احجز جلسات توجيه تخصصية مع نخبة الخبراء والاستشاريين في مجالات الذكاء الاصطناعي، الأمن السيبراني، البنى التحتية السحابية، ونمذجة الأعمال لضمان أعلى معايير الجودة والجاهزية.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <button type="button"
                        @click="selectedAdvisor = { name: '', title: '', category: 'technical' }; requestModal = true"
                        class="px-5 py-3 rounded-2xl bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 font-black text-xs sm:text-sm shadow-lg shadow-indigo-600/30 flex items-center gap-2 transition hover:scale-[1.02] cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/></svg>
                    <span>طلب استشارة متخصصة</span>
                </button>
            </div>
        </div>

        <!-- Metric Counter Tiles -->
        <div class="mt-8 pt-6 border-t border-slate-800/80 grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                <span class="block text-xs font-bold text-slate-400">إجمالي الجلسات</span>
                <span class="text-2xl font-black text-white font-readex mt-1">{{ $stats['total'] }}</span>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                <span class="block text-xs font-bold text-indigo-300">مؤكدة ومجدولة</span>
                <span class="text-2xl font-black text-indigo-400 font-readex mt-1">{{ $stats['scheduled'] }}</span>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                <span class="block text-xs font-bold text-emerald-300">مكتملة وموثقة</span>
                <span class="text-2xl font-black text-emerald-400 font-readex mt-1">{{ $stats['completed'] }}</span>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                <span class="block text-xs font-bold text-amber-300">قيد المطابقة والمراجعة</span>
                <span class="text-2xl font-black text-amber-400 font-readex mt-1">{{ $stats['pending'] }}</span>
            </div>
        </div>
    </div>

    <!-- Advisors Showcase Carousel / Grid -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                <h3 class="text-base font-black text-slate-900 dark:text-white">نخبة الخبراء والمستشارين المعتمدين للمشروع</h3>
            </div>
            <a href="{{ route('consultants.index') }}" target="_blank" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                استعراض دليل الخبراء الكامل ↗
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($advisors as $advisor)
                <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-2xl p-4 flex flex-col justify-between shadow-2xs hover:shadow-md hover:border-indigo-400 dark:hover:border-indigo-600 transition group">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white font-black text-xs flex items-center justify-center shadow-xs">
                                {{ $advisor['avatar'] }}
                            </div>
                            <span class="text-[11px] font-bold text-amber-500 flex items-center gap-1 font-readex">
                                <span>★</span>
                                <span>{{ $advisor['rating'] }}</span>
                            </span>
                        </div>

                        <div>
                            <h4 class="text-xs font-black text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ $advisor['name'] }}
                            </h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-2 leading-relaxed">
                                {{ $advisor['title'] }}
                            </p>
                        </div>

                        <span class="inline-block px-2 py-0.5 rounded-md text-[10px] font-bold bg-indigo-50 dark:bg-indigo-950/80 text-indigo-700 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800/60">
                            {{ $advisor['specialty'] }}
                        </span>
                    </div>

                    <button type="button" 
                            @click="openAdvisorModal({{ json_encode($advisor) }})"
                            class="mt-4 w-full py-2 rounded-xl text-xs font-bold bg-slate-100 dark:bg-slate-800 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 text-slate-700 dark:text-slate-200 transition-all cursor-pointer">
                        طلب جلسة
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Active Sessions Section & Filter Tabs -->
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-200/80 dark:border-slate-800 pb-3">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                <h3 class="text-base font-black text-slate-900 dark:text-white">سجل الجلسات والاستشارات المسجلة للفريق</h3>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" 
                        @click="activeTab = 'all'"
                        :class="activeTab === 'all' ? 'bg-indigo-600 text-white font-black' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold'"
                        class="px-3 py-1.5 rounded-xl text-xs transition">
                    الكل ({{ $consultations->count() }})
                </button>
                <button type="button" 
                        @click="activeTab = 'confirmed'"
                        :class="activeTab === 'confirmed' ? 'bg-indigo-600 text-white font-black' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold'"
                        class="px-3 py-1.5 rounded-xl text-xs transition">
                    مجدولة ({{ $stats['scheduled'] }})
                </button>
                <button type="button" 
                        @click="activeTab = 'completed'"
                        :class="activeTab === 'completed' ? 'bg-indigo-600 text-white font-black' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold'"
                        class="px-3 py-1.5 rounded-xl text-xs transition">
                    مكتملة وموثقة ({{ $stats['completed'] }})
                </button>
                <button type="button" 
                        @click="activeTab = 'pending'"
                        :class="activeTab === 'pending' ? 'bg-indigo-600 text-white font-black' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold'"
                        class="px-3 py-1.5 rounded-xl text-xs transition">
                    قيد المراجعة ({{ $stats['pending'] }})
                </button>
            </div>
        </div>

        @if($consultations->isEmpty())
            <div class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-3xl p-12 text-center space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 mx-auto flex items-center justify-center">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h4 class="text-base font-black text-slate-900 dark:text-white">لم يتم تسجيل أي طلب استشارة حتى الآن</h4>
                <p class="text-xs text-slate-500 max-w-md mx-auto">
                    يمكن لقائد الفريق وأعضائه حجز جلسات استشارية مع نخبة الموجهين لمراجعة جودة المنتج والهندسة المعمارية.
                </p>
                <button type="button" @click="requestModal = true" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold text-xs shadow-md">
                    طلب أول استشارة
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($consultations as $session)
                    <div x-show="activeTab === 'all' || activeTab === '{{ $session->status }}'"
                         x-transition
                         class="bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 rounded-3xl p-6 shadow-xs hover:shadow-lg transition-all flex flex-col justify-between space-y-4">
                        
                        <div class="space-y-3">
                            <!-- Card Header -->
                            <div class="flex items-center justify-between gap-3 flex-wrap">
                                <span class="px-3 py-1 rounded-full text-xs font-black bg-{{ $session->status_color }}-50 dark:bg-{{ $session->status_color }}-950/80 text-{{ $session->status_color }}-700 dark:text-{{ $session->status_color }}-300 border border-{{ $session->status_color }}-200 dark:border-{{ $session->status_color }}-800">
                                    {{ $session->status_label }}
                                </span>
                                <span class="text-xs text-slate-400 font-bold">
                                    {{ $session->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <!-- Topic Title & Category -->
                            <div>
                                <span class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400">{{ $session->category_label }}</span>
                                <h4 class="text-base font-black text-slate-900 dark:text-white mt-0.5 leading-snug">
                                    {{ $session->topic }}
                                </h4>
                                @if($session->description)
                                    <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 leading-relaxed">
                                        {{ $session->description }}
                                    </p>
                                @endif
                            </div>

                            <!-- Consultant Identity -->
                            <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800">
                                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white font-black text-xs flex items-center justify-center shrink-0">
                                    {{ $session->consultant_avatar ?? 'EX' }}
                                </div>
                                <div class="overflow-hidden">
                                    <span class="block text-xs font-black text-slate-900 dark:text-white truncate">{{ $session->consultant_name }}</span>
                                    <span class="block text-[11px] text-slate-500 dark:text-slate-400 truncate">{{ $session->consultant_title }}</span>
                                </div>
                            </div>

                            <!-- Session Schedule & Meeting Link -->
                            @if($session->session_date)
                                <div class="flex items-center justify-between gap-3 text-xs bg-indigo-50/50 dark:bg-indigo-950/40 p-3 rounded-2xl border border-indigo-100 dark:border-indigo-900/60">
                                    <div class="flex items-center gap-2 text-indigo-700 dark:text-indigo-300 font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>موعد الجلسة: {{ $session->session_date->format('Y-m-d — h:i A') }}</span>
                                    </div>
                                    @if($session->meeting_link)
                                        <a href="{{ $session->meeting_link }}" target="_blank" class="px-3 py-1 rounded-xl bg-indigo-600 text-white font-bold text-xs hover:bg-indigo-700 transition flex items-center gap-1 shadow-xs">
                                            <span>دخول الاجتماع</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <!-- Recommendations / Executive Feedback Block -->
                            @if($session->recommendations)
                                <div class="p-4 rounded-2xl bg-emerald-50/60 dark:bg-emerald-950/30 border border-emerald-200/70 dark:border-emerald-800/70 space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-emerald-800 dark:text-emerald-300 flex items-center gap-1.5">
                                            <span>📋 توصيات ومخرجات المستشار المعتمدة:</span>
                                        </span>
                                        @if($session->rating)
                                            <span class="text-xs text-amber-500 font-bold">
                                                {{ str_repeat('★', $session->rating) }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-700 dark:text-slate-300 whitespace-pre-line leading-relaxed">
                                        {{ $session->recommendations }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Card Actions Footer -->
                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3">
                            <span class="text-[11px] text-slate-400">
                                مقدم الطلب: {{ $session->requester->name ?? 'قائد الفريق' }}
                            </span>
                            <div class="flex items-center gap-2">
                                <button type="button" 
                                        @click="openReviewModal({{ json_encode($session) }})"
                                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-indigo-50 dark:bg-indigo-950/70 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-100 dark:hover:bg-indigo-900/60 transition">
                                    تحديث الحالة والتوصيات
                                </button>
                                <form action="{{ route('team.consultations.destroy', $session) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف جلسة الاستشارة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-500 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- ============================================================
         MODAL 1: REQUEST NEW CONSULTATION
         ============================================================ -->
    <div x-show="requestModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl relative"
             @click.outside="requestModal = false">
            
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-base font-black text-slate-900 dark:text-white">طلب جلسة استشارة وتوجيه</h3>
                </div>
                <button @click="requestModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1">✕</button>
            </div>

            <form action="{{ route('team.consultations.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">اسم المستشار أو الخبير:</label>
                    <input type="text" name="consultant_name" x-model="selectedAdvisor.name" required
                           placeholder="مثال: د. نبيل عبد الحكيم الشرعبي"
                           class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">المسمى المهني للخبير:</label>
                        <input type="text" name="consultant_title" x-model="selectedAdvisor.title"
                               placeholder="مثال: استشاري أول ذكاء اصطناعي"
                               class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">تصنيف الاستشارة:</label>
                        <select name="category" x-model="selectedAdvisor.category" class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500">
                            <option value="technical">استشارة معمارية وتقنية</option>
                            <option value="security">تدقيق أمني واختراق قياسي</option>
                            <option value="business">نموذج عمل واستثمار</option>
                            <option value="ux">تصميم وتجربة مستخدم UI/UX</option>
                            <option value="legal">قانوني وحماية ملكية فكرية</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">عنوان وموضوع الجلسة:</label>
                    <input type="text" name="topic" required
                           placeholder="مثال: مراجعة خطة النشر والـ Scaling ومعالجة زمن الاستجابة"
                           class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">محاور النقاش والأسئلة المحددة للمستشار:</label>
                    <textarea name="description" rows="3"
                              placeholder="اذكر أهم التحديات التي تواجه الفريق وترغبون في مناقشتها مع الخبير..."
                              class="w-full p-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">الموعد المقترح (اختياري):</label>
                        <input type="datetime-local" name="session_date"
                               class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">رابط اللقاء الافتراضي (Google Meet):</label>
                        <input type="url" name="meeting_link"
                               placeholder="https://meet.google.com/..."
                               class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" @click="requestModal = false" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800">
                        إلغاء
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-md shadow-indigo-600/30">
                        تأكيد طلب الجلسة
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================
         MODAL 2: UPDATE STATUS & LOG RECOMMENDATIONS
         ============================================================ -->
    <div x-show="reviewModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl relative"
             @click.outside="reviewModal = false">
            
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-base font-black text-slate-900 dark:text-white">توثيق توصيات ومخرجات الجلسة</h3>
                </div>
                <button @click="reviewModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1">✕</button>
            </div>

            <template x-if="selectedConsultation">
                <form :action="'/my-team/consultations/' + selectedConsultation.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">حالة الجلسة:</label>
                        <select name="status" x-model="selectedConsultation.status" class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500">
                            <option value="pending">قيد المراجعة والمطابقة</option>
                            <option value="confirmed">مؤكدة ومجدولة</option>
                            <option value="completed">مكتملة وموثقة (Completed)</option>
                            <option value="cancelled">ملغاة (Cancelled)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">موعد الجلسة:</label>
                            <input type="datetime-local" name="session_date"
                                   :value="selectedConsultation.session_date ? selectedConsultation.session_date.substring(0, 16) : ''"
                                   class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">تقييم الجلسة (1-5 نجوم):</label>
                            <select name="rating" x-model="selectedConsultation.rating" class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500">
                                <option value="">بدون تقييم</option>
                                <option value="5">★★★★★ 5 نجوم (ممتازة ومثمرة جداً)</option>
                                <option value="4">★★★★☆ 4 نجوم (جيدة جداً)</option>
                                <option value="3">★★★☆☆ 3 نجوم (جيدة ومفيدة)</option>
                                <option value="2">★★☆☆☆ نجمتان</option>
                                <option value="1">★☆☆☆☆ نجمة واحدة</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">رابط اللقاء الافتراضي:</label>
                        <input type="url" name="meeting_link" x-model="selectedConsultation.meeting_link"
                               placeholder="https://meet.google.com/..."
                               class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">التوصيات والملاحظات المعتمدة من المستشار:</label>
                        <textarea name="recommendations" rows="4" x-model="selectedConsultation.recommendations"
                                  placeholder="اكتب التوجيهات الفنية والتعديلات المعمارية التي أوصى بها الخبير ليتبعها الفريق..."
                                  class="w-full p-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white outline-none focus:border-indigo-500 leading-relaxed"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                        <button type="button" @click="reviewModal = false" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800">
                            إلغاء
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md shadow-emerald-600/30">
                            حفظ وتوثيق التوصيات
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>

</div>
@endsection

