<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use App\Models\Varient;

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
    public function boot()
    {
        View::composer('*', function ($view) {

            $clubmemberId = 1;
            $micrositeid = 1;

            $cartItems = Cart::where('clubmember_id', $clubmemberId)
                ->where('microsite_id', $micrositeid)
                ->get();
            $multipleproductids = $cartItems->pluck('id')->implode(',');
            $total_price = $cartItems->sum('price');
            $cartItemCount = $cartItems->count();

           $varientIds = $cartItems->pluck('varient_id');
           $cartvarient = Varient::whereIn('id', $varientIds)->get();
            

            $view->with(compact('cartItems', 'total_price', 'cartItemCount','multipleproductids','cartvarient'));
        });
    }
}
