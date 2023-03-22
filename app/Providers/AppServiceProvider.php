<?php

namespace App\Providers;

use App\Interfaces\ICartService;
use App\Interfaces\ILoginService;
use App\Interfaces\IProductService;
use App\Interfaces\ISignupService;
use App\Services\CartService;
use App\Services\LoginService;
use App\Services\ProductService;
use App\Services\SignupService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ISignupService::class, SignupService::class);
        $this->app->bind(ILoginService::class, LoginService::class);
        $this->app->bind(ICartService::class, CartService::class);
        $this->app->bind(IProductService::class, ProductService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
