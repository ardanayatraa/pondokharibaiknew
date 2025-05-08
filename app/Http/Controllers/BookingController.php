<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use Illuminate\Http\Request;

class BookingController extends Controller
{
     /**
     * List semua villa dengan filter opsional
     */
    public function index(Request $request)
    {
        $villa = Villa::all();
        dd($villa);
        return view('landing-page',compact('villa'));
    }
}
