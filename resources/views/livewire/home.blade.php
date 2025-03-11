<?php
use Livewire\Volt\Component;

new class extends Component
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
}
?>

<div>
    Hello
    <button wire:click.prevent="logout"
        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        Logout
    </button>
</div>

