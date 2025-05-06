<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use App\Models\Guest;
use Illuminate\Support\Facades\Hash;

class Create extends Component
{
    public $open = false;
    public $username, $password, $email, $full_name;
    public $address, $phone_number, $id_card_number, $passport_number;
    public $birthdate, $gender;

    protected $rules = [
        'username' => 'required|string|unique:tbl_guest,username',
        'password' => 'required|string|min:6',
        'email' => 'required|email|unique:tbl_guest,email',
        'full_name' => 'required|string|max:255',
        'address' => 'nullable|string',
        'phone_number' => 'nullable|string|max:20',
        'id_card_number' => 'nullable|string|max:50',
        'passport_number' => 'nullable|string|max:50',
        'birthdate' => 'nullable|date',
        'gender' => 'nullable|in:L,P',
    ];

    public function store()
    {
        $this->validate();

        Guest::create([
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'email' => $this->email,
            'full_name' => $this->full_name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'id_card_number' => $this->id_card_number,
            'passport_number' => $this->passport_number,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
        ]);

        session()->flash('message', 'Guest berhasil ditambahkan.');
        $this->reset();
        $this->dispatch('refreshDatatable');
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.guest.create');
    }
}
