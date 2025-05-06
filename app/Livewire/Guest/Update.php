<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use App\Models\Guest;

class Update extends Component
{
    public $open = false;
    public $id_guest;
    public $username, $email, $full_name;
    public $address, $phone_number, $id_card_number, $passport_number;
    public $birthdate, $gender;

    protected $listeners = ['edit' => 'loadData'];

    protected $rules = [
        'username' => 'required|string',
        'email' => 'required|email',
        'full_name' => 'required|string|max:255',
        'address' => 'nullable|string',
        'phone_number' => 'nullable|string|max:20',
        'id_card_number' => 'nullable|string|max:50',
        'passport_number' => 'nullable|string|max:50',
        'birthdate' => 'nullable|date',
        'gender' => 'nullable|in:L,P',
    ];

    public function loadData($id)
    {
        $guest = Guest::findOrFail($id);
        $this->id_guest = $guest->id_guest;
        $this->username = $guest->username;
        $this->email = $guest->email;
        $this->full_name = $guest->full_name;
        $this->address = $guest->address;
        $this->phone_number = $guest->phone_number;
        $this->id_card_number = $guest->id_card_number;
        $this->passport_number = $guest->passport_number;
        $this->birthdate = $guest->birthdate;
        $this->gender = $guest->gender;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();

        Guest::where('id_guest', $this->id_guest)->update([
            'username' => $this->username,
            'email' => $this->email,
            'full_name' => $this->full_name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'id_card_number' => $this->id_card_number,
            'passport_number' => $this->passport_number,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
        ]);

        session()->flash('message', 'Guest berhasil diperbarui.');
        $this->reset();
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.guest.update');
    }
}
