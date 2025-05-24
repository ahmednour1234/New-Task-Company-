<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $items = collect($cart)
            ->map(fn($qty, $id) => [
                'product' => Product::find($id),
                'qty'     => $qty,
            ])
            ->filter(fn($item) => $item['product']);
        return view('cart', compact('items'));
    }

    public function add($id)
    {
        $cart = session('cart', []);
        $cart[$id] = ($cart[$id] ?? 0) + 1;
        session(['cart' => $cart]);
        return redirect()->route('cart');
    }

  public function update(Request $request, $id)
{
    $qty = (int) $request->input('qty', 0);
    $cart = session('cart', []);

    if ($qty > 0) {
        $cart[$id] = $qty;
    } else {
        unset($cart[$id]);
    }
    session(['cart' => $cart]);

    // If AJAX / JSON request, return new totals
    if ($request->wantsJson()) {
        $items = collect($cart)
            ->map(fn($q, $pid) => [
                'product' => Product::find($pid),
                'qty'     => $q,
            ])
            ->filter(fn($item) => $item['product']);

        $itemData = $items->firstWhere('product.id', $id);
        $itemTotal = $itemData
            ? $itemData['product']->price * $itemData['qty']
            : 0;

        $summary = [
            'productCount' => $items->count(),
            'totalQty'     => $items->sum('qty'),
            'grandTotal'   => $items->sum(fn($i) => $i['product']->price * $i['qty']),
        ];

        return response()->json([
            'itemTotal'            => number_format($itemTotal, 2),
            'productCount'         => $summary['productCount'],
            'totalQty'             => $summary['totalQty'],
            'grandTotalFormatted'  => number_format($summary['grandTotal'], 2),
        ]);
    }

    // Fallback for non-AJAX
    return redirect()->route('cart');
}


    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart');
    }
}
