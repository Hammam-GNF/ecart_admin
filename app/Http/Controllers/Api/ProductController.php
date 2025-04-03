<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function createProduct(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'requried',
        ]);

        $product = $request->user()->products()->create($request->all());

        return response()->json([
            "product" => $product
        ]);
    }
}
