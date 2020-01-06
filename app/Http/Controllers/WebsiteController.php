<?php

namespace App\Http\Controllers;

use App\HttpResponse;
use App\Website;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::with([
            'pages.latest_http_response', 'home_page.latest_screenshot', 'latest_ssl_response'
        ])->get();

        return view('pages.auth.websites.index', compact('websites'));
    }

    public function show(Website $website)
    {
        $this->authorize('view', $website);

        $website->load(['pages.latest_http_response', 'tasks']);

        return view('pages.auth.websites.show', compact('website'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'domain' => [
                'required',
                'max:1000',
                'regex:/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/i'
            ]
        ]);

        $website = Website::where('domain', $request['domain'])
            ->where('user_id', auth()->id())
            ->get();

        if (!count($website)) { //If the website is not already in the DB for that user
            $webiste = Website::create([
                'user_id' => auth()->id(),
                'domain' => $request['domain']
            ]);
            session()->flash('success', "{$webiste->domain} has been added!");
            return redirect()->route('websites.index');
        } else {
            session()->flash('warning', 'That website already exists');
            return redirect()->route('websites.index');
        }
    }

    public function edit(Website $website)
    {
        //TODO: Create edit view and hook it up
        return $website;
    }

    public function destroy(Website $website)
    {
        $this->authorize('destroy', $website);

        $website->delete();

        //TODO Add flash message
        return route('websites.index');

    }
}
