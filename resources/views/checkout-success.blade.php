{{-- resources/views/checkout-success.blade.php --}}
@extends('layouts.app')

@section('title','تمت عملية الشراء')

@section('content')
  <style>
    /* الصفحة الخلفية */
    .success-section {
      background: #f0fdf4;
      padding: 4rem 1rem;
    }

    /* البطاقة الرئيسية */
    .success-card {
      max-width: 800px;
      margin: 0 auto;
      background: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      font-family: Arial, sans-serif;
    }

    /* الرأس الأخضر */
    .success-header {
      background: #16a34a;
      color: #fff;
      text-align: center;
      padding: 2rem 1rem;
    }
    .success-header h1 {
      margin: 0;
      font-size: 2rem;
    }
    .success-header p {
      margin-top: 0.5rem;
      font-size: 1rem;
      opacity: 0.9;
    }

    /* المحتوى الداخلي */
    .success-body {
      padding: 2rem 1.5rem;
      color: #1f2937;
    }
    .success-body h2 {
      font-size: 1.25rem;
      margin-bottom: 0.75rem;
      border-bottom: 2px solid #e5e7eb;
      padding-bottom: 0.25rem;
    }
    .customer-info ul {
      list-style: none;
      padding: 0;
      margin: 0 0 1.5rem;
    }
    .customer-info li {
      margin-bottom: 0.5rem;
      display: flex;
      justify-content: space-between;
      font-weight: 500;
    }

    /* جدول المنتجات */
    .order-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1.5rem;
    }
    .order-table th,
    .order-table td {
      padding: 0.75rem 1rem;
      border: 1px solid #e5e7eb;
    }
    .order-table th {
      background: #f9fafb;
      text-align: left;
      font-weight: 600;
    }
    .order-table tr:nth-child(even) {
      background: #f3f4f6;
    }
    .order-table td.text-center { text-align: center; }
    .order-table td.text-right  { text-align: right; }

    /* الملخص */
    .order-summary {
      background: #f9fafb;
      padding: 1rem 1.5rem;
      display: flex;
      justify-content: space-between;
      font-weight: 600;
      border-top: 1px solid #e5e7eb;
    }
    .order-summary span { font-size: 1rem; }
    .order-summary .total-label { color: #374151; }
    .order-summary .total-value { font-size: 1.25rem; color: #111827; }

    /* زر العودة للصفحة الرئيسية */
    .back-home {
      display: inline-block;
      margin: 1.5rem auto;
      padding: 0.75rem 2rem;
      background: #2563eb;
      color: #fff;
      border-radius: 6px;
      text-decoration: none;
      transition: background 0.3s, transform 0.2s;
    }
    .back-home:hover {
      background: #1e40af;
      transform: translateY(-2px);
    }
  </style>

  <section class="success-section">
    <div class="success-card">
      {{-- Header --}}
      <div class="success-header">
        <h1>✔️ تم إتمام الطلب بنجاح!</h1>
        <p>رقم الطلب: <strong>#{{ $order->id }}</strong></p>
      </div>

      {{-- Body --}}
      <div class="success-body">
        {{-- بيانات العميل --}}
        <h2>بيانات العميل</h2>
        <div class="customer-info">
          <ul>
            <li><span>الاسم:</span><span>{{ $order->name }}</span></li>
            <li><span>البريد:</span><span>{{ $order->email }}</span></li>
            <li><span>العنوان:</span><span>{{ $order->address }}</span></li>
            <li><span>الجوال:</span><span>{{ $order->phone }}</span></li>
          </ul>
        </div>

        {{-- جدول الطلب --}}
        <h2>تفاصيل المنتجات</h2>
        <div style="overflow-x:auto;">
          <table class="order-table">
            <thead>
              <tr>
                <th>المنتج</th>
                <th class="text-center">الكمية</th>
                <th class="text-right">سعر الوحدة</th>
                <th class="text-right">إجمالي المنتج</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($order->details as $detail)
                @php $p = $detail->product_data; @endphp
                <tr>
                  <td>{{ $p['name'] }}</td>
                  <td class="text-center">{{ $detail->quantity }}</td>
                  <td class="text-right">{{ number_format($detail->price,2) }} ج.م</td>
                  <td class="text-right">
                    {{ number_format($detail->price * $detail->quantity,2) }} ج.م
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        {{-- الملخص --}}
        <div class="order-summary">
          <span class="total-label">الإجمالي الكلي:</span>
          <span class="total-value">{{ number_format($order->total,2) }} ج.م</span>
        </div>

        {{-- زر العودة --}}
        <div style="text-align:center;">
          <a href="{{ route('home') }}" class="back-home">العودة للصفحة الرئيسية</a>
        </div>
      </div>
    </div>
  </section>
@endsection
