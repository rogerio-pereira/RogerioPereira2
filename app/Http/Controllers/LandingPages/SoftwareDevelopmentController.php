<?php

namespace App\Http\Controllers\LandingPages;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SoftwareDevelopmentController extends Controller
{
    public function index(): View
    {
        return view('landing-pages/software-development/index');
    }

    public function thanks(): View
    {
        return view('landing-pages/software-development/thank-you');
    }
}
