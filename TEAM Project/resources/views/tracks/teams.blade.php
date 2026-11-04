@extends('layouts.frontend')

@section('title', 'مسار الفرق والمشاريع التقنية والريادية - منصة TEAM Hub')

@section('content')

    <!-- 1. Hero Section (Open, Majestic, Centered - Matches Home Page) -->
    <section class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                
                <!-- Pill Identity Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/90 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-900/5 mb-8 backdrop-blur-xl">
                    <span class="text-lg">🚀</span>
                    <span class="text-xs sm:text-sm font-black text-indigo-600 dark:text-indigo-400">مسار الفرق والمشاريع التقنية والريادية</span>
                    <span class="text-[11px] text-slate-400 dark:text-slate-500 font-bold hidden sm:inline">| Team Builders & Innovators Track</span>
                </div>

                <!-- Grand Title with Gradient Clip -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 dark:text-white leading-[1.25] tracking-tight mb-6 font-readex">
                    بيئة العمل الرشيقة المتكاملة <br class="hidden sm:inline" />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-indigo-500 to-amber-500">لقيادة مشروعك التقني</span> من الفكرة حتى الإنتاج
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed font-normal mb-10 max-w-3xl mx-auto">
                    صمم هذا المسار للمطورين، مهندسي البرمجيات، قادة الفرق، ورواد الأعمال؛ حيث يمنحك كافة الأدوات الاحترافية لتنظيم المهام، استقطاب النخب، مراجعة المعمارية مع كبار الاستشاريين، والجاهزية لجذب الرعاية والتمويل.
                </p>

                <!-- Dual Action CTAs -->
                <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4 mb-14">
                    <a href="{{ route('register', ['track' => 'team']) }}" class="px-8 py-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-sm sm:text-base shadow-xl shadow-indigo-600/30 hover:scale-105 transition-all flex items-center gap-2 cursor-pointer font-readex">
                        <span>🚀 تسجيل حساب وبدء فريقك الآن</span>
                    </a>
                    <a href="{{ route('login') }}" class="px-7 py-4 rounded-2xl bg-white dark:bg-slate-900 text-slate-800 dark:text-white font-extrabold text-sm sm:text-base border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-all cursor-pointer font-readex">
                        تسجيل الدخول إلى حسابك ←
                    </a>
                    <a href="{{ route('teams.index') }}" class="px-5 py-4 rounded-2xl text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-bold text-xs sm:text-sm transition-all">
                        تصفح دليل الفرق النشطة ↗
                    </a>
                </div>

                <!-- 4 Floating Live Metric Badges (Identical to Homepage Metric Cards) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 max-w-5xl mx-auto pt-8 border-t border-slate-200/80 dark:border-slate-800/80 text-right">
                    
                    <!-- Metric Card 1: Active Teams (Cyan/Blue) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">الفرق النشطة في المنظومة</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">{{ $stats['active_teams'] }}+</h3>
                                <p class="text-[11px] font-bold text-cyan-600 dark:text-cyan-400 mt-1">● فريق تقني مسجل</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-cyan-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 2: Completed Projects (Amber/Orange) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">مشاريع جاهزة ومكتملة</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">{{ $stats['completed_projects'] }}+</h3>
                                <p class="text-[11px] font-bold text-amber-600 dark:text-amber-400 mt-1">★ جاهزة للاستثمار والإنتاج</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 3: Developers Count (Emerald/Teal) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">مطور ومبتكر مسجل</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">{{ $stats['developers_count'] }}+</h3>
                                <p class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 mt-1">✓ كفاءات ونخب برمجية</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 4: Satisfaction Rate (Indigo/Purple) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">نسبة رضا قادة الفرق</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">{{ $stats['satisfaction_rate'] }}</h3>
                                <p class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 mt-1">💎 تجربة مستخدم استثنائية</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2m-7 0H4a2 2 0 00-2 2v7a2 2 0 002 2h3" />
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- 2. Trust & University Partners Banner (Matches Home Page) -->
    <section class="py-12 border-y border-slate-200/70 dark:border-slate-800/70 bg-white/60 dark:bg-[#080d18] relative z-10 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-black text-slate-400 uppercase tracking-widest mb-8">
                بيئة العمل البرمجية المعتمدة لفرق المشاريع والابتكارات الوطنية
            </p>
            <div class="flex flex-wrap items-center justify-center gap-8 sm:gap-14 opacity-75 grayscale hover:grayscale-0 transition-all duration-300">
                <div class="flex items-center gap-2.5 font-black text-sm text-slate-700 dark:text-slate-200">
                    <span class="w-8 h-8 rounded-xl bg-indigo-100 dark:bg-indigo-950 text-indigo-600 flex items-center justify-center text-xs font-black">SU</span>
                    <span>جامعة صنعاء</span>
                </div>
                <div class="flex items-center gap-2.5 font-black text-sm text-slate-700 dark:text-slate-200">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-950 text-blue-600 flex items-center justify-center text-xs font-black">AU</span>
                    <span>جامعة عدن</span>
                </div>
                <div class="flex items-center gap-2.5 font-black text-sm text-slate-700 dark:text-slate-200">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 flex items-center justify-center text-xs font-black">UST</span>
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
                <span class="text-xs font-black px-3.5 py-1.5 rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 uppercase tracking-wider">
                    الأدوات والميزات الحصرية بعد تسجيل الدخول
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mt-4 mb-3 font-readex">
                    ماذا ستحصل عند تسجيل الدخول إلى المنظومة؟
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    بمجرد إنشاء حسابك وتأسيس فريقك، تفتح لك المنصة لوحة قيادة مركزية متكاملة تضم 6 وحدات برمجية فائقة التطور.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($features as $feat)
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-8 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between">
                        
                        <div>
                            <!-- 3D Header Icon -->
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white mb-6 shadow-lg shadow-indigo-500/25 group-hover:scale-110 transition-transform">
                                <span class="text-2xl">⚡</span>
                            </div>

                            <span class="text-xs font-black px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                {{ $feat['badge'] }}
                            </span>

                            <h3 class="text-xl font-black text-slate-900 dark:text-white mt-3 mb-3 font-readex group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ $feat['title'] }}
                            </h3>

                            <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed mb-6">
                                {{ $feat['description'] }}
                            </p>

                            <!-- Bullet Points -->
                            <ul class="space-y-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 mb-8 border-t border-slate-100 dark:border-slate-700/60 pt-4">
                                @foreach($feat['details'] as $detail)
                                    <li class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                        <span>{{ $detail }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Footer CTA Pill -->
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-xs">
                            <span class="font-black text-indigo-600 dark:text-indigo-400 flex items-center gap-1 group-hover:translate-x-[-3px] transition-transform">
                                <span>متاح فوراً بعد تسجيل الدخول</span>
                                <span>←</span>
                            </span>
                            <span class="text-[10px] font-bold text-slate-400">لوحة التحكم</span>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- 4. Methodology & Roadmap Section (5 خطوات للنجاح) -->
    <section class="py-20 relative z-10 border-t border-slate-200/80 dark:border-slate-800/80 bg-slate-100/50 dark:bg-[#070c16]/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-black px-3.5 py-1.5 rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 uppercase tracking-wider">
                    منهجية العمل المعتمدة
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mt-4 mb-3 font-readex">
                    كيف يعمل فريقك داخل المنظومة؟ 5 خطوات للنجاح
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    مسار منظم بدقة يضمن لفريقك الانتقال السلس من مرحلة الفكرة إلى الجاهزية الفنية والاستثمارية الكاملة.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                @foreach($steps as $step)
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-6 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between">
                        <div>
                            <span class="text-3xl font-black text-indigo-600 dark:text-indigo-400 font-readex block mb-3 opacity-90">{{ $step['num'] }}</span>
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
            <div class="relative rounded-3xl bg-gradient-to-l from-indigo-950/90 via-slate-900 to-slate-950 p-8 sm:p-14 text-white overflow-hidden shadow-2xl border border-slate-700/60 dark:border-slate-800">
                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-purple-500/20 blur-3xl pointer-events-none"></div>

                <div class="relative z-10 max-w-2xl">
                    <span class="text-xs font-black px-3.5 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300">جاهز لبدء رحلة فريقك؟</span>
                    <h2 class="text-3xl sm:text-4xl font-black mt-4 mb-4 leading-snug font-readex">أنشئ حساب فريقك وابدأ التنظيم الاحترافي اليوم</h2>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed mb-8">
                        انضم إلى أكثر من 128 فريقاً تقنياً يديرون مشاريعهم بأعلى المعايير، وتواصل مع الشركات والمستشارين لصقل ابتكارك وجذب الرعاية.
                    </p>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('register', ['track' => 'team']) }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-black text-xs sm:text-sm shadow-xl shadow-indigo-600/30 transition-all hover:scale-105 font-readex cursor-pointer">
                            إنشاء حساب وبدء فريق جديد الآن ←
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-4 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs sm:text-sm border border-white/20 transition-all cursor-pointer">
                            تسجيل الدخول إلى حسابك
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
