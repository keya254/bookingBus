<?php

namespace App\Providers;

use App\Models\Car;
use App\Models\Setting;
use App\Models\User;
use App\Observers\CarObserver;
use App\Observers\SettingObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Car::observe(CarObserver::class);
        User::observe(UserObserver::class);
        Setting::observe(SettingObserver::class);
    }
}
