<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        $tasks = \App\Models\TodoList::where('fecha_fin', '<=', date('Y-m-d'))->get();

        View::share('notifications', $tasks);
    }
}
