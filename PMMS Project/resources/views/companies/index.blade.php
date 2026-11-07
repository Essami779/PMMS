@extends('layouts.frontend')

@section('title', 'دليل الشركات والفرص - منصة TEAM Hub')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto pb-10" x-data="{ 
    selectedSector: 'الكل',
    searchQuery: '',
    sponsorModal: false,
    selectedCompany: null,
    openSponsorModal(company) {
        this.selectedCompany = company;
        this.sponsorModal = true;
    }
}">

    <!-- 1. Executive Luxury Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-l from-amber-500/15 via-orange-500/5 to-white dark:from-amber-950/60 dark:via-slate-900 dark:to-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-sm">
        <!-- Ambient Decorative Glows -->
        <div class="absolute -left-16 -top-16 w-64 h-64 bg-amber-500/10 dark:bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2 max-w-3xl">
                <div class="flex items-center gap-2.5 flex-wrap">
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-50 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800/80 shadow-2xs">
                        🏢 مسار الشراكات والاستثمار
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300">
                        {{ count($sampleCompanies) }} شركات وجهات راعية معتمدة
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    دليل الشركات وفرص الرعاية والاستثمار
                </h1>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    استكشف الشركات الوطنية والمؤسسات الراعية لمشاريع التخرج، واكتشف برامج الاحتضان والتمويل ومسارات التدريب والتوظيف المباشر.
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('register', ['track' => 'company']) }}" 
                   class="px-5 py-3 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 font-black text-xs sm:text-sm shadow-lg shadow-amber-500/25 flex items-center gap-2 transition-all hover:scale-[1.02] cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>انضمام كشريك راعٍ</span>
                </a>
            </div>
        </div>

        <!-- Sectors Filter Tabs -->
        <div class="mt-6 pt-5 border-t border-slate-200/70 dark:border-slate-800/80 flex items-center gap-2 overflow-x-auto pb-1 custom-scrollbar">
            @foreach($sectors as $sector)
                <button type="button" 
                        @click="selectedSector = '{{ $sector }}'"
                        :class="selectedSector === '{{ $sector }}' 
                            ? 'bg-amber-500 text-slate-950 font-black shadow-md shadow-amber-500/30 ring-2 ring-amber-500/40' 
                            : 'bg-white/80 dark:bg-slate-800/80 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-amber-400 hover:text-amber-600 dark:hover:text-amber-400'"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all duration-200 cursor-pointer">
                    {{ $sector }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- 2. Search & Controls Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xs">
        <div class="flex items-center gap-2 text-xs font-bold text-slate-700 dark:text-slate-300">
            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
            <span>عرض الشركات حسب القطاع:</span>
            <span class="text-amber-600 dark:text-amber-400 font-black" x-text="selectedSector"></span>
        </div>

        <div class="relative w-full sm:w-80">
            <input type="text" 
                   x-model="searchQuery" 
                   placeholder="بحث باسم الشركة، المدينة، أو نبذة..." 
                   class="w-full h-10 pr-9 pl-4 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder:text-slate-400 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 transition-all">
            <svg class="w-4 h-4 absolute right-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- 3. Companies Grid Showcase -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($sampleCompanies as $company)
            <div x-show="(selectedSector === 'الكل' || selectedSector === '{{ $company['sector'] }}') && ('{{ $company['name'] }} {{ $company['city'] }} {{ $company['about'] }}').toLowerCase().includes(searchQuery.toLowerCase())"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 flex flex-col justify-between shadow-xs hover:shadow-xl hover:border-amber-500/40 dark:hover:border-amber-500/40 transition-all duration-300 group">
                
                <div>
                    <!-- Top Header Row -->
                    <div class="flex items-start gap-4 mb-5">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-tr {{ $company['logo_bg'] }} flex items-center justify-center text-white font-black text-xl sm:text-2xl shadow-md shrink-0 group-hover:scale-105 transition-transform">
                            {{ mb_substr($company['name'], 0, 1) }}
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-md bg-amber-50 text-amber-800 dark:bg-amber-950/80 dark:text-amber-300 border border-amber-200/60 dark:border-amber-800/60 truncate">
                                    {{ $company['sector'] }}
                                </span>
                                <span class="text-[11px] text-slate-400 font-readex shrink-0">تأسست {{ $company['established'] }}</span>
                            </div>
                            <h3 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white mt-1.5 leading-snug group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                                {{ $company['name'] }}
                            </h3>
                            <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5 mt-1">
                                <span>📍 {{ $company['city'] }}</span>
                                <span>•</span>
                                <span class="text-emerald-600 dark:text-emerald-400 font-bold">{{ $company['supported_teams_count'] }} فريق تم دعمه</span>
                            </div>
                        </div>
                    </div>

                    <!-- About description -->
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mb-5">
                        {{ $company['about'] }}
                    </p>

                    <!-- Sponsorship Tracks Pills -->
                    <div class="mb-5">
                        <div class="text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-2">مسارات الرعاية المتاحة:</div>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($company['sponsorship_tracks'] as $track)
                                <span class="text-[10.5px] font-semibold px-2.5 py-1 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200/60 dark:border-slate-700/60">
                                    ✓ {{ $track }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Bottom Meta & Actions -->
                <div class="border-t border-slate-100 dark:border-slate-800 pt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="text-xs font-bold text-amber-700 dark:text-amber-400 flex items-center gap-1.5 font-readex">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span>{{ $company['open_opportunities'] }} فرص رعاية نشطة</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" 
                                @click="openSponsorModal({{ json_encode($company) }})"
                                class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shadow-md shadow-amber-500/20 transition-all cursor-pointer text-center">
                            تقديم طلب رعاية
                        </button>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    <!-- 4. Interactive Sponsor Modal -->
    <div x-show="sponsorModal" 
         x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 max-w-md w-full shadow-2xl relative"
             @click.outside="sponsorModal = false">
            
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h4 class="text-sm font-black text-slate-900 dark:text-white">تقديم طلب رعاية وشراكة</h4>
                </div>
                <button @click="sponsorModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <template x-if="selectedCompany">
                <div class="space-y-4">
                    <div class="p-3.5 rounded-2xl bg-amber-50/50 dark:bg-amber-950/30 border border-amber-200/60 dark:border-amber-800/60">
                        <p class="text-xs font-black text-slate-800 dark:text-slate-100" x-text="selectedCompany.name"></p>
                        <p class="text-[11px] text-amber-700 dark:text-amber-400 mt-0.5" x-text="selectedCompany.sector + ' • ' + selectedCompany.city"></p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">اسم مشروع التخرج أو الفريق:</label>
                        <input type="text" placeholder="مثال: فريق الذكاء التشخيصي..." class="w-full h-10 px-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white outline-none focus:border-amber-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">نوع الدعم أو الرعاية المطلوبة:</label>
                        <select class="w-full h-10 px-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white outline-none focus:border-amber-500">
                            <option>تمويل نقدي وشراء عتاد</option>
                            <option>رعاية وتدريب عملي</option>
                            <option>استضافة سحابية وبيئة اختبار</option>
                            <option>تبني المشروع واحتضانه تجارياً</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">ملخص الفكرة والقيمة المضافة للشركة:</label>
                        <textarea rows="3" placeholder="اشرح باختصار لماذا مشروعك مناسب لهذه الشركة..." class="w-full p-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white outline-none focus:border-amber-500"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" @click="sponsorModal = false" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                            إلغاء
                        </button>
                        <a href="{{ route('register', ['track' => 'team']) }}" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shadow-md shadow-amber-500/25">
                            إرسال الطلب
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </div>

</div>
@endsection
