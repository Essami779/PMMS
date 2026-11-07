<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-slate-800 dark:text-white font-readex leading-tight">
            {{ __('الملف الشخصي وإعدادات الحساب') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="p-6 sm:p-8 bg-white dark:bg-slate-850/90 border border-slate-200/80 dark:border-slate-800 rounded-3xl shadow-xs">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white dark:bg-slate-850/90 border border-slate-200/80 dark:border-slate-800 rounded-3xl shadow-xs">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white dark:bg-slate-850/90 border border-slate-200/80 dark:border-slate-800 rounded-3xl shadow-xs">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
