<?php

use Livewire\Volt\Component;

new class extends Component
{
    public $name;
    public $slug;
    public $description; 
    public $price; 
    public $stock; 
    public $category_id = 1; 

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

<div class="p-4 mx-auto max-w-md">
    

    <ul id="products_list">
        <i class="fa-solid fa-spinner fa-spin"></i>
    </ul>

    @if (session()->has('message'))
        <div class="text-green-600 my-4">
            {{ session('message') }}
        </div>
    @endif

    <script>
        const ulElement = $('#products_list');
        setTimeout(() => {
            $.ajax({
                url: '{{ route("api.products.index") }}',
                type: 'GET',
                success: function(response) {
                    ulElement.empty();
                    response.forEach(product => {
                        ulElement.append(`<li>${product.name}</li>`);
                    });
                }
            });
        }, 2000);
    </script>
</div>
