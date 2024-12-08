<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->active()
            ->latest()
            ->limit(8)
            ->get();

        $categories = Category::all();
        $stores = Store::all();

        return view('front.home', compact('products', 'categories', 'stores'));
    }
}
