<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResepsionisDashboardController extends Controller
{
    public function index()
    {
        return view('resepsionis.dashboard');
    }
} 