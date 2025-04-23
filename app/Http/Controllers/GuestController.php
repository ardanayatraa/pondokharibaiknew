<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GuestController extends Controller
{
    public function store(Request $request)
    {
        $guest = Guest::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'id_card_number' => $request->id_card_number,
            'passport_number' => $request->passport_number,
        ]);

        return redirect()->route('login')->with('success', 'Account successfully created!');
    }
}