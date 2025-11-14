<?php

namespace App\Http\Controllers\LandingPages;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function index(): View
    {
        return view('landing-pages/marketing/index');
    }

    public function thanks(): View
    {
        return view('landing-pages/marketing/thank-you');
    }
}
