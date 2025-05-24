{{-- resources/views/store.blade.php --}}
@extends('layouts.app')

@section('title', 'متجر Novoo Medical')

@section('content')
  {{-- صفحة المتجر مع CSS مضمّن لتحسين التصميم --}}
  <style>
    /* Container رئيسي */
    .store-area {
      background: #f0f4f8;
      padding: 3rem 0;
    }
    .store-area h1 {
      text-align: center;
      margin-bottom: 2rem;
      color: #1e40af;
      font-size: 2.5rem;
      font-weight: bold;
    }

    /* Grid للمنتجات */
    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 1.5rem;
      width: 90%;
      max-width: 1200px;
      margin: 0 auto;
    }

    /* بطاقة المنتج */
    .card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: transform .3s, box-shadow .3s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    /* صورة المنتج */
    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    /* محتوى البطاقة */
    .card-body {
      padding: 1rem;
      flex: 1;
      display: flex;
      flex-direction: column;
    }
    .card-body h2 {
      font-size: 1.2rem;
      margin-bottom: .5rem;
      color: #333;
    }
    .price {
      font-size: 1.1rem;
      color: #2563eb;
      font-weight: bold;
      margin-bottom: .75rem;
    }

    /* زر الإضافة للسلة */
    .btn-add {
      background: #2563eb;
      color: #fff;
      border: none;
      padding: .5rem 1rem;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      transition: background .3s;
    }
    .btn-add:hover {
      background: #1e40af;
    }
  </style>

  <section class="store-area">
    <h1>متجر Novoo Medical</h1>

    <div class="products-grid">
      @php use Illuminate\Support\Str; @endphp
      @foreach ($products as $product)
        <div class="card">
          <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
          <div class="card-body">
            <h2>{{ $product->name }}</h2>
            <p class="price">{{ number_format($product->price,2) }} ج.م</p>
            <p class="desc">{{ Str::limit($product->description, 100) }}</p>
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
              @csrf
              <button type="submit" class="btn-add">أضف إلى السلة</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  </section>
@endsection
