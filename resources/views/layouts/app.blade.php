<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'متجر Novoo')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">  <!-- ← ADD THIS LINE -->

  <!-- ربط ملف CSS العادي -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
  </head>
<body>

  {{-- Navbar --}}
  <nav>
    <div class="container navbar-container">
      <a href="{{ route('home') }}" class="navbar-brand">Novoo Medical</a>
      <ul>
        <li><a href="{{ route('store') }}">المتجر</a></li>
        <li><a href="{{ route('cart') }}">السلة</a></li>
      </ul>
    </div>
  </nav>

  {{-- المحتوى --}}
  <main class="container">
    @yield('content')
  </main>

  {{-- Footer --}}
  <footer>
    <div class="container footer-container">
      <p>© {{ date('Y') }} Novoo Medical. جميع الحقوق محفوظة.</p>
      <p>
        <a href="#">سياسة الخصوصية</a> |
        <a href="#">الشروط والأحكام</a>
      </p>
    </div>
  </footer>

</body>
</html>
