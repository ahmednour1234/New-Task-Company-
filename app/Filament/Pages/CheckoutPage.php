<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Filament\Notifications\Notification;

class CheckoutPage extends Page
{
    protected static ?string $slug = 'checkout';
    protected static string $view = 'filament.pages.checkout-page';

    protected static ?string $navigationIcon  = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'المتجر';
    protected static ?string $navigationLabel = 'الدفع';
    protected static ?int    $navigationSort  = 3;

    public static function canAccess(): bool
    {
        return true;
    }

    public string $name    = '';
    public string $email   = '';
    public string $address = '';
    public string $phone   = '';
      public \Illuminate\Support\Collection $items;

    public function mount(): void
    {
        $cart = session('cart', []);
        $this->items = collect($cart)
            ->map(fn($qty, $id) => [
                'product' => Product::find($id),
                'qty'     => $qty,
            ])
            ->filter(fn($item) => $item['product'] !== null);
    }


     public function placeOrder()
    {
        // 1) Validate inputs
        $data = Validator::make([
            'name'    => $this->name,
            'email'   => $this->email,
            'address' => $this->address,
            'phone'   => $this->phone,
        ], [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'address' => 'required|string',
            'phone'   => 'required|string',
        ])->validate();

        // 2) Calculate total (price × qty)
        $total = $this->items
            ->sum(fn($item) => $item['product']->price * $item['qty']);

        // 3) Create order with total
        $order = Order::create(array_merge($data, [
            'total' => $total,
        ]));

        // 4) Create details
        foreach ($this->items as $item) {
            OrderDetail::create([
                'order_id'     => $order->id,
                'product_data' => $item['product']->toArray(),
                'quantity'     => $item['qty'],
                'price'        => $item['product']->price,
            ]);
        }

        // 5) Clear cart
        session()->forget('cart');

        // 6) Notify success
        Notification::make()
            ->title('تم إتمام الطلب بنجاح!')
            ->success()
            ->send();

        // 7) Redirect back to storefront
        return redirect()->back();
    }
}
