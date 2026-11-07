<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="{ 
    darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    mobileMenu: false,
    heroPersona: 'team',
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}" x-init="if (darkMode) document.documentElement.classList.add('dark');" :class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="منصة TEAM الذكية - البيئة الوطنية المتكاملة لربط فرق المشاريع الجامعية بالشركات الراعية ونخبة المستشارين الأكاديميين.">
    <title>منصة TEAM Hub | ملتقى مشاريع التخرج، الاستثمار، ونخبة الخبراء</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&family=Readex+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Cairo', 'Readex Pro', sans-serif;
            scroll-behavior: smooth;
        }

        /* 3D Floating Animation */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(0.5deg); }
        }
        @keyframes float-reverse {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(10px) rotate(-0.5deg); }
        }
        .animate-float {
            animation: float-slow 5s ease-in-out infinite;
        }
        .animate-float-reverse {
            animation: float-reverse 6s ease-in-out infinite;
        }

        /* Mesh Gradient Orbs */
        .mesh-gradient-1 {
            background: radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.22) 0%, rgba(99, 102, 241, 0) 70%);
        }
        .mesh-gradient-2 {
            background: radial-gradient(circle at 50% 50%, rgba(245, 158, 11, 0.18) 0%, rgba(245, 158, 11, 0) 70%);
        }
        .mesh-gradient-3 {
            background: radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.18) 0%, rgba(16, 185, 129, 0) 70%);
        }

        /* Glassmorphism 2.0 */
        .glass-nav {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
        }
        .dark .glass-nav {
            background: rgba(11, 17, 32, 0.82);
        }

        .glass-card-luxury {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .dark .glass-card-luxury {
            background: rgba(15, 23, 42, 0.75);
            border: 1px solid rgba(51, 65, 85, 0.6);
        }
        .glass-card-luxury:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 40px -15px rgba(99, 102, 241, 0.15);
        }
        .dark .glass-card-luxury:hover {
            box-shadow: 0 25px 40px -15px rgba(0, 0, 0, 0.5);
            border-color: rgba(99, 102, 241, 0.4);
        }
    </style>
</head>

