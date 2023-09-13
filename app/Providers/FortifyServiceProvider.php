<?php

namespace App\Providers;

use App\Actions\Fortify\AuthenticateUser;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $request = request();
        if ($request->is('admin/*')) {
            Config::set('fortify.guard', 'admin');
            Config::set('fortify.passwords', 'admins');
            Config::set('fortify.prefix', 'admin');
            // Config::set('fortify.home', 'admin/dashboard');
        }

        $this->app->instance(LoginResponse::class, new class implements LoginResponse
        {
            public function toResponse($request)
            {
                if ($request->user('admin')) {
                    return redirect()->intended('admin/dashboard');
                }
                return redirect()->intended('/');
            }
        });

        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse
        {
            public function toResponse($request)
            {
                return redirect()->intended('/');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);



        RateLimiter::for('login', function ($request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function ($request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // If you have view file's with there default name you can just use this way to define them all
        if (Config::get('fortify.guard') == 'admin') {
            Fortify::authenticateUsing([new AuthenticateUser, 'authenticate']);
            Fortify::viewPrefix('auth.');
        } else {
            Fortify::viewPrefix('front.auth.');
        }

        /*   Fortify::loginView(function () {
            if (Config::get('fortify.guard' == 'web')) {
                return view('front.auth.login');
            }
            return view('auth.login');
        }); */
        /* Fortify::registerView('auth.register');
        Fortify::requestPasswordResetLinkView('auth.forgot-password');
        Fortify::resetPasswordView(function() {
            // you use closure function when you have different users for this link but not the same view
            return view('auth.reset-password');
        }); */
    }
}
