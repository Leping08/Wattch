<?php

namespace App\Jobs;

use App\Models\Page;
use App\Models\Screenshot;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverDimension;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome\ChromeProcess;

class CaptureScreenshot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Page
     */
    protected $page;

    /**
     * Create a new job instance.
     *
     * @param Page $page
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
        if (App::runningUnitTests()) {
            Screenshot::create([
                'uuid' => (string) Str::uuid(),
                'page_id' => $this->page->id,
                'src' => '/'.(string) Str::uuid(),
            ]);
        } else {
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

            //Resize to full height for a complete screenshot
            $body = $browser->driver->findElement(WebDriverBy::tagName('body'));
            if (! empty($body)) {
                $currentSize = $body->getSize();

                //optional: scroll to bottom and back up, to trigger image lazy loading
                $browser->driver->executeScript('window.scrollTo(0, '.$currentSize->getHeight().');');
                $browser->pause(1000); //wait a sec
                $browser->driver->executeScript('window.scrollTo(0, 0);'); //scroll back to top of the page

                //set window to full height
                $size = new WebDriverDimension(1920, $currentSize->getHeight()); //make browser full height for complete screenshot
                $browser->driver->manage()->window()->setSize($size);
            }

            $browser->waitUntilMissing('.loading');
            $image = $browser->driver->TakeScreenshot(); //$image is now the image data in PNG format

            $uuid = (string) Str::uuid(); //Create a uuid for the name of the file

            $filename = 'screenshots/page_'.$this->page->id.'/'.$uuid.'.png'; //timestamp as a filename
            if (Storage::disk('public')->put($filename, $image)) { //save the image somewhere useful
                $path = 'storage/'.$filename; //set the src to the storage folder
                //$path = Storage::disk('local')->path($filename); //TODO get the path to work on local and in deployment
            } else {
                $driver->quit();
                throw new \Exception('Could not save image');
            }

            $driver->quit();

            Screenshot::create([
                'uuid' => $uuid,
                'page_id' => $this->page->id,
                'src' => $path,
            ]);
        }
    }
}
