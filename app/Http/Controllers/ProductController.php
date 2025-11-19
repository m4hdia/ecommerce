<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($builder) use ($searchTerm) {
                $builder
                    ->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        $products = $query->orderBy('created_at', 'desc')->get();
        $featuredProducts = Product::where('featured', true)->take(3)->get();
        $bestSellers = Product::orderBy('price', 'desc')->take(4)->get();
        $sessionCartItems = Cart::with('product')
            ->where('session_id', session()->getId())
            ->get();

        return view('products.index', [
            'products' => $products,
            'featuredProducts' => $featuredProducts,
            'bestSellers' => $bestSellers,
            'cartPreview' => $sessionCartItems,
        ]);
    }

    public function show(Product $product)
    {
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}