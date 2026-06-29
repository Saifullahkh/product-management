<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request, $name) {
        $plan = Plan::whereName($name)->first();

        if (! $plan) {
            abort(404);
        }

        $priceId = $plan->stripe_price_id;

        return $request->user()
            ->newSubscription('default', $priceId)
            ->allowPromotionCodes()
            ->checkout([
                'success_url' => route('welcome'),
                'cancel_url' => route('welcome'),
            ]);
    }

}
