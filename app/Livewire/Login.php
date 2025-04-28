<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    public ?User $user;

    #[Validate('required')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->route('dashboard');
        } else {
            session()->flash('error', 'Incorrect Email or Password.');
        }
    }
    public function render()
    {
        return view('livewire.login');
    }
}
