{{-- resources/views/cart.blade.php --}}
@extends('layouts.app')

@section('title','سلة التسوق')

@section('content')
  <style>
    body { background: #f9fafb; }

    /* Container */
    .cart-table-container {
      width: 90%;
      max-width: 1000px;
      margin: 2rem auto 1rem;
      background: #fff;
      padding: 1.5rem;
      border-radius: 6px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .cart-table-container h1 {
      font-size: 1.75rem;
      color: #1e40af;
      margin-bottom: 1rem;
      text-align: center;
    }

    /* Table */
    .cart-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1.5rem;
    }
    .cart-table th,
    .cart-table td {
      padding: 0.75rem;
      border: 1px solid #e5e7eb;
    }
    .cart-table th {
      background: #f3f4f6;
      color: #374151;
      text-align: left;
      font-weight: 600;
    }
    .cart-table tr:nth-child(even) {
      background: #f9fafb;
    }
    .text-center { text-align: center; }
    .text-right  { text-align: right; }

    /* Quantity input */
    .qty-input {
      width: 60px;
      padding: 0.25rem;
      border: 1px solid #d1d5db;
      border-radius: 4px;
      text-align: center;
    }

    /* Summary box */
    .cart-summary {
      width: 90%;
      max-width: 500px;
      margin: 1rem auto 2rem;
      background: #fff;
      padding: 1rem 1.5rem;
      border-radius: 6px;
      border: 1px solid #e5e7eb;
    }
    .cart-summary .row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.5rem;
      color: #374151;
      font-weight: 500;
    }
    .cart-summary .row:last-child {
      font-size: 1.125rem;
      font-weight: 700;
      margin-top: 1rem;
      border-top: 1px solid #e5e7eb;
      padding-top: 0.75rem;
    }

    /* Actions */
    .cart-actions {
      width: 90%;
      max-width: 1000px;
      margin: 0 auto 2rem;
      display: flex;
      gap: 1rem;
    }
    .btn-clear,
    .btn-checkout {
      flex: 1;
      padding: 0.75rem;
      border-radius: 6px;
      font-weight: 600;
      text-align: center;
      color: #fff;
      cursor: pointer;
      border: none;
      transition: background .3s;
      text-decoration: none;
    }
    .btn-clear {
      background: #ef4444;
    }
    .btn-clear:hover {
      background: #dc2626;
    }
    .btn-checkout {
      background: #10b981;
    }
    .btn-checkout:hover {
      background: #059669;
    }
  </style>

  <div class="cart-table-container">
    <h1>سلة التسوق</h1>

    @if ($items->isEmpty())
      <p class="text-center text-gray-500">السلة فارغة.</p>
    @else
      <div style="overflow-x:auto;">
        <table class="cart-table">
          <thead>
            <tr>
              <th>المنتج</th>
              <th class="text-center">سعر الوحدة</th>
              <th class="text-center">الكمية</th>
              <th class="text-right">الإجمالي</th>
              <th class="text-center">حذف</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($items as $item)
              <tr data-id="{{ $item['product']->id }}">
                <td>{{ $item['product']->name }}</td>
                <td class="text-center">{{ number_format($item['product']->price,2) }} ج.م</td>
                <td class="text-center">
                  <input
                    type="number"
                    class="qty-input"
                    data-id="{{ $item['product']->id }}"
                    value="{{ $item['qty'] }}"
                    min="0"
                  >
                </td>
                <td class="text-right item-total" data-id="{{ $item['product']->id }}">
                  {{ number_format($item['product']->price * $item['qty'],2) }} ج.م
                </td>
                <td class="text-center">
                  <button class="btn-clear btn-remove" data-id="{{ $item['product']->id }}">
                    حذف
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      @php
        $productCount = $items->count();
        $totalQty     = $items->sum('qty');
        $totalPrice   = $items->sum(fn($i) => $i['product']->price * $i['qty']);
      @endphp

      <div class="cart-summary">
        <div class="row"><span>عدد المنتجات:</span><span id="summary-count">{{ $productCount }}</span></div>
        <div class="row"><span>إجمالي الكمية:</span><span id="summary-qty">{{ $totalQty }}</span></div>
        <div class="row"><span>الإجمالي:</span><span id="summary-total">{{ number_format($totalPrice,2) }} ج.م</span></div>
      </div>

      <div class="cart-actions">
        <button id="clear-cart" class="btn-clear">إفراغ السلة</button>
        <a href="{{ route('checkout') }}" class="btn-checkout">المتابعة للدفع</a>
      </div>
    @endif
  </div>

  <script>
    (function() {
      // CSRF token from Blade
      const token = '{{ csrf_token() }}';

      // Quantity change
      document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', () => {
          const id  = input.dataset.id;
          const qty = parseInt(input.value) || 0;

          fetch(`/cart/update/${id}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': token,
              'Accept': 'application/json',
            },
            body: JSON.stringify({ qty }),
          })
          .then(res => res.json())
          .then(data => {
            document.querySelector(`.item-total[data-id="${id}"]`)
                    .innerText = data.itemTotal + ' ج.م';
            document.getElementById('summary-count').innerText = data.productCount;
            document.getElementById('summary-qty').innerText   = data.totalQty;
            document.getElementById('summary-total').innerText = data.grandTotalFormatted + ' ج.م';
          });
        });
      });

      // Remove item
      document.querySelectorAll('.btn-remove').forEach(btn => {
        btn.addEventListener('click', () => {
          const id = btn.dataset.id;
          fetch(`/cart/update/${id}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': token,
              'Accept': 'application/json',
            },
            body: JSON.stringify({ qty: 0 }),
          })
          .then(res => res.json())
          .then(data => {
            document.querySelector(`tr[data-id="${id}"]`).remove();
            document.getElementById('summary-count').innerText = data.productCount;
            document.getElementById('summary-qty').innerText   = data.totalQty;
            document.getElementById('summary-total').innerText = data.grandTotalFormatted + ' ج.م';
          });
        });
      });

      // Clear cart
      document.getElementById('clear-cart').addEventListener('click', () => {
        fetch(`/cart/clear`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
          },
        }).then(() => {
          // simply reload to start fresh
          location.reload();
        });
      });
    })();
  </script>
@endsection
