<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Product::create([
            'name' => 'Free',
            'stripe_plan' => 'plan_FxGYWZAZDnb46I',
        ]);

        \App\Product::create([
            'name' => 'Basic',
            'stripe_plan' => 'plan_Fv1JsDdJ6hGCUS',
        ]);

        \App\Product::create([
            'name' => 'Pro',
            'stripe_plan' => 'plan_Fv1JRE0rl9ig2O',
        ]);
    }
}
