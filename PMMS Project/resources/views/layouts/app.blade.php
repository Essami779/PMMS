<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'لوحة التحكم الذكية') }}</title>

    <!-- Google Fonts: Cairo, Readex Pro, Alyamama, Tajawal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Alyamama:wght@300..900&family=Cairo:wght@300;400;500;600;700;800;900&family=Readex+Pro:wght@300;400;500;600;700&family=Tajawal:wght@400;700;800&display=swap"
        rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <!-- Font Rules & Styling System -->
    <style>
        .app-sidebar button,
        .app-sidebar a {
            -webkit-tap-highlight-color: transparent;
        }

        .app-sidebar button:focus:not(:focus-visible),
        .app-sidebar a:focus:not(:focus-visible) {
            outline: none !important;
            box-shadow: none !important;
        }

        .app-sidebar button:focus-visible,
        .app-sidebar a:focus-visible {
            outline: 2px solid rgba(99, 102, 241, 0.35) !important;
            outline-offset: 1px !important;
        }

        body,
        table,
        th,
        td,
        input,
        select,
        textarea,
        button,
        p,
        span,
        a,
        li,
        label {
            font-family: 'Cairo', sans-serif !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .font-heading,
        .title {
            font-family: 'Cairo', sans-serif !important;
        }

        .font-readex,
        .font-readex *,
        .font-num,
        [style*="Readex Pro"] {
            font-family: 'Readex Pro', sans-serif !important;
        }

        .font-yamama,
        .font-yamama * {
            font-family: 'Al Yamama', 'Alyamama', 'Traditional Arabic', sans-serif !important;
        }

        body {
            font-size: 14px;
            line-height: 1.6;
        }

        /* شريط التمرير المخصص للسايد بار */
        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.3);
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.5);
        }

        /* شريط التمرير العام المخصص */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px !important;
            height: 6px !important;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9 !important;
            border-radius: 10px !important;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #94a3b8 !important;
            border-radius: 10px !important;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #64748b !important;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #0f172a !important;
            border-radius: 10px !important;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155 !important;
            border-radius: 10px !important;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #475569 !important;
        }

        .custom-scrollbar {
            scrollbar-width: thin !important;
            scrollbar-color: #94a3b8 #f1f5f9 !important;
        }

        .dark .custom-scrollbar {
            scrollbar-color: #334155 #0f172a !important;
        }

        /* ضبط الجداول */
        table {
            font-size: 13px !important;
        }

        table th {
            font-size: 12px !important;
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        table td,
        table tbody td {
            font-size: 13px !important;
            padding-top: 6px !important;
            padding-bottom: 6px !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
            vertical-align: middle !important;
        }

        table tbody tr {
            transition: background-color 0.15s ease;
        }

        /* تثبيت عرض الشريط الجانبي (Sidebar) */
        @media (min-width: 768px) {
            aside,
            .app-sidebar {
                width: 290px !important;
                min-width: 290px !important;
                max-width: 290px !important;
                flex: 0 0 290px !important;
                flex-shrink: 0 !important;
            }

            .app-main-workspace {
                flex: 1 1 0% !important;
                min-width: 0 !important;
                width: calc(100% - 290px) !important;
                max-width: calc(100% - 290px) !important;
                overflow-x: hidden !important;
            }
        }
    </style>

    <!-- Dark Mode Pre-render Script -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia(
            '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body
    class="font-sans antialiased bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 min-h-screen flex flex-col"
    x-data="{
        darkMode: document.documentElement.classList.contains('dark'),
        sidebarOpen: false,
        toggleTheme() {
            this.darkMode = !this.darkMode;
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
    }">

    <div class="w-full min-h-screen flex flex-col md:flex-row">

        <!-- Sidebar -->
        <aside
            class="app-sidebar w-full md:w-72 md:sticky md:top-0 md:h-screen md:overflow-y-auto sidebar-scroll bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 flex-shrink-0 shadow-xl border-l border-slate-200 dark:border-slate-800 z-30 transition-all duration-300"
            style="font-family: 'Cairo', sans-serif !important;" :class="sidebarOpen ? 'block' : 'hidden md:block'">

            <!-- Header / Logo -->
            <a href="{{ route('dashboard') }}" class="block">
                <div class="p-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 via-indigo-600 to-blue-600 flex items-center justify-center text-white shadow-md shadow-indigo-500/25 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <div class="overflow-hidden">
                            <h1 class="text-sm font-black text-slate-800 dark:text-slate-100 leading-tight truncate">
                                {{ config('app.name', 'لوحة التحكم') }}
                            </h1>
                            <p class="text-[11px] text-indigo-600 dark:text-indigo-400 font-bold">
                                نظام الإدارة والتحكم
                            </p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false"
                        class="md:hidden text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5 text-sm font-semibold">
                <!-- لوحة التحكم الرئيسية -->
                <a href="{{ route('dashboard') }}"
                    class="flex items-center space-x-3 space-x-reverse px-4 py-3 rounded-xl transition font-semibold focus:outline-none select-none {{ request()->routeIs('dashboard') ? 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                    <svg class="w-5 h-5 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>لوحة التحكم والإحصائيات</span>
                </a>

                <!-- مساحة عمل الفريق ولوحة تحكم القائد -->
                <div x-data="{ teamMenuOpen: {{ request()->routeIs('team.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button type="button" @click="teamMenuOpen = !teamMenuOpen"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition font-semibold focus:outline-none select-none {{ request()->routeIs('team.*') ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-lg shadow-indigo-600/25 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <svg class="w-5 h-5 {{ request()->routeIs('team.*') ? 'text-white' : 'text-indigo-500 dark:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>مساحة عمل فريقي</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="px-2 py-0.5 text-[10px] font-black rounded-full {{ request()->routeIs('team.*') ? 'bg-white/20 text-white' : 'bg-indigo-100 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' }}">
                                إدارة الفريق
                            </span>
                            <svg class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('team.*') ? 'text-white' : 'text-slate-400' }}"
                                :class="teamMenuOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <div x-show="teamMenuOpen" x-collapse class="pr-6 pl-2 pt-1 pb-1 space-y-1">
                        <a href="{{ route('team.workspace') }}"
                            class="flex items-center space-x-2 space-x-reverse px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('team.workspace') ? 'bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 font-black' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('team.workspace') ? 'bg-indigo-600' : 'bg-slate-400' }}"></span>
                            <span>لوحة المتابعة والكانبان</span>
                        </a>
                        <a href="{{ route('team.discussions') }}"
                            class="flex items-center space-x-2 space-x-reverse px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('team.discussions') ? 'bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 font-black' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('team.discussions') ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                            <span>غرفة العمليات والنقاشات</span>
                        </a>
                        <a href="{{ route('team.consultations') }}"
                            class="flex items-center space-x-2 space-x-reverse px-3 py-2 rounded-xl text-xs transition {{ request()->routeIs('team.consultations') ? 'bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 font-black' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('team.consultations') ? 'bg-indigo-500' : 'bg-slate-400' }}"></span>
                            <span>استشارات وخبراء المشروع</span>
                        </a>
                    </div>
                </div>

                {{-- قائمة إعدادات النظام --}}
                @canany(['users.manage', 'roles.manage', 'lookups.manage', 'backups.manage', 'audit.view', 'trash.manage'])
                    <div x-data="{ settingsOpen: {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('lookups.*') || request()->routeIs('backups.*') || request()->routeIs('audit.*') || request()->routeIs('trash.*') ? 'true' : 'false' }} }">
                        <button type="button" @click="settingsOpen = !settingsOpen"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition font-semibold focus:outline-none select-none {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('lookups.*') || request()->routeIs('backups.*') || request()->routeIs('audit.*') || request()->routeIs('trash.*') ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <svg class="w-5 h-5 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>إعدادات النظام</span>
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-300 text-slate-400"
                                :class="settingsOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="settingsOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2"
                            class="mt-1 mr-4 space-y-0.5 border-r-2 border-slate-200 dark:border-slate-700 pr-3">

                            @can('users.manage')
                                <a href="{{ route('users.index') }}"
                                    class="flex items-center space-x-2 space-x-reverse px-3 py-2.5 rounded-xl text-xs transition {{ request()->routeIs('users.*') ? 'bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white' }}">
                                    <svg class="w-4 h-4 flex-shrink-0 text-cyan-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <span>إدارة المستخدمين</span>
                                </a>
                            @endcan

                            @can('roles.manage')
                                <a href="{{ route('roles.index') }}"
                                    class="flex items-center space-x-2 space-x-reverse px-3 py-2.5 rounded-xl text-xs transition {{ request()->routeIs('roles.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white' }}">
                                    <svg class="w-4 h-4 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span>مركز الأدوار والصلاحيات</span>
                                </a>
                            @endcan

                            @can('lookups.manage')
                                <a href="{{ route('lookups.index') }}"
                                    class="flex items-center space-x-2 space-x-reverse px-3 py-2.5 rounded-xl text-xs transition {{ request()->routeIs('lookups.*') ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white' }}">
                                    <svg class="w-4 h-4 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    <span>إدارة القوائم المساعدة والترميز</span>
                                </a>
                            @endcan

                            @can('audit.view')
                                <a href="{{ route('audit.index') }}"
                                    class="flex items-center space-x-2 space-x-reverse px-3 py-2.5 rounded-xl text-xs transition {{ request()->routeIs('audit.*') ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white' }}">
                                    <svg class="w-4 h-4 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>سجل التدقيق والأمان</span>
                                </a>
                            @endcan

                            @can('backups.manage')
                                <a href="{{ route('backups.index') }}"
                                    class="flex items-center space-x-2 space-x-reverse px-3 py-2.5 rounded-xl text-xs transition {{ request()->routeIs('backups.*') ? 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white' }}">
                                    <svg class="w-4 h-4 flex-shrink-0 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                    </svg>
                                    <span>النسخ الاحتياطي</span>
                                </a>
                            @endcan

                            @canany(['trash.manage', 'users.manage'])
                                <a href="{{ route('trash.index') }}"
                                    class="flex items-center space-x-2 space-x-reverse px-3 py-2.5 rounded-xl text-xs transition {{ request()->routeIs('trash.*') ? 'bg-red-500/10 text-red-600 dark:text-red-400 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-white' }}">
                                    <svg class="w-4 h-4 flex-shrink-0 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>سلة المهملات والمحذوفات</span>
                                </a>
                            @endcanany
                        </div>
                    </div>
                @endcanany

                {{-- بوابة المنصة التفاعلية والواجهات العامة --}}
                <div class="pt-2">
                    <span class="text-[10.5px] font-bold text-slate-400 dark:text-slate-500 px-4 block mb-1">منظومة TEAM والواجهات</span>
                    <div class="space-y-1">
                        <a href="{{ route('home') }}" target="_blank"
                            class="flex items-center space-x-3 space-x-reverse px-4 py-2.5 rounded-xl transition text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800">
                            <span class="text-base">🌐</span>
                            <span>الصفحة التعريفية للمنصة</span>
                            <span class="text-[10px] text-indigo-500 mr-auto font-bold">عرض ↗</span>
                        </a>

                        <a href="{{ route('teams.index') }}"
                            class="flex items-center space-x-3 space-x-reverse px-4 py-2.5 rounded-xl transition text-xs font-semibold {{ request()->routeIs('teams.*') ? 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            <span class="text-base">🚀</span>
                            <span>دليل الفرق والمشاريع</span>
                        </a>

                        <a href="{{ route('companies.index') }}"
                            class="flex items-center space-x-3 space-x-reverse px-4 py-2.5 rounded-xl transition text-xs font-semibold {{ request()->routeIs('companies.*') ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            <span class="text-base">🏢</span>
                            <span>دليل الشركات والفرص</span>
                        </a>

                        <a href="{{ route('consultants.index') }}"
                            class="flex items-center space-x-3 space-x-reverse px-4 py-2.5 rounded-xl transition text-xs font-semibold {{ request()->routeIs('consultants.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            <span class="text-base">👨‍🏫</span>
                            <span>دليل المستشارين والخبراء</span>
                        </a>

                        <!-- شرح تفاصيل وميزات المسارات في الواجهات الأمامية -->
                        <div x-data="{ tracksMenuOpen: {{ request()->routeIs('tracks.*') ? 'true' : 'false' }} }" class="space-y-0.5 pt-1">
                            <button type="button" @click="tracksMenuOpen = !tracksMenuOpen"
                                class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl transition text-xs font-semibold {{ request()->routeIs('tracks.*') ? 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                                <div class="flex items-center space-x-3 space-x-reverse">
                                    <span class="text-base">✨</span>
                                    <span>شرح ميزات المسارات</span>
                                </div>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400" :class="tracksMenuOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="tracksMenuOpen" x-collapse class="pr-6 pl-2 pt-1 pb-1 space-y-1">
                                <a href="{{ route('tracks.teams') }}" class="flex items-center space-x-2 space-x-reverse px-3 py-1.5 rounded-lg text-[11px] {{ request()->routeIs('tracks.teams') ? 'text-indigo-600 dark:text-indigo-400 font-black bg-indigo-50/60 dark:bg-indigo-950/40' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}">
                                    <span>🚀</span>
                                    <span>ميزات مسار الفرق</span>
                                </a>
                                <a href="{{ route('tracks.companies') }}" class="flex items-center space-x-2 space-x-reverse px-3 py-1.5 rounded-lg text-[11px] {{ request()->routeIs('tracks.companies') ? 'text-amber-600 dark:text-amber-400 font-black bg-amber-50/60 dark:bg-amber-950/40' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}">
                                    <span>🏢</span>
                                    <span>ميزات مسار الشركات</span>
                                </a>
                                <a href="{{ route('tracks.consultants') }}" class="flex items-center space-x-2 space-x-reverse px-3 py-1.5 rounded-lg text-[11px] {{ request()->routeIs('tracks.consultants') ? 'text-emerald-600 dark:text-emerald-400 font-black bg-emerald-50/60 dark:bg-emerald-950/40' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white' }}">
                                    <span>👨‍🏫</span>
                                    <span>ميزات مسار المستشارين</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4 border-t border-slate-200 dark:border-slate-800">

                <!-- قسم الساعة الرقمية والتناظرية الفاخرة (3D Live Clock) -->
                <x-live-clock />

            </nav>
        </aside>

        <!-- Main Workspace -->
        <div class="app-main-workspace flex-1 flex flex-col min-w-0 w-full">

            <!-- Top Navbar (Executive Luxury Header) -->
            <header
                class="bg-white/85 dark:bg-slate-900/85 backdrop-blur-2xl border-b border-slate-200/80 dark:border-slate-800/80 h-17 sm:h-18 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30 transition-all duration-300 shadow-[0_4px_25px_-4px_rgba(0,0,0,0.03)] print:hidden">

                <!-- Right: Mobile menu + Brand Identity & System Status -->
                <div class="flex items-center gap-3.5">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="md:hidden p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="hidden sm:flex items-center gap-3">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-2">
                                <h2 class="text-sm sm:text-base font-black text-slate-900 dark:text-white font-readex tracking-tight leading-tight">
                                    {{ config('app.name', 'لوحة التحكم الذكية') }}
                                </h2>
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10.5px] font-black bg-emerald-50 dark:bg-emerald-950/70 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60 shadow-2xs">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    متصل
                                </span>
                            </div>
                            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 tracking-wide mt-0.5">
                                {{ hijri_date(now()->toDateString()) }} | {{ now()->translatedFormat('l d F Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Center: Global Search Bar -->
                <x-global-search-bar />

                <!-- Left: Actions & Controls -->
                <div class="flex items-center gap-3">

                    <!-- Dark Mode Toggle Button -->
                    <button @click="toggleTheme()"
                        class="w-11 h-11 rounded-2xl bg-white dark:bg-slate-800 hover:bg-amber-500/10 dark:hover:bg-amber-500/15 border-2 border-slate-200/90 dark:border-slate-700/80 text-amber-600 dark:text-amber-400 hover:border-amber-400 dark:hover:border-amber-500 transition-all duration-300 shadow-xs hover:shadow-md hover:scale-105 flex items-center justify-center cursor-pointer group/theme"
                        title="تبديل المظهر (فاتح / داكن)">
                        <template x-if="!darkMode">
                            <svg class="w-5 h-5 text-amber-600 transition-transform duration-300 group-hover/theme:rotate-12"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </template>
                        <template x-if="darkMode">
                            <svg class="w-5 h-5 text-amber-400 transition-transform duration-300 group-hover/theme:rotate-45"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </template>
                    </button>

                    <!-- Divider -->
                    <div class="hidden sm:block w-px h-6 bg-gradient-to-b from-transparent via-slate-300 dark:via-slate-700 to-transparent mx-0.5"></div>

                    <!-- User Profile Dropdown Menu -->
                    @auth
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen" @click.outside="userMenuOpen = false"
                            class="group flex items-center gap-3 p-1.5 pr-2 pl-3.5 rounded-2xl bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-750 border-2 border-slate-200/90 dark:border-slate-700/90 shadow-xs hover:shadow-md hover:border-indigo-400 dark:hover:border-indigo-500 transition-all duration-300 cursor-pointer">
                            <div class="relative shrink-0">
                                <img src="{{ auth()->user()->avatar_url }}"
                                    onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.svg') }}';"
                                    alt="{{ auth()->user()->name }}"
                                    class="w-9 h-9 rounded-xl object-cover shadow-xs ring-2 ring-indigo-500/50 group-hover:ring-indigo-500 transition-all duration-300 group-hover:scale-105 bg-slate-200 dark:bg-slate-700">
                                <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-slate-800"></span>
                            </div>
                            <div class="leading-tight text-right hidden sm:block">
                                <p class="text-xs font-black text-slate-800 dark:text-slate-100 font-readex group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors whitespace-nowrap">
                                    {{ auth()->user()->name }}
                                </p>
                                <div class="mt-0.5 flex items-center gap-1">
                                    @php
                                        $authUserRole = auth()->user()->getRoleNames()->first();
                                        $authRoleMeta = $authUserRole
                                            ? \App\Services\PermissionRegistry::getRoleMetadata($authUserRole)
                                            : null;
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9.5px] font-black bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 shadow-2xs">
                                        {{ $authRoleMeta['label'] ?? ($authUserRole ?? 'مستخدم') }}
                                    </span>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-500 transition-transform duration-300 mr-0.5"
                                :class="userMenuOpen ? 'rotate-180 text-indigo-500' : ''" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu Box -->
                        <div x-show="userMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                            class="absolute left-0 mt-2.5 w-72 bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl border border-slate-200/90 dark:border-slate-800/90 rounded-2xl shadow-2xl z-50 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800/80">

                            <!-- Header Profile Summary -->
                            <div class="p-4 bg-gradient-to-br from-indigo-500/10 via-indigo-500/5 to-transparent">
                                <div class="flex items-center gap-3">
                                    <img src="{{ auth()->user()->avatar_url }}"
                                        onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.svg') }}';"
                                        alt="{{ auth()->user()->name }}"
                                        class="w-12 h-12 rounded-2xl object-cover shadow-md ring-2 ring-indigo-500/40 shrink-0">
                                    <div class="overflow-hidden">
                                        <h4 class="text-sm font-black text-slate-800 dark:text-slate-100 truncate">
                                            {{ auth()->user()->name }}
                                        </h4>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate mt-0.5">
                                            {{ auth()->user()->email }}
                                        </p>
                                        <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/15 text-indigo-700 dark:text-indigo-400 border border-indigo-500/30">
                                            {{ $authRoleMeta['label'] ?? ($authUserRole ?? 'مستخدم') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="p-1.5 space-y-1">
                                <!-- Profile Settings -->
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors group">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <span>الملف الشخصي وحسابي</span>
                                        <p class="text-[10px] font-normal text-slate-400 dark:text-slate-500">تعديل البيانات والصورة وكلمة المرور</p>
                                    </div>
                                </a>

                                <!-- Dashboard -->
                                <a href="{{ route('dashboard') }}"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors group">
                                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <span>لوحة التحكم الرئيسية</span>
                                        <p class="text-[10px] font-normal text-slate-400 dark:text-slate-500">متابعة الإحصائيات والمؤشرات</p>
                                    </div>
                                </a>

                                @can('roles.manage')
                                    <a href="{{ route('roles.index') }}"
                                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <span>مركز الصلاحيات والأدوار</span>
                                            <p class="text-[10px] font-normal text-slate-400 dark:text-slate-500">إدارة الأدوار ومصفوفة الصلاحيات</p>
                                        </div>
                                    </a>
                                @endcan
                            </div>

                            <!-- Logout Footer -->
                            <div class="p-1.5">
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 bg-rose-50/80 dark:bg-rose-950/40 hover:bg-rose-600 hover:text-white dark:hover:bg-rose-600 dark:hover:text-white transition-all duration-200 group cursor-pointer shadow-xs">
                                        <div class="flex items-center gap-2.5">
                                            <svg class="w-4 h-4 text-rose-500 group-hover:text-white transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <span>تسجيل الخروج من النظام</span>
                                        </div>
                                        <svg class="w-3.5 h-3.5 opacity-60 group-hover:opacity-100 group-hover:translate-x-[-2px] transition-all"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="px-3 py-2 text-xs font-bold text-slate-700 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            تسجيل الدخول
                        </a>
                        <a href="{{ route('register') }}" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/20 transition-all">
                            إنشاء حساب
                        </a>
                    </div>
                    @endauth

                </div>
            </header>

            <!-- Alerts / Toast Messages -->
            @if (session('success'))
                <div
                    class="mx-6 mt-4 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-between text-sm font-semibold">
                    <div class="flex items-center space-x-2 space-x-reverse">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mx-6 mt-4 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 flex items-center justify-between text-sm font-semibold">
                    <div class="flex items-center space-x-2 space-x-reverse">
                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Content -->
            <main class="flex-1 p-6 overflow-y-auto overflow-x-hidden">
                {{ $slot ?? '' }}
                @yield('content')
            </main>

            <!-- Footer -->
            <footer
                class="bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 py-2.5 px-6 text-center text-xs text-slate-500 dark:text-slate-400 print:hidden flex items-center justify-between">
                <span>{{ config('app.name', 'لوحة التحكم') }} &copy; {{ date('Y') }}</span>
                <span class="text-[11px] font-mono text-slate-400">Laravel v{{ app()->version() }} (PHP v{{ PHP_VERSION }})</span>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>

</html>