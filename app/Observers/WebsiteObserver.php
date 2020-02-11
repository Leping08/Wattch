<?php

namespace App\Observers;

use App\Models\Page;
use App\Models\SslResponse;
use App\Models\Task;
use App\Models\Website;
use Illuminate\Support\Facades\Log;

class WebsiteObserver
{
    /**
     * Handle the website "created" event.
     *
     * @param Website $website
     * @return void
     */
    public function created(Website $website)
    {
        $website->execute();

        //TODO Add logic to not generate more then one home page for a website
//        Page::create([
//            'website_id' => $website->id,
//            'route' => '/'
//        ]);

        Task::create([
            'taskable_type' => Website::class,
            'taskable_id' => $website->id,
            'frequency' => 'daily',
        ]);
    }

    /**
     * Handle the website "updated" event.
     *
     * @param Website $website
     * @return void
     */
    public function updated(Website $website)
    {
        $website->execute();
    }

    /**
     * Handle the website "deleting" event.
     *
     * @param Website $website
     * @return void
     */
    public function deleting(Website $website)
    {
        Log::info('Deleting Website Id: '.$website->id);
        Log::info('Pages Count: '.$website->pages->count());

        //Delete any Pages related to the website
        foreach ($website->pages as $page) {
            $page->delete();
        }

        //Delete any Ssl_certs related to the website
        foreach ($website->ssl_certs as $cert) {
            $cert->delete();
        }

        //Delete any Tasks related to the website
        foreach ($website->tasks as $task) {
            $task->delete();
        }
    }

    /**
     * Handle the website "restored" event.
     *
     * @param Website $website
     * @return void
     */
    public function restored(Website $website)
    {
        Log::info('Restoring Website Id: '.$website->id);

        //Restore any Pages related to the website
        $pages = Page::withTrashed()
            ->where('website_id', $website->id)
            ->get();

        foreach ($pages as $page) {
            $page->restore();
        }

        //Restore any SslResponses related to the website
        $ssls = SslResponse::withTrashed()
            ->where('website_id', $website->id)
            ->get();

        foreach ($ssls as $ssl) {
            $ssl->restore();
        }

        //Restore any tasks related to the website
        $tasks = Task::withTrashed()
            ->where('taskable_type', Website::class)
            ->where('taskable_id', $website->id)
            ->get();

        foreach ($tasks as $task) {
            $task->restore();
        }
    }

    /**
     * Handle the website "force deleted" event.
     *
     * @param Website $website
     * @return void
     */
    public function forceDeleted(Website $website)
    {
        //
    }
}
