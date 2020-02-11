<?php

namespace App\Console\Commands;

use App\Page;
use Illuminate\Console\Command;

class ScanPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scan:pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan all pages';

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
        foreach (Page::all() as $page) {
            $page->execute();
        }
    }
}
