<?php

namespace App\Http\Controllers;

use App\Jobs\CaptureScreenshot;
use App\Library\Classes\Screenshot;
use App\Library\Classes\Wattch;
use App\Page;
use App\Website;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverDimension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome\ChromeProcess;

class PageController extends Controller
{
    public function index()
    {
        return Page::with('website')->has('website')->get();
    }

    public function show(Page $page)
    {
        $this->authorize('view', $page);

        $page = $page->load([
            'website',
            'screenshots',
            'http_responses' => function ($query) {
                $query->orderBy('created_at', 'desc')
                    ->take(25);
            }
        ]);

        $page['routes'] = $page::where('website_id', $page->website->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('pages.auth.pages.show', compact('page'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'website_id' => ['required', 'numeric'],
            'route' => ['required', 'string']
        ]);

        $website_id = $request['website_id'];
        $route = $request['route'];

        $page = Page::where('website_id', $website_id)
            ->where('route', $route)
            ->get();

        if (!count($page)) {
            $page = Page::create([
                'route' => $route,
                'website_id' => $website_id
            ]);

            session()->flash('success', "{$page->domain} has been added!");
            return redirect()->route('websites.show', ['website' => $website_id]);
        } else {
            session()->flash('warning', 'That page already exists');
            return redirect()->route('websites.show', ['website' => $website_id]);
        }
    }
}
