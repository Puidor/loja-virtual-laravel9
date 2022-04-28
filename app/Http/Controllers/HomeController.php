<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('name', 'like', '%'. $request->search . '%' )->get();
        return view('home', ['products' => $products]);
    }
}
