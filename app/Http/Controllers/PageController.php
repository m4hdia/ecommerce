<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::where('featured', true)->take(4)->get();
        $allProducts = Product::all();
        
        return view('home', compact('featuredProducts', 'allProducts'));
    }
}