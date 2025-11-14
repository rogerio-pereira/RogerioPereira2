<?php

namespace App\Http\Controllers\LandingPages;

use App\Http\Controllers\Controller;

class AutomationController extends Controller
{
    public function index()
    {
        return view('landing-pages/automation/index');
    }

    public function thanks()
    {
        return view('landing-pages/automation/thank-you');
    }
}
