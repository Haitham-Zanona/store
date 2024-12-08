<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->active()
            ->paginate(12);

        $categories = Category::paginate(5);

        return view('front.product.index', compact('products', 'categories'));
    }
    public function show(Product $product)
    {

        if ($product->status != 'active') {
            abort(404);
        }
        return view('front.product.show', compact('product'));
    }
}
