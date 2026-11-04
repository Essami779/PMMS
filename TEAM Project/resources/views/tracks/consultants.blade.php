@extends('layouts.frontend')

@section('title', 'مسار الخبراء والمستشارين والتحكيم الأكاديمي - منصة TEAM Hub')

@section('content')

    <!-- 1. Hero Section (Open, Majestic, Centered - Matches Home Page Consultant Persona) -->
    <section class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                
                <!-- Pill Identity Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/90 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-900/5 mb-8 backdrop-blur-xl">
                    <span class="text-lg">👨‍🏫</span>
                    <span class="text-xs sm:text-sm font-black text-emerald-600 dark:text-emerald-400">مسار الشخصية الاستشارية والتحكيم الأكاديمي</span>
                    <span class="text-[11px] text-slate-400 dark:text-slate-500 font-bold hidden sm:inline">| Academic Advisors & Jurors Track</span>
                </div>

                <!-- Grand Title with Gradient Clip -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 dark:text-white leading-[1.25] tracking-tight mb-6 font-readex">
                    قدّم <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 via-teal-500 to-indigo-600">خبرتك الاستشارية</span> <br class="hidden sm:inline" />
                    ووجّه الجيل القادم من المبتكرين
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed font-normal mb-10 max-w-3xl mx-auto">
                    امتلك ملفاً استشارياً مهنياً معتمداً، قدّم جلسات إرشاد متخصصة لمراجعة المعمارية والكود، شارك في لجان التحكيم الوطنية، وساهم في صقل مخرجات الفرق وإعدادها لسوق العمل والاستثمار.
                </p>

                <!-- Dual Action CTAs -->
                <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4 mb-14">
                    <a href="{{ route('register', ['track' => 'consultant']) }}" class="px-8 py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-sm sm:text-base shadow-xl shadow-emerald-600/30 hover:scale-105 transition-all flex items-center gap-2 cursor-pointer font-readex">
                        <span>👨‍🏫 انضمام كمستشار وخبير معتمد</span>
                    </a>
                    <a href="{{ route('login') }}" class="px-7 py-4 rounded-2xl bg-white dark:bg-slate-900 text-slate-800 dark:text-white font-extrabold text-sm sm:text-base border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-all cursor-pointer font-readex">
                        تسجيل دخول المستشارين ←
                    </a>
                    <a href="{{ route('consultants.index') }}" class="px-5 py-4 rounded-2xl text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 font-bold text-xs sm:text-sm transition-all">
                        تصفح دليل المستشارين ↗
                    </a>
                </div>

                <!-- 4 Floating Live Metric Badges (Identical to Homepage Metric Cards) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 max-w-5xl mx-auto pt-8 border-t border-slate-200/80 dark:border-slate-800/80 text-right">
                    
                    <!-- Metric Card 1: Expert Advisors (Emerald/Teal) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">المستشارون الأكاديميون</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">{{ $stats['expert_advisors'] }}+</h3>
                                <p class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 mt-1">✓ إشراف وتحكيم متخصص</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 2: Consultation Hours (Indigo/Purple) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">ساعات الاستشارة المنجزة</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">{{ $stats['consultation_hours'] }}+</h3>
                                <p class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 mt-1">💎 توجيه هندسي وأكاديمي</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 3: Teams Mentored (Amber/Orange) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">فرق تمت مراجعتها</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">{{ $stats['teams_mentored'] }}+</h3>
                                <p class="text-[11px] font-bold text-amber-600 dark:text-amber-400 mt-1">★ مشاريع مصقولة</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 4: Average Rating (Cyan/Blue) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">متوسط تقييم الخبراء</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">{{ $stats['average_rating'] }} / 5</h3>
                                <p class="text-[11px] font-bold text-cyan-600 dark:text-cyan-400 mt-1">● تقييم استثنائي موثق</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-cyan-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- 2. Trust & Academic Institutions Banner -->
    <section class="py-12 border-y border-slate-200/70 dark:border-slate-800/70 bg-white/60 dark:bg-[#080d18] relative z-10 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-black text-slate-400 uppercase tracking-widest mb-8">
                نخبة من الأساتذة والخبراء يمثلون كبرى الجامعات والمراكز البحثية
            </p>
            <div class="flex flex-wrap items-center justify-center gap-8 sm:gap-14 opacity-75 grayscale hover:grayscale-0 transition-all duration-300">
                <div class="flex items-center gap-2.5 font-black text-sm text-slate-700 dark:text-slate-200">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 flex items-center justify-center text-xs font-black">SU</span>
                    <span>جامعة صنعاء</span>
                </div>
                <div class="flex items-center gap-2.5 font-black text-sm text-slate-700 dark:text-slate-200">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-950 text-blue-600 flex items-center justify-center text-xs font-black">AU</span>
                    <span>جامعة عدن</span>
                </div>
                <div class="flex items-center gap-2.5 font-black text-sm text-slate-700 dark:text-slate-200">
                    <span class="w-8 h-8 rounded-xl bg-indigo-100 dark:bg-indigo-950 text-indigo-600 flex items-center justify-center text-xs font-black">UST</span>
                    <span>جامعة العلوم والتكنولوجيا</span>
                </div>
                <div class="flex items-center gap-2.5 font-black text-sm text-slate-700 dark:text-slate-200">
                    <span class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-950 text-amber-600 flex items-center justify-center text-xs font-black">HU</span>
                    <span>جامعة حضرموت</span>
                </div>
                <div class="flex items-center gap-2.5 font-black text-sm text-slate-700 dark:text-slate-200">
                    <span class="w-8 h-8 rounded-xl bg-rose-100 dark:bg-rose-950 text-rose-600 flex items-center justify-center text-xs font-black">TU</span>
                    <span>جامعة تعز</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. What You Unlock Upon Login (Cards Match Exact Home Page Card Structure) -->
    <section class="py-24 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-black px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 uppercase tracking-wider">
                    الأدوات والميزات الحصرية بعد تسجيل الدخول
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mt-4 mb-3 font-readex">
                    ماذا ستحصل عند تسجيل الدخول كخبير معتمد؟
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    توفر المنصة بيئة رقمية متكاملة للمستشار لتوثيق أثره المعرفي، جدولة جلساته، والمشاركة في تحكيم المعارض والهاكاثونات.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($features as $feat)
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-8 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between">
                        
                        <div>
                            <!-- 3D Header Icon -->
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white mb-6 shadow-lg shadow-emerald-500/25 group-hover:scale-110 transition-transform">
                                <span class="text-2xl">👨‍🏫</span>
                            </div>

                            <span class="text-xs font-black px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                {{ $feat['badge'] }}
                            </span>

                            <h3 class="text-xl font-black text-slate-900 dark:text-white mt-3 mb-3 font-readex group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                {{ $feat['title'] }}
                            </h3>

                            <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed mb-6">
                                {{ $feat['description'] }}
                            </p>

                            <!-- Bullet Points -->
                            <ul class="space-y-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 mb-8 border-t border-slate-100 dark:border-slate-700/60 pt-4">
                                @foreach($feat['details'] as $detail)
                                    <li class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span>{{ $detail }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Footer CTA Pill -->
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-xs">
                            <span class="font-black text-emerald-600 dark:text-emerald-400 flex items-center gap-1 group-hover:translate-x-[-3px] transition-transform">
                                <span>متاح فوراً بعد تسجيل الدخول</span>
                                <span>←</span>
                            </span>
                            <span class="text-[10px] font-bold text-slate-400">مساحة الخبير</span>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- 4. Methodology & Roadmap Section (5 خطوات للمستشارين) -->
    <section class="py-20 relative z-10 border-t border-slate-200/80 dark:border-slate-800/80 bg-slate-100/50 dark:bg-[#070c16]/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-black px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 uppercase tracking-wider">
                    مسار العمل الاستشاري والتحكيم
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mt-4 mb-3 font-readex">
                    كيف تشارك كخبير في المنظومة؟ 5 خطوات للأثر
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    آلية مرنة تحفظ وقتك وتوثق جهودك الإرشادية والتحكيمية بشهادات وسجل أثر رسمي معتمد.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                @foreach($steps as $step)
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-6 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between">
                        <div>
                            <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400 font-readex block mb-3 opacity-90">{{ $step['num'] }}</span>
                            <h4 class="text-sm font-black text-slate-900 dark:text-white mb-2 leading-snug">{{ $step['title'] }}</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- 5. Final Luxury CTA Banner (Matches Home Page Section 5) -->
    <section class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-3xl bg-gradient-to-l from-emerald-950/80 via-slate-900 to-slate-950 p-8 sm:p-14 text-white overflow-hidden shadow-2xl border border-slate-700/60 dark:border-slate-800">
                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-emerald-500/20 blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-teal-500/20 blur-3xl pointer-events-none"></div>

                <div class="relative z-10 max-w-2xl">
                    <span class="text-xs font-black px-3.5 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300">انضم لنخبة الموجهين</span>
                    <h2 class="text-3xl sm:text-4xl font-black mt-4 mb-4 leading-snug font-readex">وثق ملفك الاستشاري وابدأ توجيه فرق الابتكار</h2>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed mb-8">
                        انضم لأكثر من 82 خبيراً معتمداً، وشارك في صياغة مستقبل التقنية والبحث العلمي من خلال توجيه فرق المشاريع الوطنية.
                    </p>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('register', ['track' => 'consultant']) }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-black text-xs sm:text-sm shadow-xl shadow-emerald-600/30 transition-all hover:scale-105 font-readex cursor-pointer">
                            تسجيل حساب مستشار وخبير الآن ←
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-4 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs sm:text-sm border border-white/20 transition-all cursor-pointer">
                            تسجيل الدخول
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
