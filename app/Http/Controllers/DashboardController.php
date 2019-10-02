<?php

namespace App\Http\Controllers;

use App\Page;
use App\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $websites = Website::all();
        $pages = Page::with('website')->has('website')->get();

        $validPageCount = 0;
        foreach ($pages as $page) {
            if ($page->passing) {
                $validPageCount++;
            }
        }


        $items = [
            [
                'title' => 'Websites',
                'total' => $websites->count(),
                'valid_count' => $websites->count(),
                'link' => '/websites',
                'image' => '/img/wattch_guy/undraw_experience_design_eq3j.svg'
            ],
            [
                'title' => 'Pages',
                'total' => $pages->count(),
                'valid_count' => $validPageCount,
                'link' => '/pages',
                'image' => '/img/icons/undraw_online_page_cq94.svg'
            ],
            [
                'title' => 'APIs',
                'total' => 10,
                'valid_count' => 10,
                'link' => '/apis',
                'image' => '/img/icons/undraw_code_review_l1q9.svg'
            ],
            [
                'title' => 'Tests',
                'total' => 5,
                'valid_count' => 3,
                'link' => '/tests',
                'image' => '/img/icons/undraw_done_a34v.svg'
            ]
        ];


        //$websites =  Website::with(['pages.latest_http_response', 'latest_ssl_response'])->get();


        return view('pages.auth.dashboard', compact('websites', 'items'));
    }
}
