<?php

use Illuminate\Database\Seeder;

class NotificationChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\NotificationChannel::create([
            'name' => 'mail',
            'config' => null,
        ]);

        \App\NotificationChannel::create([
            'name' => 'slack',
            'config' => null,
        ]);
    }
}
