<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        return response()->json([
            "user" => $request->user(),
            "product" => $products
        ]);
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|numeric',
            'tags' => 'required|array'
        ]);

        $image = $request->file('image')->store('images', 'public');

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $image,
            'slug' => $request->slug,
            'user_id' => $request->user()->id,
        ]);
        
        $product->tags()->attach($request->tags);

        return response()->json($product);
    }

    public function editProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $id,
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|numeric',
            'tags' => 'required|array'
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image);
            $image = $request->file('image')->store('images', 'public');
        } else {
            $image = $product->image;
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $image,
            'slug' => $request->slug,
            'user_id' => $request->user()->id,
        ]);
        
        $product->tags()->sync($request->tags);

        return response()->json($product);
    }
}
