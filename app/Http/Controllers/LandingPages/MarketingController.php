<?php

namespace App\Http\Controllers\LandingPages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function index()
    {
        return view('landing-pages/marketing/index');
    }

    public function thanks()
    {
        return view('landing-pages/marketing/thank-you');
    }
}
