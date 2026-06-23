<?php

namespace App\Providers;
use App\Models\Credit;
use App\Policies\CreditPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Gate::policy(Credit::class, CreditPolicy::class);
        Paginator::useTailwind();
    }
}
