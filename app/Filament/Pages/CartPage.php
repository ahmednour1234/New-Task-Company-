<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Notifications\Notification;
use App\Models\Product;
use Illuminate\Support\Collection;

class CartPage extends Page
{
    // URL: /admin/cart
    protected static ?string $slug = 'cart';

    // Blade view path: resources/views/filament/pages/cart-page.blade.php
    protected static string $view = 'filament.pages.cart-page';

    // Sidebar navigation
    protected static ?string $navigationIcon  = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'المتجر';
    protected static ?string $navigationLabel = 'السلة';
    protected static ?int    $navigationSort  = 2;

    public static function canAccess(): bool
    {
        return true;
    }

    // Collection of ['product' => Product, 'qty' => int]
    public Collection $items;

    // Load cart items from session
    public function mount(): void
    {
        $cart = session('cart', []);
        $this->items = collect($cart)
            ->map(fn(int $qty, int $id): array => [
                'product' => Product::find($id),
                'qty'     => $qty,
            ])
            ->filter(fn(array $item): bool => $item['product'] !== null);
    }

    // Update a line item's quantity
    public function updateQty(int $id, int $qty): void
    {
        $cart = session('cart', []);
        if ($qty > 0) {
            $cart[$id] = $qty;
        } else {
            unset($cart[$id]);
        }
        session(['cart' => $cart]);
        $this->mount();

        Notification::make()
            ->title('تم تحديث الكمية')
            ->success()
            ->send();
    }

    // Clear the entire cart
    public function clearCart(): void
    {
        session()->forget('cart');
        $this->mount();

        Notification::make()
            ->title('تم تفريغ السلة')
            ->success()
            ->send();
    }
}
