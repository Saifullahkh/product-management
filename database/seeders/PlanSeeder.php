<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;
use Spatie\Permission\Models\Permission;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Pehle saari required Spatie permissions create/find karein
        $viewProducts = Permission::findOrCreate('view-products');
        $createProducts = Permission::findOrCreate('create-products');
        $manageCategories = Permission::findOrCreate('manage-categories');
        $unlimitedProducts = Permission::findOrCreate('unlimited-products');

        // 2. Aapke plans ka array structure
        $plans = [
            [
                "name" => 'Basic', 
                'stripe_plan_id' => 'prod_UkVdGIAImqq6B6', 
                'stripe_price_id' => 'price_1Tl0cP5TaCf50YADJPdhkbHQ'
            ],
            [
                "name" => 'Pro Business', 
                'stripe_plan_id' => 'prod_UkVf4A0jJSsDZS', 
                'stripe_price_id' => 'price_1Tl0dp5TaCf50YADcqrJRwsG'
            ],
            [
                "name" => 'Enterprise', 
                'stripe_plan_id' => 'prod_UkVggAwBY4QpeB', 
                'stripe_price_id' => 'price_1Tl0ex5TaCf50YAD6FZs8a54'
            ]
        ];

        foreach ($plans as $planData) {
            // Plan ko create ya update karein taake duplicate error na aaye
            $plan = Plan::updateOrCreate(
                ['stripe_price_id' => $planData['stripe_price_id']],
                [
                    'name' => $planData['name'],
                    'stripe_plan_id' => $planData['stripe_plan_id']
                ]
            );

            // 3. Plan ke mutabiq conditional permissions mapping logic
            if ($plan->name === 'Basic') {
                // Basic mein product aur category dono block rakhne hain, toh koi permission attach nahi hogi
                $plan->permissions()->sync([]);
            } 
            elseif ($plan->name === 'Pro Business') {
                // Pro mein category dikhegi, aur limited products (max 5) ke liye views handle honge
                $plan->permissions()->sync([
                    $manageCategories->id,
                    $viewProducts->id,
                    $createProducts->id
                ]);
            } 
            elseif ($plan->name === 'Enterprise') {
                // Enterprise mein sab kuch access hoga (unlimited tokens ke sath)
                $plan->permissions()->sync([
                    $manageCategories->id,
                    $viewProducts->id,
                    $createProducts->id,
                    $unlimitedProducts->id
                ]);
            }
        }
    }
}
