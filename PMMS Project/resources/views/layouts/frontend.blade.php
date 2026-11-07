<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="{ 
    darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    mobileMenu: false,
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'منصة TEAM Hub'))</title>

    <!-- Google Fonts: Cairo, Readex Pro -->
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
    @stack('styles')
</head>

<body class="bg-slate-50 dark:bg-[#070b14] text-slate-900 dark:text-slate-100 min-h-screen transition-colors duration-300 overflow-x-hidden selection:bg-indigo-500 selection:text-white relative">

    <!-- Ambient Glowing Light Backgrounds -->
    <div class="fixed top-[-150px] right-[-100px] w-[650px] h-[650px] rounded-full mesh-gradient-1 pointer-events-none z-0"></div>
    <div class="fixed top-[35%] left-[-150px] w-[700px] h-[700px] rounded-full mesh-gradient-2 pointer-events-none z-0"></div>
    <div class="fixed bottom-[-100px] right-[25%] w-[600px] h-[600px] rounded-full mesh-gradient-3 pointer-events-none z-0"></div>

    <!-- 1. Floating Pill Glass Header (Public Header - NO SIDEBAR) -->
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
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 font-bold hidden sm:block">ملتقى المشاريع التقنية، الاستثمار، والاستشارات</p>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 text-xs font-bold {{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50/80 dark:bg-indigo-950/50 font-black' : 'text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/50' }} rounded-xl transition-colors">الرئيسية</a>
                    
                    <!-- Tracks Dropdown -->
                    <div class="relative" x-data="{ tracksDropdown: false }">
                        <button @click="tracksDropdown = !tracksDropdown" @click.outside="tracksDropdown = false" class="px-3 py-2 text-xs font-bold {{ request()->routeIs('tracks.*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50/80 dark:bg-indigo-950/50 font-black' : 'text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/50' }} rounded-xl transition-colors flex items-center gap-1 cursor-pointer">
                            <span>المسارات والميزات</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="tracksDropdown ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="tracksDropdown" x-cloak class="absolute right-0 mt-2 w-60 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xl p-2 z-50 space-y-1">
                            <a href="{{ route('tracks.teams') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs rounded-xl {{ request()->routeIs('tracks.teams') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/80 dark:text-indigo-300 font-black' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <span class="text-sm">🚀</span>
                                <div>
                                    <span class="block font-black">مسار الفرق والمشاريع</span>
                                    <span class="block text-[10px] text-slate-400 font-normal">مساحة العمل الرشيقة والكانبان</span>
                                </div>
                            </a>
                            <a href="{{ route('tracks.companies') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs rounded-xl {{ request()->routeIs('tracks.companies') ? 'bg-amber-50 text-amber-700 dark:bg-amber-950/80 dark:text-amber-300 font-black' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <span class="text-sm">🏢</span>
                                <div>
                                    <span class="block font-black">مسار الشركات والرعاية</span>
                                    <span class="block text-[10px] text-slate-400 font-normal">رعاية المشاريع واستقطاب النخب</span>
                                </div>
                            </a>
                            <a href="{{ route('tracks.consultants') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs rounded-xl {{ request()->routeIs('tracks.consultants') ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-300 font-black' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <span class="text-sm">👨‍🏫</span>
                                <div>
                                    <span class="block font-black">مسار الخبراء والمستشارين</span>
                                    <span class="block text-[10px] text-slate-400 font-normal">التوجيه الفني والتحكيم المعتمد</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('teams.index') }}" class="px-3 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/50 rounded-xl transition-colors">الفرق والمشاريع</a>
                    <a href="{{ route('companies.index') }}" class="px-3 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/50 rounded-xl transition-colors">دليل الشركات</a>
                    <a href="{{ route('consultants.index') }}" class="px-3 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100/70 dark:hover:bg-slate-800/50 rounded-xl transition-colors">المستشارون</a>
                </nav>

                <!-- Actions & Dark Mode Toggle -->
                <div class="flex items-center gap-2.5">
                    <!-- Theme Toggle -->
                    <button @click="toggleTheme()" type="button" class="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 transition-colors cursor-pointer" title="تبديل الوضع">
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
                    <a href="{{ route('tracks.teams') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 rounded-xl hover:bg-slate-100">مسار الفرق والمشاريع</a>
                    <a href="{{ route('tracks.companies') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 rounded-xl hover:bg-slate-100">مسار الشركات والرعاية</a>
                    <a href="{{ route('tracks.consultants') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 rounded-xl hover:bg-slate-100">مسار الخبراء والمستشارين</a>
                    <a href="{{ route('teams.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 rounded-xl hover:bg-slate-100">الفرق والمشاريع</a>
                    <a href="{{ route('companies.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 rounded-xl hover:bg-slate-100">دليل الشركات</a>
                    <a href="{{ route('consultants.index') }}" class="px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 rounded-xl hover:bg-slate-100">المستشارون</a>
                </div>
            </div>
        </header>
    </div>

    <!-- Main Content Area (Spaced down from floating header, NO SIDEBAR) -->
    <main class="relative z-10">
        @yield('content')
    </main>

    <!-- Public Footer -->
    <footer class="bg-white dark:bg-[#060a12] border-t border-slate-200 dark:border-slate-800/80 pt-16 pb-12 relative z-10 mt-16">
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
                        المنصة الوطنية المتكاملة لإدارة ومتابعة الفرق والمشاريع التقنية، ربط الابتكارات بقطاع الأعمال، وتوجيه النخب.
                    </p>
                    <div class="text-[11px] text-slate-400 font-bold">
                        منظومة TEAM Hub © {{ date('Y') }} — جميع الحقوق محفوظة
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-black text-slate-900 dark:text-white mb-4">مسارات العمل التخصصية</h4>
                    <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-400 font-bold">
                        <li><a href="{{ route('tracks.teams') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">مسار الفرق والمشاريع</a></li>
                        <li><a href="{{ route('tracks.companies') }}" class="hover:text-amber-600 dark:hover:text-amber-400">مسار قطاع الأعمال والشركات</a></li>
                        <li><a href="{{ route('tracks.consultants') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">مسار الخبراء والمستشارين</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-black text-slate-900 dark:text-white mb-4">الأدلة العامة</h4>
                    <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-400 font-bold">
                        <li><a href="{{ route('teams.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">دليل المشاريع العامة</a></li>
                        <li><a href="{{ route('companies.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400">دليل الشركات الشريكة</a></li>
                        <li><a href="{{ route('consultants.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">دليل المستشارين والخبراء</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-black text-slate-900 dark:text-white mb-4">بوابة الوصول السريع</h4>
                    <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-400 font-bold">
                        <li><a href="{{ route('login') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">تسجيل الدخول</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">إنشاء حساب جديد</a></li>
                        <li><a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">لوحة التحكم (للمسجلين)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>

