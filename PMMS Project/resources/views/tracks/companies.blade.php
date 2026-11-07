@extends('layouts.frontend')

@section('title', 'مسار قطاع الأعمال والاستثمار والرعاية - منصة TEAM Hub')

@section('content')

    <!-- 1. Hero Section (Open, Majestic, Centered - Matches Home Page Company Persona) -->
    <section class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                
                <!-- Pill Identity Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/90 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-900/5 mb-8 backdrop-blur-xl">
                    <span class="text-lg">🏢</span>
                    <span class="text-xs sm:text-sm font-black text-amber-600 dark:text-amber-400">مسار قطاع الأعمال والشركات والرعاية</span>
                    <span class="text-[11px] text-slate-400 dark:text-slate-500 font-bold hidden sm:inline">| Enterprise & Sponsorship Hub</span>
                </div>

                <!-- Grand Title with Gradient Clip -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 dark:text-white leading-[1.25] tracking-tight mb-6 font-readex">
                    استثمر في <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 via-orange-500 to-indigo-600">نخبة المشاريع البرمجية</span> <br class="hidden sm:inline" />
                    واستقطب ألمع الكفاءات التقنية
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed font-normal mb-10 max-w-3xl mx-auto">
                    بوابتك المؤسسية للوصول المباشر إلى مئات المشاريع التقنية الواعدة قبل وصولها للسوق، استقطاب أفضل المطورين، طرح تحديات برمجية تخدم نمو أعمالك، وترسيخ دور شركتك الريادي في دعم الابتكار الوطني.
                </p>

                <!-- Dual Action CTAs -->
                <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4 mb-14">
                    <a href="{{ route('register', ['track' => 'company']) }}" class="px-8 py-4 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-sm sm:text-base shadow-xl shadow-amber-500/30 hover:scale-105 transition-all flex items-center gap-2 cursor-pointer font-readex">
                        <span>🏢 انضمام كشركة وشريك راعٍ</span>
                    </a>
                    <a href="{{ route('login') }}" class="px-7 py-4 rounded-2xl bg-white dark:bg-slate-900 text-slate-800 dark:text-white font-extrabold text-sm sm:text-base border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-all cursor-pointer font-readex">
                        تسجيل الدخول كشريك أعمال ←
                    </a>
                    <a href="{{ route('companies.index') }}" class="px-5 py-4 rounded-2xl text-slate-600 dark:text-slate-300 hover:text-amber-600 dark:hover:text-amber-400 font-bold text-xs sm:text-sm transition-all">
                        دليل الشركات والفرص ↗
                    </a>
                </div>

                <!-- 4 Floating Live Metric Badges (Identical to Homepage Metric Cards) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 max-w-5xl mx-auto pt-8 border-t border-slate-200/80 dark:border-slate-800/80 text-right">
                    
                    <!-- Metric Card 1: Partner Companies (Amber/Orange) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">الشركات الراعية والمستثمرة</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">{{ $stats['partner_companies'] }}+</h3>
                                <p class="text-[11px] font-bold text-amber-600 dark:text-amber-400 mt-1">★ قطاع أعمال معتمد</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 2: Sponsorship Volume (Indigo/Purple) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">حجم الرعاية والتمويل</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">{{ $stats['sponsorship_volume'] }}</h3>
                                <p class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 mt-1">💎 تمويل ودعم مباشر</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 3: Challenges Hosted (Emerald/Teal) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">تحديات برمجية مطروحة</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">{{ $stats['challenges_hosted'] }}+</h3>
                                <p class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 mt-1">✓ حلول أعمال حقيقية</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 4: Recruited Talents (Cyan/Blue) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">كفاءات تم توظيفها</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">{{ $stats['hired_talents'] }}+</h3>
                                <p class="text-[11px] font-bold text-cyan-600 dark:text-cyan-400 mt-1">● استقطاب مبكر للشركات</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-cyan-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- 2. Trust & Sector Partners Banner -->
    <section class="py-12 border-y border-slate-200/70 dark:border-slate-800/70 bg-white/60 dark:bg-[#080d18] relative z-10 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-black text-slate-400 uppercase tracking-widest mb-8">
                شبكة واسعة من الشركات التقنية، البنوك، والمؤسسات الاستثمارية
            </p>
            <div class="flex flex-wrap items-center justify-center gap-8 sm:gap-14 opacity-75 grayscale hover:grayscale-0 transition-all duration-300">
                <div class="flex items-center gap-2.5 font-black text-sm text-slate-700 dark:text-slate-200">
                    <span class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-950 text-amber-600 flex items-center justify-center text-xs font-black">YT</span>
                    <span>يمن تك للحلول السحابية</span>
                </div>
                <div class="flex items-center gap-2.5 font-black text-sm text-slate-700 dark:text-slate-200">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 flex items-center justify-center text-xs font-black">AB</span>
                    <span>بنك الأمل للتمويل</span>
                </div>
                <div class="flex items-center gap-2.5 font-black text-sm text-slate-700 dark:text-slate-200">
                    <span class="w-8 h-8 rounded-xl bg-indigo-100 dark:bg-indigo-950 text-indigo-600 flex items-center justify-center text-xs font-black">EP</span>
                    <span>الطاقة المتجددة EcoPower</span>
                </div>
                <div class="flex items-center gap-2.5 font-black text-sm text-slate-700 dark:text-slate-200">
                    <span class="w-8 h-8 rounded-xl bg-purple-100 dark:bg-purple-950 text-purple-600 flex items-center justify-center text-xs font-black">RA</span>
                    <span>مسرعة الرواد للأعمال</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. What You Unlock Upon Login (Cards Match Exact Home Page Card Structure) -->
    <section class="py-24 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-black px-3.5 py-1.5 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300 uppercase tracking-wider">
                    الأدوات والميزات الحصرية بعد تسجيل الدخول
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mt-4 mb-3 font-readex">
                    ماذا ستحصل عند تسجيل الدخول كشريك أعمال؟
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    توفر المنصة للشركات والمؤسسات بيئة استثمارية شفافة وأدوات متطورة لاكتشاف وتوجيه ودعم المشاريع الريادية.
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($features as $feat)
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-8 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between">
                        
                        <div>
                            <!-- 3D Header Icon -->
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white mb-6 shadow-lg shadow-amber-500/25 group-hover:scale-110 transition-transform">
                                <span class="text-2xl">🏢</span>
                            </div>

                            <span class="text-xs font-black px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                {{ $feat['badge'] }}
                            </span>

                            <h3 class="text-xl font-black text-slate-900 dark:text-white mt-3 mb-3 font-readex group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                                {{ $feat['title'] }}
                            </h3>

                            <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed mb-6">
                                {{ $feat['description'] }}
                            </p>

                            <!-- Bullet Points -->
                            <ul class="space-y-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 mb-8 border-t border-slate-100 dark:border-slate-700/60 pt-4">
                                @foreach($feat['details'] as $detail)
                                    <li class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        <span>{{ $detail }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Footer CTA Pill -->
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-xs">
                            <span class="font-black text-amber-600 dark:text-amber-400 flex items-center gap-1 group-hover:translate-x-[-3px] transition-transform">
                                <span>متاح فوراً بعد تسجيل الدخول</span>
                                <span>←</span>
                            </span>
                            <span class="text-[10px] font-bold text-slate-400">بوابة المستثمر</span>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- 4. Methodology & Roadmap Section (5 خطوات للشركات) -->
    <section class="py-20 relative z-10 border-t border-slate-200/80 dark:border-slate-800/80 bg-slate-100/50 dark:bg-[#070c16]/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-black px-3.5 py-1.5 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300 uppercase tracking-wider">
                    مسار الشراكة والرعاية المؤسسية
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mt-4 mb-3 font-readex">
                    كيف تشارك شركتك في المنظومة؟ 5 خطوات استراتيجية
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    نموذج شراكة سلس يضمن لمؤسستك استقطاب الابتكارات والكفاءات مع أعلى درجات الشفافية والحوكمة.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                @foreach($steps as $step)
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-6 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between">
                        <div>
                            <span class="text-3xl font-black text-amber-600 dark:text-amber-400 font-readex block mb-3 opacity-90">{{ $step['num'] }}</span>
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
            <div class="relative rounded-3xl bg-gradient-to-l from-amber-950/80 via-slate-900 to-slate-950 p-8 sm:p-14 text-white overflow-hidden shadow-2xl border border-slate-700/60 dark:border-slate-800">
                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-amber-500/20 blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-orange-500/15 blur-3xl pointer-events-none"></div>

                <div class="relative z-10 max-w-2xl">
                    <span class="text-xs font-black px-3.5 py-1 rounded-full bg-amber-500/20 border border-amber-400/30 text-amber-300">كن شريكاً استراتيجياً</span>
                    <h2 class="text-3xl sm:text-4xl font-black mt-4 mb-4 leading-snug font-readex">سجل شركتك اليوم وابدأ رعاية وتوجيه المبتكرين</h2>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed mb-8">
                        اربط أعمالك بأحدث المخرجات البرمجية، واطرح تحدياتك التقنية لنخبة الفرق، واستقطب الكوادر القيادية قبل غيرك.
                    </p>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('register', ['track' => 'company']) }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-amber-500 via-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-slate-950 font-black text-xs sm:text-sm shadow-xl shadow-amber-500/30 transition-all hover:scale-105 font-readex cursor-pointer">
                            تسجيل حساب شركة راعية الآن ←
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-4 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs sm:text-sm border border-white/20 transition-all cursor-pointer">
                            تسجيل الدخول كشريك
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
