<?php

namespace App\Providers;
use Vedmant\LaravelShortcodes\Shortcodes;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Shortcodes::add([
        //     'a' => AllShortcode::class,
        //     // 'b' => BShortcode::class,
        //  ]);
    }
}
