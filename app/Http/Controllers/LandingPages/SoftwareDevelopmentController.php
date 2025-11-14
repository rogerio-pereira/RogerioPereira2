<?php

namespace App\Http\Controllers\LandingPages;

use App\Http\Controllers\Controller;

class SoftwareDevelopmentController extends Controller
{
    public function index()
    {
        return view('landing-pages/software-development/index');
    }

    public function thanks()
    {
        return view('landing-pages/software-development/thank-you');
    }
}
