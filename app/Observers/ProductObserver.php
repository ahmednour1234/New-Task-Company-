<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductLog;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{
    public function created(Product $product): void
    {
        ProductLog::create([
            'product_id' => $product->id,
            'user_id'    => Auth::id(),
            'action'     => 'created',
            'changes'    => $product->toArray(),
        ]);
    }

    public function updated(Product $product): void
    {
        ProductLog::create([
            'product_id' => $product->id,
            'user_id'    => Auth::id(),
            'action'     => 'updated',
            'changes'    => $product->getChanges(),
        ]);
    }

    public function deleted(Product $product): void
    {
        ProductLog::create([
            'product_id' => $product->id,
            'user_id'    => Auth::id(),
            'action'     => 'deleted',
            'changes'    => $product->toArray(),
        ]);
    }
}
