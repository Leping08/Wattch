<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::with([
            'home_page.latest_screenshot',
            'latest_ssl_response',
            'pages.assertions.latest_result'  => function ($query) {
                $query->orderBy('created_at', 'desc')
                    ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                    ->select('id', 'assertion_id', 'success', 'created_at', 'updated_at');
            }
        ])->get();

        //Calculate the percentage of successful and failing assertions foreach website
        $websites->each(function ($website) {
            $successes = 0;
            $fails = 0;
            foreach ($website->pages as $page) {
                foreach ($page->assertions as $assertion) {
                    if ($assertion->latest_result) {
                        if ($assertion->latest_result->success) {
                            $successes++;
                        } else {
                            $fails++;
                        }
                    }
                }
            }
            $website['successes'] = $successes;
            $website['fails'] = $fails;

            return $website;
        });

        return view('pages.auth.websites.index', compact('websites'));
    }

    public function show(Website $website)
    {
        $this->authorize('view', $website);

        $website->load(['pages.latest_http_response', 'pages.assertions.latest_result', 'tasks']);

        $website->pages->each(function ($page) {
            $successes = 0;
            $fails = 0;
            foreach ($page->assertions as $assertion) {
                if ($assertion->latest_result) {
                    if ($assertion->latest_result->success) {
                        $successes++;
                    } else {
                        $fails++;
                    }
                }
            }
            $page['successes'] = $successes;
            $page['fails'] = $fails;

            return $page;
        });

        return view('pages.auth.websites.show', compact('website'));
    }

    public function store(Request $request)
    {
        //Got the website regex from http://urlregex.com/
        $validator = Validator::make($request->all(), [
            'website' => [
                'required',
                'max:1000',
                'regex:%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu',
            ],
        ]);

        $duplicateSite = Website::where('domain', $request['website'])->get();

        if ($duplicateSite->count()) {
            $validator->after(function ($validator) {
                $validator->errors()->add('website', 'That website has already been added.');
            });
        }

        if ($validator->fails()) {
            return redirect(url()->previous().'#new-website')
                ->withErrors($validator)
                ->withInput();
        }

        $website = Website::create([
            'user_id' => auth()->id(),
            'domain' => $request['website'],
        ]);

        Page::create([
            'website_id' => $website->id,
            'route' => '/'
        ]);

        session()->flash('success', "{$website->domain} has been added!");

        return redirect()->route('websites.index');
    }

    public function destroy(Website $website)
    {
        $this->authorize('delete', $website);

        $website->delete();

        session()->flash('success', 'Website deleted!');
        return redirect()->route('websites.index');
    }
}
