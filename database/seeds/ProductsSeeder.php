<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Free',
            'stripe_plan' => 'plan_FxGYWZAZDnb46I',
        ]);

        Product::create([
            'name' => 'Basic',
            'stripe_plan' => 'plan_Fv1JsDdJ6hGCUS',
        ]);

        Product::create([
            'name' => 'Pro',
            'stripe_plan' => 'plan_Fv1JRE0rl9ig2O',
        ]);
    }
}
