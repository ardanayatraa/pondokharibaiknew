<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Owner;
use App\Models\Guest;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        Admin::create([
            'username' => 'admin123',
            'password' => Hash::make('password'),
            'email'    => 'admin@example.com',
        ]);

        // Owner
        Owner::create([
            'username' => 'owner123',
            'password' => Hash::make('password'),
            'email'    => 'owner@example.com',
        ]);

        // Guest
        Guest::create([
            'username'        => 'guest123',
            'password'        => Hash::make('password'),
            'email'           => 'guest@example.com',
            'full_name'       => 'John Doe',
            'address'         => 'Jl. Sunset Road No.88',
            'phone_number'    => '081234567890',
            'id_card_number'  => '3275081208990001',
            'passport_number' => 'X12345678',
            'birthdate'       => '1995-08-12',
            'gender'          => 'male',
        ]);
    }
}
