<?php

namespace App\Providers;

use App\Models\Todo;
use App\Policies\TodoPolicy;
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

    // Add to the $policies array
protected $policies = [
    Todo::class => TodoPolicy::class,
];
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
