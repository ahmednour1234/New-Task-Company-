<x-filament::page>
  <h1 class="text-2xl font-bold mb-6">سلة التسوق</h1>

  @if ($items->isEmpty())
    <p>السلة فارغة.</p>
  @else
    <table class="w-full table-auto mb-6">
      <thead>
        <tr class="bg-gray-100">
          <th class="p-2 text-left">المنتج</th>
          <th class="p-2">سعر الوحدة</th>
          <th class="p-2">الكمية</th>
          <th class="p-2">الإجمالي</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $item)
        <tr>
          <td class="p-2">{{ $item['product']->name }}</td>
          <td class="p-2">{{ number_format($item['product']->price,2) }}</td>
          <td class="p-2">
            <input type="number" min="0" wire:change="updateQty({{ $item['product']->id }}, $event.target.value)"
                   value="{{ $item['qty'] }}"
                   class="w-16 border rounded-md p-1 text-center">
          </td>
          <td class="p-2">{{ number_format($item['product']->price * $item['qty'],2) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="flex justify-between items-center">
      <button wire:click="clearCart()" class="btn btn-danger">إفراغ السلة</button>
      <a href="{{ route('filament.admin.pages.checkout') }}"
         class="btn btn-primary">المتابعة لمرحلة الدفع</a>
    </div>
  @endif
</x-filament::page>
