<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Returning the dashboard function only
    public function index()
    {
        return view('dashboard');
    }
}
