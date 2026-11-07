<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - خطأ في الخادم | {{ config('app.name', 'منصة TEAM Hub') }}</title>
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
    <div class="fixed -top-32 -right-32 w-96 h-96 rounded-full bg-purple-500/15 blur-3xl pointer-events-none"></div>
    <div class="fixed -bottom-32 -left-32 w-96 h-96 rounded-full bg-indigo-500/15 blur-3xl pointer-events-none"></div>

    <div class="max-w-md w-full text-center space-y-6 bg-slate-900/90 backdrop-blur-md border border-slate-800 rounded-3xl p-8 shadow-2xl relative z-10">
        <div class="w-20 h-20 bg-purple-500/10 text-purple-400 rounded-3xl flex items-center justify-center mx-auto border border-purple-500/20 shadow-lg shadow-purple-500/10">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="space-y-2">
            <span class="text-xs font-black tracking-widest text-purple-400 uppercase bg-purple-500/10 px-3.5 py-1 rounded-full border border-purple-500/20">خطأ 500</span>
            <h1 class="text-2xl font-black text-white font-readex">حدث خطأ داخلي في الخادم</h1>
            <p class="text-slate-400 text-xs sm:text-sm leading-relaxed">
                نعتذر، حدث خطأ غير متوقع أثناء معالجة طلبك. تم تسجيل المشكلة وإشعار الفريق التقني تلقائياً.
            </p>
        </div>
        <div class="pt-4 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl text-xs transition-all shadow-md shadow-indigo-600/30 hover:scale-105">
                العودة للوحة التحكم
            </a>
            <button onclick="window.location.reload()" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-750 text-slate-300 font-bold rounded-2xl text-xs border border-slate-700 transition-all hover:scale-105">
                إعادة المحاولة
            </button>
        </div>
    </div>
</body>
</html>
