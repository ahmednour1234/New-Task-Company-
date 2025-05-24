<x-filament::page>
  <h1 class="text-2xl font-bold mb-6">متجرنا</h1>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach ($this->products as $product)
      <div class="border rounded-lg shadow-sm p-4 flex flex-col">
        <img src="{{ asset('public/uploads/'.$product->image??'') }}" alt="{{ $product->name }}"
             class="h-40 object-cover mb-4 rounded-md">
        <h2 class="font-semibold mb-2">{{ $product->name }}</h2>
        <p class="text-lg text-primary mb-4">{{ number_format($product->price,2) }} ج.م</p>
        <button wire:click="addToCart({{ $product->id }})"
                class="mt-auto btn btn-primary">
          أضف إلى السلة
        </button>
      </div>
    @endforeach
  </div>
</x-filament::page>
