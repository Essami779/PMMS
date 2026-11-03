<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'منصة TEAM Hub') }}</title>

        <!-- Google Fonts: Cairo, Readex Pro -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Readex+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts and Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
        <style>
            * {
                font-family: 'Cairo', 'Readex Pro', sans-serif;
            }
            .font-readex {
                font-family: 'Readex Pro', sans-serif !important;
            }
        </style>
    </head>
    <body class="bg-slate-50 dark:bg-[#070b14] text-slate-900 dark:text-slate-100 min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden selection:bg-indigo-500 selection:text-white">

        <!-- Ambient Glow Blobs (Dashboard Sync) -->
        <div class="fixed -top-32 -right-32 w-96 h-96 rounded-full bg-indigo-500/15 blur-3xl pointer-events-none"></div>
        <div class="fixed -bottom-32 -left-32 w-96 h-96 rounded-full bg-purple-500/15 blur-3xl pointer-events-none"></div>

        <div class="w-full max-w-md relative z-10 my-8">
            <!-- Brand Logo Header -->
            <div class="text-center mb-6">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <span class="text-2xl font-black tracking-tight text-slate-900 dark:text-white font-readex">TEAM<span class="text-indigo-600 dark:text-indigo-400">.</span>HUB</span>
                        <span class="text-[11px] block font-bold text-slate-500 dark:text-slate-400">المنظومة الوطنية الموحدة</span>
                    </div>
                </a>
            </div>

            <!-- Card Container -->
            <div class="w-full bg-white dark:bg-slate-900/90 border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 rounded-3xl shadow-2xl shadow-slate-900/10 backdrop-blur-md">
                {{ $slot }}
            </div>

            <!-- Return Link -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors inline-flex items-center gap-1.5">
                    <span>← العودة لصفحة تسجيل الدخول</span>
                </a>
            </div>
        </div>
    </body>
</html>
