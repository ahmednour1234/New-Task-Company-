<nav class="bg-white shadow">
  <div class="container mx-auto px-4 py-3 flex justify-between items-center">
    <a href="{{ route('home') }}" class="text-2xl font-bold">Novoo Medical</a>
    <ul class="flex space-x-6">
      <li><a href="{{ route('store') }}" class="hover:text-primary">المتجر</a></li>
      <li><a href="{{ route('cart') }}" class="hover:text-primary">السلة ({{ array_sum(session('cart', [])) }})</a></li>
      <li><a href="{{ route('checkout') }}" class="hover:text-primary">الدفع</a></li>
    </ul>
  </div>
</nav>
