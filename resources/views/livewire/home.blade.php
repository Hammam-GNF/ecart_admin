<?php

use Livewire\Volt\Component;
use App\Models\Product;

new class extends Component
{
    public $name, $slug, $description, $price, $stock, $category_id = 1;

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->to('/login');
        }
    }

    public function addProduct()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $user = auth()->user();

        $user->products()->create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'user_id' => auth()->id(),
            'category_id' => 1,
    ]);

        session()->flash('message', 'Product added successfully!');
        return redirect('/products');
    }
}
?>

<div>
    <h1 class="text-xl font-bold mb-4">Add Product</h1>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-2 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="addProduct" class="space-y-4">
        <div>
            <label for="name" class="block font-medium">Product Name</label>
            <input type="text" wire:model="name" id="name" class="border p-2 rounded w-full" required>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="slug" class="block font-medium">Slug</label>
            <input type="text" wire:model="slug" id="slug" class="border p-2 rounded w-full" required>
            @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="description" class="block font-medium">Description</label>
            <textarea wire:model="description" id="description" class="border p-2 rounded w-full" required></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="price" class="block font-medium">Price</label>
            <input type="number" wire:model="price" id="price" step="0.01" class="border p-2 rounded w-full" required>
            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="stock" class="block font-medium">Stock</label>
            <input type="number" wire:model="stock" id="stock" class="border p-2 rounded w-full" required>
            @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Add Product
            </button>
        </div>
    </form>

    <button wire:click.prevent="logout"
        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-4 focus:outline-none focus:shadow-outline">
        Logout
    </button>
</div>
