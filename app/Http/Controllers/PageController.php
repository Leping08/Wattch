<?php

namespace App\Http\Controllers;

use App\Page;
use App\Website;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

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
            'assertions.latest_result',
            'assertions.type',
            'http_responses' => function ($query) {
                $query->orderBy('created_at', 'desc')
                    ->take(50);
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

        $website = Website::findOrFail($website_id);

        $this->authorize('view', $website);

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

    public function destroy(Page $page)
    {
        $this->authorize('delete', $page);

        $website = $page->website;

        $page->delete();

        return redirect()->route('websites.show', ['website' => $website]);
    }
}
