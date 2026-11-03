@extends('layouts.app')

@section('title', 'دليل المستشارين والخبراء - منصة TEAM Hub')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto pb-10" x-data="{ 
    selectedSpecialty: 'الكل',
    searchQuery: '',
    bookingModal: false,
    selectedConsultant: null,
    openBooking(consultant) {
        this.selectedConsultant = consultant;
        this.bookingModal = true;
    }
}">

    <!-- 1. Executive Luxury Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-l from-emerald-500/15 via-teal-500/5 to-white dark:from-emerald-950/60 dark:via-slate-900 dark:to-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-sm">
        <!-- Ambient Decorative Glows -->
        <div class="absolute -left-16 -top-16 w-64 h-64 bg-emerald-500/10 dark:bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2 max-w-3xl">
                <div class="flex items-center gap-2.5 flex-wrap">
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/80 shadow-2xs">
                        👨‍🏫 مسار الاستشارات والتحكيم
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200 dark:border-indigo-800 text-indigo-700 dark:text-indigo-300">
                        {{ count($sampleConsultants) }} خبراء ومستشارين معتمدين
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    نخبة المستشارين والخبراء الأكاديميين
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    احصل على إشراف دقيق لمشروع تخرجك، واستشارات معمارية وبرمجية متقدمة، وتحكيم احترافي مباشر من أساتذة الجامعات وكبار مهندسي الصناعة.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('register', ['track' => 'consultant']) }}" 
                   class="px-5 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-black text-xs sm:text-sm shadow-lg shadow-emerald-600/25 flex items-center gap-2 transition-all hover:scale-[1.02] cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>تسجيل كخبير استشاري</span>
                </a>
            </div>
        </div>

        <!-- Specialties Filter Tabs -->
        <div class="mt-6 pt-5 border-t border-slate-200/70 dark:border-slate-800/80 flex items-center gap-2 overflow-x-auto pb-1 custom-scrollbar">
            @foreach($specialties as $spec)
                <button type="button" 
                        @click="selectedSpecialty = '{{ $spec }}'"
                        :class="selectedSpecialty === '{{ $spec }}' 
                            ? 'bg-emerald-600 text-white font-black shadow-md shadow-emerald-600/30 ring-2 ring-emerald-600/40' 
                            : 'bg-white/80 dark:bg-slate-800/80 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-emerald-400 hover:text-emerald-600 dark:hover:text-emerald-400'"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all duration-200 cursor-pointer">
                    {{ $spec }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- 2. Search & Controls Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs">
        <div class="flex items-center gap-2 text-xs font-bold text-slate-700 dark:text-slate-300">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>عرض المستشارين حسب التخصص:</span>
            <span class="text-emerald-600 dark:text-emerald-400 font-black" x-text="selectedSpecialty"></span>
        </div>

        <div class="relative w-full sm:w-80">
            <input type="text" 
                   x-model="searchQuery" 
                   placeholder="بحث بالاسم، الجامعة، أو التخصص..." 
                   class="w-full h-10 pr-9 pl-4 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder:text-slate-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
            <svg class="w-4 h-4 absolute right-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- 3. Consultants Grid Showcase -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($sampleConsultants as $consultant)
            <div x-show="(selectedSpecialty === 'الكل' || selectedSpecialty === '{{ $consultant['specialty'] }}') && ('{{ $consultant['name'] }} {{ $consultant['title'] }} {{ $consultant['university'] }} {{ implode(' ', $consultant['skills']) }}').toLowerCase().includes(searchQuery.toLowerCase())"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 flex flex-col justify-between shadow-xs hover:shadow-xl hover:border-emerald-500/40 dark:hover:border-emerald-500/40 transition-all duration-300 group">
                
                <div>
                    <!-- Header Row with Avatar & Credentials -->
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-black text-xl sm:text-2xl shadow-md shrink-0 group-hover:scale-105 transition-transform">
                            {{ mb_substr($consultant['name'], 2, 1) }}
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-md bg-emerald-50 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/60 truncate">
                                    {{ $consultant['specialty'] }}
                                </span>
                                <div class="flex items-center gap-1 text-xs font-bold text-amber-500 shrink-0 font-readex">
                                    <span>★ {{ $consultant['rating'] }}</span>
                                    <span class="text-slate-400">({{ $consultant['reviews_count'] }})</span>
                                </div>
                            </div>
                            <h3 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white mt-1.5 leading-snug group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                {{ $consultant['name'] }}
                            </h3>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-medium truncate">
                                {{ $consultant['title'] }} • <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $consultant['university'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bio summary -->
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
                        {{ $consultant['bio'] }}
                    </p>

                    <!-- Skills Tags -->
                    <div class="flex flex-wrap gap-1.5 mb-5">
                        @foreach($consultant['skills'] as $skill)
                            <span class="text-[10.5px] font-semibold px-2.5 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700/60">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Bottom Meta & Actions -->
                <div class="border-t border-slate-100 dark:border-slate-800 pt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="text-xs text-slate-500 dark:text-slate-400 font-readex">
                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ $consultant['experience_years'] }} سنوات خبرة</span>
                        <span>•</span>
                        <span class="text-emerald-600 dark:text-emerald-400 font-bold">{{ $consultant['consultation_hours'] }}+ ساعة إرشادية</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" 
                                @click="openBooking({{ json_encode($consultant) }})"
                                class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition-all cursor-pointer text-center">
                            حجز موعد استشارة
                        </button>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    <!-- 4. Interactive Consultation Booking Modal -->
    <div x-show="bookingModal" 
         x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 max-w-md w-full shadow-2xl relative"
             @click.outside="bookingModal = false">
            
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white">حجز جلسة إرشاد وتحكيم</h4>
                </div>
                <button @click="bookingModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <template x-if="selectedConsultant">
                <div class="space-y-4">
                    <div class="p-3.5 rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/30 border border-emerald-200/60 dark:border-emerald-800/60 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-black flex items-center justify-center text-sm" x-text="selectedConsultant.name ? selectedConsultant.name.charAt(0) : 'خ'">
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-800 dark:text-slate-100" x-text="selectedConsultant.name"></p>
                            <p class="text-[11px] text-emerald-700 dark:text-emerald-400" x-text="selectedConsultant.title + ' • ' + selectedConsultant.university"></p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">موضوع الاستشارة أو التحكيم:</label>
                        <select class="w-full h-10 px-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white outline-none focus:border-emerald-500">
                            <option>مراجعة معمارية النظام والـ Code Review</option>
                            <option>تحكيم النموذج الأولي (MVP Review)</option>
                            <option>إعداد مقترح المنح والتمويل</option>
                            <option>استشارة بحثية وأكاديمية للمشروع</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">موعد الجلسة المفضل:</label>
                        <input type="datetime-local" class="w-full h-10 px-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white outline-none focus:border-emerald-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">أسئلة محددة تود مناقشتها مع المستشار:</label>
                        <textarea rows="3" placeholder="اكتب أهم النقاط والتحديات التقنية..." class="w-full p-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white outline-none focus:border-emerald-500"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" @click="bookingModal = false" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                            إلغاء
                        </button>
                        <a href="{{ route('register', ['track' => 'team']) }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/25">
                            تأكيد الحجز
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </div>

</div>
@endsection
