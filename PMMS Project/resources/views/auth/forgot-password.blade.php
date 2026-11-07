<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200 dark:border-indigo-800 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
        </div>
        <h2 class="text-xl font-black text-slate-800 dark:text-white font-readex">استعادة كلمة المرور</h2>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
            نسيت كلمة المرور؟ لا توجد مشكلة، أدخل بريدك الإلكتروني المسجل وسنرسل لك رابطاً آمناً لتعيين كلمة مرور جديدة.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-xs font-bold text-emerald-600 dark:text-emerald-400" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1.5">
                البريد الإلكتروني المسجل *
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                placeholder="name@example.com"
                class="w-full h-11 px-4 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-bold focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 outline-none transition-all" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-[11px] text-rose-500 font-bold" />
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full h-11 rounded-xl bg-gradient-to-r from-indigo-600 via-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-black text-xs shadow-lg shadow-indigo-600/30 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2 font-readex cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>إرسال رابط استعادة كلمة المرور</span>
            </button>
        </div>
    </form>
</x-guest-layout>
