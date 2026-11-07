<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200 dark:border-indigo-800 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h2 class="text-xl font-black text-slate-800 dark:text-white font-readex">تعيين كلمة مرور جديدة</h2>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
            أدخل كلمة المرور الجديدة وتأكيدها لاستعادة الوصول إلى حسابك
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1.5">
                البريد الإلكتروني *
            </label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                class="w-full h-11 px-4 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-bold focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 outline-none transition-all" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-[11px] text-rose-500 font-bold" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1.5">
                كلمة المرور الجديدة *
            </label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••"
                class="w-full h-11 px-4 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-bold focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 outline-none transition-all" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-[11px] text-rose-500 font-bold" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1.5">
                تأكيد كلمة المرور الجديدة *
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••"
                class="w-full h-11 px-4 rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs font-bold focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 outline-none transition-all" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-[11px] text-rose-500 font-bold" />
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full h-11 rounded-xl bg-gradient-to-r from-indigo-600 via-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-black text-xs shadow-lg shadow-indigo-600/30 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2 font-readex cursor-pointer">
                <span>تحديث كلمة المرور والدخول</span>
            </button>
        </div>
    </form>
</x-guest-layout>
