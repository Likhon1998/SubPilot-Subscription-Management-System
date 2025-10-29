<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    // Home page
    public function index()
    {
        // Fetch all active products with their related items
        $products = Product::with('items')->where('status', 1)->get();

        return view('frontend.home', compact('products'));
    }

    // Product details page
    public function productDetails($id)
    {
        // Fetch the selected product with items
        $product = Product::with('items')->findOrFail($id);

        return view('frontend.product-details', compact('product'));
    }
}
