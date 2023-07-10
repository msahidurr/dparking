<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (!app()->runningInConsole() && file_exists(storage_path('installed'))) {

            $settings = cache()->remember('settings', Carbon::now()->addHours(2), function () {
                return Setting::first();
            });

            View::share('settings', $settings);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
