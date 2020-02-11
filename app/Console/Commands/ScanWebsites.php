<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScanWebsites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scan:websites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan all websites';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (\App\Models\Website::all() as $website) {
            $website->execute();
        }
    }
}
