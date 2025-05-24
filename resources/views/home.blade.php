@extends('layouts.app')

@section('title','الرئيسية')



@section('content')
  {{-- Hero Section --}}


  {{-- Products Section --}}
  <section class="products-section">
    <div class="container">
      @php use Illuminate\Support\Str; @endphp
      @foreach ($products as $product)
        <div class="product-card">
          <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
          <div class="product-info">
            <h3>{{ $product->name }}</h3>
            <p class="price">{{ number_format($product->price,2) }} ج.م</p>
            <p class="desc">{{ Str::limit($product->description,80) }}</p>
          </div>
          <div class="product-action">
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
              @csrf
              <button type="submit" class="btn-add">أضف إلى السلة</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  </section>
@endsection
