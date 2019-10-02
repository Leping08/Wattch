<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class ScanPageController extends Controller
{
    public function store(Page $page)
    {
        $page->execute();
        return redirect()->back();
    }
}
