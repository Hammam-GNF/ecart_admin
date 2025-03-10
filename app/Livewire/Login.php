<?php

namespace App\Livewire;

use Livewire\Component;

class Login extends Component
{
    public $email, $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect('/');
        }
        
        $this->addError('email', 'The provided credentials do not match our records.');
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.login');
    }
}
