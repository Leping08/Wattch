<?php

use Illuminate\Database\Seeder;

class AssertionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\AssertionType::create([
            'name' => 'Assert See',
            'method' => 'assertSee',
            'icon' => 'undraw_annotation_7das.svg',
            'example' => '"Text on the page"',
            'description' => 'Assert that the given string is on the page',
        ]);

        \App\Models\AssertionType::create([
            'name' => 'Assert Status',
            'method' => 'assertStatus',
            'icon' => 'undraw_server_status_5pbv.svg',
            'example' => 200,
            'description' => 'Assert a status code is returned for the page',
        ]);

        \App\Models\AssertionType::create([
            'name' => 'Assert Redirect',
            'method' => 'assertRedirect',
            'icon' => 'undraw_moving_forward_lhhd.svg',
            'example' => '"/services"',
            'description' => 'Assert that the page responds with a redirect to a given URL',
        ]);

        \App\Models\AssertionType::create([
            'name' => 'Assert Unauthorized',
            'method' => 'assertUnauthorized',
            'icon' => 'undraw_unlock_24mb.svg',
            'example' => null,
            'description' => 'Assert that the response has an unauthorized (401) status code',
        ]);

        \App\Models\AssertionType::create([
            'name' => 'Assert Don\'t See',
            'method' => 'assertDontSee',
            'icon' => 'undraw_close_tab_uk6g.svg',
            'example' => '"Dont see text on the page"',
            'description' => 'Assert that the given string is not on the page',
        ]);
    }
}
