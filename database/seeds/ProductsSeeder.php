<?php

use App\Models\Product;
use App\Models\Plan;
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
        //Babysitter
        $baby = Product::create([
            'name' => 'Babysitter',
            'stripe_product' => 'prod_FxGYIy0Xr5j5Pi',
        ]);
        Plan::create([
            'stripe_plan' => 'plan_H7XH71U0EF9GCW',
            'product_id' => $baby->id,
            'time_frame' => 'monthly',
            'price' => 999
        ]);
        Plan::create([
            'stripe_plan' => 'plan_H7XFPYUbklu2li',
            'product_id' => $baby->id,
            'time_frame' => 'yearly',
            'price' => 9999
        ]);

        //Security Guard
        $security = Product::create([
            'name' => 'Security Guard',
            'stripe_product' => 'prod_Fv1JP50OyzSt7Z',
        ]);
        Plan::create([
            'stripe_plan' => 'plan_H7XQkDpb1aCesd',
            'product_id' => $security->id,
            'time_frame' => 'monthly',
            'price' => 2999
        ]);
        Plan::create([
            'stripe_plan' => 'plan_H7YLuXnaWB26pZ',
            'product_id' => $security->id,
            'time_frame' => 'yearly',
            'price' => 29999
        ]);

        //Private Investigator
        $pi = Product::create([
            'name' => 'Private Investigator',
            'stripe_product' => 'prod_Fv1J8aRpNDvdBE',
        ]);
        Plan::create([
            'stripe_plan' => 'plan_H7XSPumINDTnaF',
            'product_id' => $pi->id,
            'time_frame' => 'monthly',
            'price' => 9999
        ]);
        Plan::create([
            'stripe_plan' => 'plan_H7XS3DOB63CoIi',
            'product_id' => $pi->id,
            'time_frame' => 'yearly',
            'price' => 99999
        ]);
    }
}
