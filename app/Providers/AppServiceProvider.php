<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('partials.header', function ($view) {
            $user = Auth::user();
            $logo = Setting::all();
            $foto = User::where('id', $user->id)->get();

            $view->with([
                'logo' => $logo,
                'foto' => $foto,
            ]);
        });
    }
}
