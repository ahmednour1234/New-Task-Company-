{{-- resources/views/checkout.blade.php --}}
@extends('layouts.app')

@section('title', 'الدفع')

@section('content')
  {{-- CSS لتحسين التصميم --}}
  <style>
    /* خلفية القسم الرئيسي */
    .checkout-section {
      background: #f3f4f6;
      padding: 4rem 0;
    }
    /* البطاقة البيضاء المحيطة بالنموذج */
    .checkout-card {
      background: #ffffff;
      max-width: 500px;
      margin: 0 auto;
      border-radius: 8px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
    .checkout-card-header {
      background: #2563eb;
      color: #fff;
      text-align: center;
      padding: 1.5rem;
    }
    .checkout-card-header h1 {
      margin: 0;
      font-size: 1.75rem;
    }
    .checkout-card-body {
      padding: 2rem;
    }
    .checkout-card-body label {
      display: block;
      margin-bottom: 0.5rem;
      color: #1f2937;
      font-weight: 500;
    }
    .checkout-card-body input,
    .checkout-card-body textarea {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      margin-bottom: 1.25rem;
      font-size: 1rem;
      color: #374151;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .checkout-card-body input:focus,
    .checkout-card-body textarea:focus {
      outline: none;
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.25);
    }
    .checkout-card-footer {
      padding: 1.5rem;
      text-align: center;
      background: #fafafa;
    }
    .btn-submit {
      background: #10b981;
      color: #fff;
      padding: 0.75rem 2rem;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
    }
    .btn-submit:hover {
      background: #059669;
      transform: translateY(-2px);
    }
  </style>

  <section class="checkout-section">
    <div class="checkout-card">
      <div class="checkout-card-header">
        <h1>إتمام الطلب</h1>
      </div>
      <div class="checkout-card-body">
        <form action="{{ route('checkout.process') }}" method="POST" class="space-y-4">
          @csrf
          <div>
            <label for="name">الاسم الكامل</label>
            <input id="name" name="name" type="text" required placeholder="أدخل اسمك" />
          </div>
          <div>
            <label for="email">البريد الإلكتروني</label>
            <input id="email" name="email" type="email" required placeholder="you@example.com" />
          </div>
          <div>
            <label for="address">العنوان</label>
            <textarea id="address" name="address" required rows="3" placeholder="أدخل عنوان الشحن"></textarea>
          </div>
          <div>
            <label for="phone">رقم الجوال</label>
            <input id="phone" name="phone" type="tel" required placeholder="05xxxxxxxx" />
          </div>
          <div class="checkout-card-footer">
            <button type="submit" class="btn-submit">تأكيد الطلب</button>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection
