<?php

namespace App\Http\Controllers\LandingPages;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('landing-pages/home/index');
    }
}
