<?php
namespace App\Http\Controllers;

use App\Models\Product;

class StoreController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('store', compact('products'));
    }
}
