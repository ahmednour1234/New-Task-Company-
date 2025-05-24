<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Product;
use Filament\Notifications\Notification;

class StoreFrontPage extends Page
{
    // هذا هو الــ URL: /admin/store
    protected static ?string $slug = 'store';

    // ليعثر على الـ Blade
    protected static string $view = 'filament.pages.store-front-page';

    // خصائص الـ Navigation
    protected static ?string $navigationIcon  = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'المتجر';
    protected static ?string $navigationLabel = 'المتجر';
    protected static ?int    $navigationSort  = 1;

    public static function canAccess(): bool
    {
        return true;
    }

    public  $products;
    public array $cart     = [];

     public function mount(): void
    {
        // <-- NO toArray() here
        $this->products = Product::all();
        $this->cart     = session('cart', []);
    }

    protected function getViewData(): array
    {
        return [
            'products' => $this->products,
            'cart'     => $this->cart,
        ];
    }

    public function addToCart(int $id): void
    {
        $cart = session('cart', []);
        $cart[$id] = ($cart[$id] ?? 0) + 1;
        session(['cart' => $cart]);
        $this->cart = $cart;
 Notification::make()
           ->title('تم إضافة المنتج إلى السلة')
        ->success()
        ->send();    }
}
