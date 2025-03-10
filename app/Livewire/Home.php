<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Home extends Component
{
    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->to('/login');
        }
    }
    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }
    public function render()
    {
        return view('livewire.home');
    }
}
