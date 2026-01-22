<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;

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
        View::composer('*', function ($view) {
        $cartItems = Cart::where('clubmember_id', 0)
        ->get();
        $cartItemCount = $cartItems->count();
        $view->with('cartItems', $cartItems)
             ->with('cartItemCount', $cartItemCount);
    });
    }
}
