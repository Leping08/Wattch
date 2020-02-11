<?php

use App\Models\NotificationChannel;
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
        NotificationChannel::create([
            'name' => 'mail',
            'config' => null,
        ]);

        NotificationChannel::create([
            'name' => 'slack',
            'config' => null,
        ]);
    }
}
