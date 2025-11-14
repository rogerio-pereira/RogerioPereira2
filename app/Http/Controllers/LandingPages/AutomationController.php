<?php

namespace App\Http\Controllers\LandingPages;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AutomationController extends Controller
{
    public function index(): View
    {
        return view('landing-pages/automation/index');
    }

    public function thanks(): View
    {
        return view('landing-pages/automation/thank-you');
    }
}
