<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - الصفحة غير موجودة | {{ config('app.name', 'منصة TEAM Hub') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Readex+Pro:wght@400;600;700;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style> 
        * { font-family: 'Cairo', 'Readex Pro', sans-serif; } 
        .font-readex { font-family: 'Readex Pro', sans-serif !important; }
    </style>
</head>
<body class="min-h-screen bg-[#070b14] text-slate-100 flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Ambient Glows -->
    <div class="fixed -top-32 -right-32 w-96 h-96 rounded-full bg-amber-500/15 blur-3xl pointer-events-none"></div>
    <div class="fixed -bottom-32 -left-32 w-96 h-96 rounded-full bg-indigo-500/15 blur-3xl pointer-events-none"></div>

    <div class="max-w-md w-full text-center space-y-6 bg-slate-900/90 backdrop-blur-md border border-slate-800 rounded-3xl p-8 shadow-2xl relative z-10">
        <div class="w-20 h-20 bg-amber-500/10 text-amber-400 rounded-3xl flex items-center justify-center mx-auto border border-amber-500/20 shadow-lg shadow-amber-500/10">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="space-y-2">
            <span class="text-xs font-black tracking-widest text-amber-400 uppercase bg-amber-500/10 px-3.5 py-1 rounded-full border border-amber-500/20">خطأ 404</span>
            <h1 class="text-2xl font-black text-white font-readex">الصفحة غير موجودة</h1>
            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                عذراً، الصفحة أو الرابط الذي تحاول الوصول إليه غير موجود أو تم نقله لمكان آخر.
            </p>
        </div>
        <div class="pt-4 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl text-xs transition-all shadow-md shadow-indigo-600/30 hover:scale-105">
                العودة للوحة التحكم
            </a>
            <button onclick="window.history.back()" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-750 text-slate-300 font-bold rounded-2xl text-xs border border-slate-700 transition-all hover:scale-105">
                الصفحة السابقة
            </button>
        </div>
    </div>
</body>
</html>
