<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Subscription;

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
        // 1. Jab bhi database me nai subscription insert hogi, ye block khud chalega
        Subscription::created(function ($subscription) {
            $user = $subscription->user; // Subscription se user nikalein

            if ($user) {
                // Stripe ki real price id check karein
                $priceId = $subscription->stripe_price;

                if ($priceId === 'price_1Tl0cP5TaCf50YADJPdhkbHQ') {
                    $user->assignRole('Basic User');
                } elseif ($priceId === 'price_1Tl0dp5TaCf50YADcqrJRwsG') {
                    $user->assignRole('Pro Business User'); // Ya jo bhi aapne role ka naam rakha ho
                } elseif ($priceId === 'price_1Tl0ex5TaCf50YAD6FZs8a54') {
                    $user->assignRole('Enterprise User');
                }
            }
        });

        // 2. Jab subscription cancel/delete ho jaye toh roles wapas le lein
        Subscription::deleted(function ($subscription) {
            $user = $subscription->user;
            if ($user) {
                // User se subscription wale saare roles wapas le lein
                $user->removeRole('Basic User');
                $user->removeRole('Pro Business User');
                $user->removeRole('Enterprise User');
            }
        });
    }
}
