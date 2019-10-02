<?php

namespace App\Jobs;

use App\Page;
use App\Screenshot;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverDimension;
use Illuminate\Bus\Queueable;
use Illuminate\Http\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome\ChromeProcess;

class CaptureScreenshot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $page;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $process = (new ChromeProcess())->toProcess();
        $process->start();
        $options = (new ChromeOptions())->addArguments(['--disable-gpu', '--headless']);
        $capabilities = DesiredCapabilities::chrome()->setCapability(ChromeOptions::CAPABILITY, $options);
        $driver = retry(5, function () use ($capabilities) {
            return RemoteWebDriver::create('http://localhost:9515', $capabilities);
        }, 50);
        $browser = new Browser($driver);

        //Start by setting your full desired width and an arbitrary height
        $size = new WebDriverDimension(1920, 1080);
        $browser->driver->manage()->window()->setSize($size);
        $browser->visit($this->page->full_route);

        $browser->waitUntilMissing('.loading');
        $image = $browser->driver->TakeScreenshot(); //$image is now the image data in PNG format

        $uuid = (string)Str::uuid(); //Create a uuid for the name of the file

        $filename = 'screenshots/page_' . $this->page->id . '/' . $uuid . '.png'; //timestamp as a filename
        if(Storage::disk('public')->put($filename, $image)) { //save the image somewhere useful
            $path = 'storage/' . $filename; //set the src to the storage folder
            //$path = Storage::disk('local')->path($filename); //TODO get the path to work on local and in deployment
        } else {
            throw new \Exception('Could not save image');
        }

        $driver->quit();

        Screenshot::create([
            'uuid' => $uuid,
            'page_id' => $this->page->id,
            'src' => $path
        ]);
    }
}
