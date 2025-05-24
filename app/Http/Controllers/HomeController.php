<?php
namespace App\Http\Controllers;
use Filament\Pages\Page;
use Illuminate\Http\Request;
USE App\Models\Product;
class HomeController extends Controller
{
    public function __invoke()
    {
                $products = Product::all();

        return view('home', [
            'products' => $products,
        ]);
    }
}
