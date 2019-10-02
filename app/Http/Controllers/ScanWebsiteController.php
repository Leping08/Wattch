<?php

namespace App\Http\Controllers;

use App\Website;
use Illuminate\Http\Request;

class ScanWebsiteController extends Controller
{
    public function store(Website $website)
    {
        $website->execute();
        return redirect()->back();
    }
}
