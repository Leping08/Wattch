<?php

namespace App\Http\Controllers;

use App\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::with([
            'pages.latest_http_response', 'home_page.latest_screenshot', 'latest_ssl_response',
            'pages.assertions.latest_result'
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
        $validator = Validator::make($request->all(), [
            'website' => [
                'required',
                'max:1000',
                'regex:/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/i',
            ]
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
            'domain' => $request['website']
        ]);

        session()->flash('success', "{$website->domain} has been added!");
        return redirect()->route('websites.index');
    }

    public function destroy(Website $website)
    {
        $this->authorize('delete', $website);

        $website->delete();

        //TODO Add flash message
        return redirect()->route('websites.index');
    }
}