<body class="bg-slate-50 dark:bg-[#070b14] text-slate-900 dark:text-slate-100 min-h-screen transition-colors duration-300 overflow-x-hidden selection:bg-indigo-500 selection:text-white">

    <!-- Ambient Glowing Light Backgrounds -->
    <div class="fixed top-[-150px] right-[-100px] w-[650px] h-[650px] rounded-full mesh-gradient-1 pointer-events-none z-0"></div>
    <div class="fixed top-[35%] left-[-150px] w-[700px] h-[700px] rounded-full mesh-gradient-2 pointer-events-none z-0"></div>
    <div class="fixed bottom-[-100px] right-[25%] w-[600px] h-[600px] rounded-full mesh-gradient-3 pointer-events-none z-0"></div>

    <!-- 1. Floating Pill Glass Header -->
    <div class="fixed top-4 inset-x-0 z-50 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <header class="glass-nav rounded-2xl sm:rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-lg shadow-slate-900/5 transition-all">
            <div class="h-18 px-4 sm:px-6 flex items-center justify-between">
                
                <!-- Brand Logo & Identity -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-amber-400 flex items-center justify-center text-white shadow-md shadow-indigo-500/30 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xl sm:text-2xl font-black tracking-tight text-slate-900 dark:text-white">TEAM<span class="text-indigo-600 dark:text-indigo-400">.</span>HUB</span>
                            <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800/60 hidden sm:inline-block">المنظومة الوطنية</span>
                        </div>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 font-bold hidden sm:block">ملتقى مشاريع التخرج، الاستثمار، والاستشارات</p>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 text-xs font-black text-indigo-600 dark:text-indigo-400 bg-indigo-50/80 dark:bg-indigo-950/50 rounded-xl">الرئيسية</a>
                    <a href="#tracks" class="px-3 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/50 rounded-xl transition-colors">المسارات الثلاثة</a>
                    <a href="{{ route('teams.index') }}" class="px-3 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/50 rounded-xl transition-colors">الفرق والمشاريع</a>
                    <a href="{{ route('companies.index') }}" class="px-3 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/50 rounded-xl transition-colors">دليل الشركات</a>
                    <a href="{{ route('consultants.index') }}" class="px-3 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/50 rounded-xl transition-colors">المستشارون</a>
                </nav>

                <!-- Actions & Dark Mode Toggle -->
                <div class="flex items-center gap-2.5">
                    <!-- Theme Toggle -->
                    <button @click="toggleTheme()" type="button" class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 transition-colors" title="تبديل الوضع">
                        <svg x-show="!darkMode" class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                        </svg>
                        <svg x-show="darkMode" class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>

                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-500/25 transition-all">
                            <span>لوحة التحكم</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center px-3.5 py-2 text-xs font-bold text-slate-700 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            تسجيل الدخول
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 via-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-black text-xs shadow-md shadow-indigo-600/30 transition-all hover:scale-105">
                            <span>إنشاء حساب</span>
                            <svg class="w-3.5 h-3.5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div x-show="mobileMenu" @click.away="mobileMenu = false" x-cloak class="lg:hidden px-4 pt-2 pb-5 border-t border-slate-200 dark:border-slate-800 bg-white/95 dark:bg-[#0b1120]/95 rounded-b-2xl">
                <div class="flex flex-col gap-2 pt-2">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/40 rounded-xl">الرئيسية</a>
                    <a href="#tracks" @click="mobileMenu = false" class="px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 rounded-xl hover:bg-slate-100">المسارات الثلاثة</a>
                    <a href="{{ route('teams.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 rounded-xl hover:bg-slate-100">الفرق ومشاريع التخرج</a>
                    <a href="{{ route('companies.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 rounded-xl hover:bg-slate-100">دليل الشركات</a>
                    <a href="{{ route('consultants.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 rounded-xl hover:bg-slate-100">المستشارون</a>
                </div>
            </div>
        </header>
    </div>

    <!-- 2. Hero Section with Interactive Persona Switcher -->
    <section class="relative pt-32 pb-20 md:pt-44 md:pb-32 overflow-hidden z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                
                <!-- 1. Interactive Persona Switcher Buttons in Hero -->
                <div class="inline-flex p-1.5 rounded-2xl bg-white/90 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-900/5 mb-8 backdrop-blur-xl">
                    <button type="button" @click="heroPersona = 'team'" 
                            :class="heroPersona === 'team' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'text-slate-600 dark:text-slate-300 hover:text-indigo-600'"
                            class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-black transition-all flex items-center gap-2">
                        <span>🎓</span>
                        <span>أنا طالب / فريق مشروع</span>
                    </button>

                    <button type="button" @click="heroPersona = 'company'" 
                            :class="heroPersona === 'company' ? 'bg-amber-500 text-slate-950 font-black shadow-md shadow-amber-500/30' : 'text-slate-600 dark:text-slate-300 hover:text-amber-500'"
                            class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2">
                        <span>🏢</span>
                        <span>أنا شركة / راعي أعمال</span>
                    </button>

                    <button type="button" @click="heroPersona = 'consultant'" 
                            :class="heroPersona === 'consultant' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-600 dark:text-slate-300 hover:text-emerald-600'"
                            class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2">
                        <span>👨‍🏫</span>
                        <span>أنا مستشار / خبير</span>
                    </button>
                </div>

                <!-- 2. Dynamic Headline According to Selected Persona -->
                <!-- TEAM PERSOAN -->
                <div x-show="heroPersona === 'team'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 dark:text-white leading-[1.25] tracking-tight mb-6">
                        حوّل <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-indigo-500 to-amber-500">مشروع تخرجك</span> إلى شركة ناشئة تحصد الرعاية والاستثمار
                    </h1>
                    <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed font-normal mb-10 max-w-2xl mx-auto">
                        ابنِ فريقك المتكامل، احصل على توجيه مباشر من كبار الأساتذة، واعرض ابتكارك أمام أكثر من 45 شركة ومؤسسة تبحث عن أفكار تتبناها.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4 mb-14">
                        <a href="{{ route('register', ['track' => 'team']) }}" class="px-8 py-4 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-sm sm:text-base shadow-xl shadow-indigo-600/30 hover:scale-105 transition-all flex items-center gap-2">
                            <span>🚀 تسجيل وإنشاء فريق جديد</span>
                        </a>
                        <a href="{{ route('teams.index') }}" class="px-7 py-4 rounded-2xl bg-white dark:bg-slate-900 text-slate-800 dark:text-white font-extrabold text-sm sm:text-base border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-all">
                            استكشف الفرق المتاحة ←
                        </a>
                    </div>
                </div>

                <!-- COMPANY PERSONA -->
                <div x-show="heroPersona === 'company'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 dark:text-white leading-[1.25] tracking-tight mb-6">
                        استثمر في <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 via-orange-500 to-indigo-600">أذكى العقول الجامعية</span> واكتشف حلول المستقبل لشركتك
                    </h1>
                    <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed font-normal mb-10 max-w-2xl mx-auto">
                        اربط مؤسستك بأفضل مخرجات مشاريع التخرج، قدّم تحديات أعمالك الحقيقية للفرق الطلابية، واستقطب الكفاءات الاستثنائية قبل تخرجهم.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4 mb-14">
                        <a href="{{ route('register', ['track' => 'company']) }}" class="px-8 py-4 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-sm sm:text-base shadow-xl shadow-amber-500/30 hover:scale-105 transition-all flex items-center gap-2">
                            <span>🏢 انضمام كشركة وشريك راعٍ</span>
                        </a>
                        <a href="{{ route('companies.index') }}" class="px-7 py-4 rounded-2xl bg-white dark:bg-slate-900 text-slate-800 dark:text-white font-extrabold text-sm sm:text-base border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-all">
                            دليل الشركات وفرص الرعاية ←
                        </a>
                    </div>
                </div>

                <!-- CONSULTANT PERSONA -->
                <div x-show="heroPersona === 'consultant'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 dark:text-white leading-[1.25] tracking-tight mb-6">
                        قدّم <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 via-teal-500 to-indigo-600">خبرتك الاستشارية</span> ووجّه الجيل القادم من المبتكرين
                    </h1>
                    <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed font-normal mb-10 max-w-2xl mx-auto">
                        امتلك ملفاً استشارياً مهنياً معتمداً، قدّم جلسات إرشاد متخصصة، شارك في لجان التحكيم الوطنية، وساهم في صقل المشاريع الطلابية.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4 mb-14">
                        <a href="{{ route('register', ['track' => 'consultant']) }}" class="px-8 py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-sm sm:text-base shadow-xl shadow-emerald-600/30 hover:scale-105 transition-all flex items-center gap-2">
                            <span>👨‍🏫 انضمام كمستشار معتمد</span>
                        </a>
                        <a href="{{ route('consultants.index') }}" class="px-7 py-4 rounded-2xl bg-white dark:bg-slate-900 text-slate-800 dark:text-white font-extrabold text-sm sm:text-base border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-all">
                            تصفح دليل المستشارين ←
                        </a>
                    </div>
                </div>

                <!-- 3. Floating Interactive Live Metric Badges (Harmonized with Dashboard Metric Cards) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 max-w-5xl mx-auto pt-8 border-t border-slate-200/80 dark:border-slate-800/80 text-right">
                    
                    <!-- Metric Card 1: Teams (Cyan/Blue) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">الفرق ومشاريع التخرج</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">128+</h3>
                                <p class="text-[11px] font-bold text-cyan-600 dark:text-cyan-400 mt-1">● نشط ومسجل حالياً</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-cyan-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 2: Companies (Amber/Orange) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">الشركات الراعية والمستثمرة</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">46+</h3>
                                <p class="text-[11px] font-bold text-amber-600 dark:text-amber-400 mt-1">★ قطاع أعمال معتمد</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 3: Consultants (Emerald/Teal) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">المستشارون الأكاديميون</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">82+</h3>
                                <p class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 mt-1">✓ إشراف وتحكيم متخصص</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 4: Sponsorship Volume (Indigo/Purple) -->
                    <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">فرص الرعاية والتمويل</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-slate-100 font-readex mt-1">1.2M+</h3>
                                <p class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 mt-1">💎 تمويل ودعم مباشر</p>
                            </div>
                            <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- 3. Trust & University Partners Banner -->
    <section class="py-12 border-y border-slate-200/70 dark:border-slate-800/70 bg-white/60 dark:bg-[#080d18] relative z-10 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-black text-slate-400 uppercase tracking-widest mb-8">
                شراكات أكاديمية ومؤسسية فاعلة عبر مختلف الجامعات
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

    <!-- 4. The 3 Tracks Showcase Section -->
    <section id="tracks" class="py-24 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-black px-3.5 py-1.5 rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 uppercase tracking-wider">الركائز الأساسية للمنظومة</span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mt-4 mb-3">مسارات عمل مخصصة لتمكين الابتكار</h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm">كل مسار صُمم ليوفر أدوات دقيقة تُحقق أقصى قيمة لكل طرف في المنظومة.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Track 1: Teams -->
                <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-8 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white mb-6 shadow-lg shadow-indigo-500/25 group-hover:scale-110 transition-transform">
                            <span class="text-3xl">🚀</span>
                        </div>
                        <span class="text-xs font-black px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">مسار الفرق والمشاريع التقنية</span>
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-3 mb-3 font-readex">بناء الفريق وإطلاق الابتكار</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed mb-6">
                            نظام متكامل لتكوين فرق العمل، استقطاب أصحاب المهارات الناقصة، وإدارة متطلبات المشروع حتى التسليم النهائي.
                        </p>
                        <ul class="space-y-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 mb-8">
                            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> استكمال أعضاء الفريق حسب التخصص</li>
                            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> التقديم المباشر على فرص رعاية الشركات</li>
                            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> حجز جلسات مراجعة كود ومعمارية مع الخبراء</li>
                        </ul>
                    </div>
                    <div class="space-y-2.5">
                        <a href="{{ route('tracks.teams') }}" class="w-full py-3.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs text-center shadow-md shadow-indigo-500/20 hover:scale-[1.02] transition-all block cursor-pointer">
                            استعراض تفاصيل وميزات المسار ←
                        </a>
                        <a href="{{ route('teams.index') }}" class="block text-center text-[11px] font-bold text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 py-0.5 transition">
                            أو تصفح دليل المشاريع النشطة ↗
                        </a>
                    </div>
                </div>

                <!-- Track 2: Companies -->
                <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-8 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between">
                    <div class="absolute top-4 left-4">
                        <span class="text-[10px] font-black px-2.5 py-1 rounded-full bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800">بيئة استثمار ورعاية</span>
                    </div>
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white mb-6 shadow-lg shadow-amber-500/25 group-hover:scale-110 transition-transform">
                            <span class="text-3xl">🏢</span>
                        </div>
                        <span class="text-xs font-black px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800">مسار قطاع الأعمال والشركات</span>
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-3 mb-3 font-readex">رعاية المشاريع واستقطاب النخب</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed mb-6">
                            فرصة ذهبية للشركات لتبني المشاريع الواعدة، استقطاب الكفاءات، وتقديم تحديات أعمال حقيقية للفرق لحلها.
                        </p>
                        <ul class="space-y-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 mb-8">
                            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span> دليل المشاريع المصنفة حسب قطاع العمل</li>
                            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span> استقطاب مباشر لأوائل المبتكرين والمطورين</li>
                            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span> دعم المسؤولية الاجتماعية للشركات CSR</li>
                        </ul>
                    </div>
                    <div class="space-y-2.5">
                        <a href="{{ route('tracks.companies') }}" class="w-full py-3.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs text-center shadow-md shadow-amber-500/20 hover:scale-[1.02] transition-all block cursor-pointer">
                            استعراض تفاصيل وميزات المسار ←
                        </a>
                        <a href="{{ route('companies.index') }}" class="block text-center text-[11px] font-bold text-slate-500 dark:text-slate-400 hover:text-amber-600 dark:hover:text-amber-400 py-0.5 transition">
                            أو تصفح دليل الشركات والفرص ↗
                        </a>
                    </div>
                </div>

                <!-- Track 3: Consultants -->
                <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800/90 border border-slate-200/80 dark:border-slate-700/80 p-8 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white mb-6 shadow-lg shadow-emerald-500/25 group-hover:scale-110 transition-transform">
                            <span class="text-3xl">👨‍🏫</span>
                        </div>
                        <span class="text-xs font-black px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">مسار الشخصية الاستشارية</span>
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white mt-3 mb-3 font-readex">التوجيه الأكاديمي والتحكيم</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed mb-6">
                            ملف استشاري مهني موثق للأستاذ والخبير لمتابعة المشاريع، جدولة جلسات الإشراف، والمشاركة في تحكيم الهاكاثونات.
                        </p>
                        <ul class="space-y-2.5 text-xs font-bold text-slate-700 dark:text-slate-300 mb-8">
                            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> نظام مواعيد وجلسات إرشادية ذكي</li>
                            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> تقييم ومراجعة دورية لتسليمات الفرق</li>
                            <li class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> سجل موثق لساعات الاستشارة والأثر</li>
                        </ul>
                    </div>
                    <div class="space-y-2.5">
                        <a href="{{ route('tracks.consultants') }}" class="w-full py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs text-center shadow-md shadow-emerald-500/20 hover:scale-[1.02] transition-all block cursor-pointer">
                            استعراض تفاصيل وميزات المسار ←
                        </a>
                        <a href="{{ route('consultants.index') }}" class="block text-center text-[11px] font-bold text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 py-0.5 transition">
                            أو تصفح دليل المستشارين والخبراء ↗
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Final CTA Luxury Banner -->
    <section class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-3xl bg-gradient-to-l from-indigo-950/90 via-slate-900 to-slate-950 p-8 sm:p-14 text-white overflow-hidden shadow-2xl border border-slate-700/60 dark:border-slate-800">
                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-purple-500/20 blur-3xl pointer-events-none"></div>

                <div class="relative z-10 max-w-2xl">
                    <span class="text-xs font-black px-3.5 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300">ابدأ رحلتك الآن في المنظومة</span>
                    <h2 class="text-3xl sm:text-4xl font-black mt-4 mb-4 leading-snug font-readex">مكانك محفوظ معنا في ملتقى الابتكار الوطني</h2>
                    <p class="text-slate-300 text-xs sm:text-sm leading-relaxed mb-8">
                        سواء كنت طالباً متحمساً، أو شركة تبحث عن شراكة استراتيجية، أو خبيراً يريد ترك أثر حقيقي؛ اختر مسارك وانضم إلينا اليوم.
                    </p>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-black text-xs sm:text-sm shadow-xl shadow-indigo-600/30 transition-all hover:scale-105 font-readex cursor-pointer">
                            إنشاء حساب جديد الآن ←
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-4 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs sm:text-sm border border-white/20 transition-all">
                            تسجيل دخول للمسجلين
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Footer -->
    <footer class="bg-white dark:bg-[#060a12] border-t border-slate-200 dark:border-slate-800/80 pt-16 pb-12 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-amber-400 flex items-center justify-center text-white font-black text-lg">
                            T
                        </div>
                        <span class="text-xl font-black text-slate-900 dark:text-white">TEAM<span class="text-indigo-500">.</span>HUB</span>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-4">
                        المنصة الذكية الرائدة في ربط فرق مشاريع التخرج بالشركات الراعية والمستشارين الأكاديميين.
                    </p>
                    <div class="text-[11px] text-slate-400">
                        مبني على Laravel 12 & TailwindCSS
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-black text-slate-900 dark:text-white mb-4">المسارات والأقسام</h4>
                    <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-400 font-bold">
                        <li><a href="{{ route('teams.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">الفرق ومشاريع التخرج</a></li>
                        <li><a href="{{ route('companies.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">دليل الشركات الشريكة</a></li>
                        <li><a href="{{ route('consultants.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">المستشارون والخبراء</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-black text-slate-900 dark:text-white mb-4">بوابة الوصول السريع</h4>
                    <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-400 font-bold">
                        <li><a href="{{ route('login') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">تسجيل الدخول</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">إنشاء حساب جديد</a></li>
                        <li><a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">لوحة التحكم المركزية</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-black text-slate-900 dark:text-white mb-4">جاهزية النظام</h4>
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-xs">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">المنظومة تعمل بكامل طاقتها</span>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 text-[11px]">حماية مشفرة، دعم التوقيت المزدوج الهجري والميلادي.</p>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-200 dark:border-slate-800/80 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>© {{ date('Y') }} منصة TEAM Hub. جميع الحقوق محفوظة.</p>
                <a href="#" class="hover:text-indigo-600">العودة للأعلى ↑</a>
            </div>
        </div>
    </footer>

</body>
</html>
