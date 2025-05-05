<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Register extends Component
{
    public ?User $user;

    #[Validate('required')]
    public $full_name = '';

    #[Validate('required')]
    public $username = '';

    #[Validate('required')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

    public function register()
    {
        $this->validate();

        $user = User::create([
            'full_name' => $this->full_name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->assignRole('user');

        Auth::login($user);
        return redirect()->route('login');
    }
    public function render()
    {
        return view('livewire.register');
    }
}
