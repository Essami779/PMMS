<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\PasswordReset;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Implicitly grant "Super Admin" role all permissions across all gates, middleware & views
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        // Security & Authentication Audit Logging
        Event::listen(Login::class, function (Login $event) {
            if ($event->user) {
                activity('auth')
                    ->causedBy($event->user)
                    ->withProperties([
                        'ip' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ])
                    ->log("تسجيل دخول ناجح للمستخدم ({$event->user->name})");
            }
        });

        Event::listen(Logout::class, function (Logout $event) {
            if ($event->user) {
                activity('auth')
                    ->causedBy($event->user)
                    ->withProperties([
                        'ip' => request()->ip(),
                    ])
                    ->log("تسجيل خروج للمستخدم ({$event->user->name})");
            }
        });

        Event::listen(Failed::class, function (Failed $event) {
            $email = $event->credentials['email'] ?? ($event->credentials['username'] ?? 'مجهول');
            activity('auth')
                ->withProperties([
                    'attempted_email' => $email,
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ])
                ->log("محاولة تسجيل دخول فاشلة بالحساب: ({$email})");
        });

        Event::listen(Lockout::class, function (Lockout $event) {
            $email = $event->request->input('email') ?? 'مجهول';
            activity('auth')
                ->withProperties([
                    'attempted_email' => $email,
                    'ip' => request()->ip(),
                ])
                ->log("تم حظر محاولات الدخول مؤقتاً لتكرار المحاولات الخاطئة: ({$email})");
        });

        Event::listen(PasswordReset::class, function (PasswordReset $event) {
            if ($event->user) {
                activity('auth')
                    ->causedBy($event->user)
                    ->withProperties([
                        'ip' => request()->ip(),
                    ])
                    ->log("تمت إعادة تعيين كلمة المرور للمستخدم ({$event->user->name})");
            }
        });
    }
}

