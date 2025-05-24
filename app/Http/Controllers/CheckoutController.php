<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

class CheckoutController extends Controller
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
        return view('checkout', compact('items'));
    }
public function process(Request $request)
{
    $data = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email',
        'address' => 'required|string',
        'phone'   => 'required|string',
    ]);

    // حساب الإجمالي
    $total = collect(session('cart', []))
        ->map(fn($qty, $id) => Product::find($id)->price * $qty)
        ->sum();

    // إنشاء الأمر
    $order = Order::create($data + ['total' => $total]);

    // حفظ تفاصيل كل منتج
    foreach (session('cart', []) as $id => $qty) {
        $product = Product::find($id);
        OrderDetail::create([
            'order_id'     => $order->id,
            'product_data' => $product->toArray(),
            'quantity'     => $qty,
            'price'        => $product->price,
        ]);
    }

    // تفريغ السلة
    session()->forget('cart');

    // حمّل العلاقة بالتفاصيل في النموذج
    $order->load('details');

    // عِد إلى صفحة النجاح مع تمرير النموذج
    return view('checkout-success', [
        'order' => $order,
    ]);
}

}
