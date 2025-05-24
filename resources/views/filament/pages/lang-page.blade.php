<x-filament::page>
  <h1 class="text-2xl font-bold mb-4">اللغات</h1>
  <p>أضف أو حرر ملفات الترجمة هنا.</p>
  {{-- Example table of locales --}}
  <table class="w-full table-auto mt-6">
    <thead>
      <tr class="bg-gray-100">
        <th class="p-2">الرمز</th>
        <th class="p-2">الاسم</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($locales as $locale)
        <tr>
          <td class="p-2 font-semibold">{{ strtoupper($locale) }}</td>
          <td class="p-2">
<a href="{{ url(config('filament.path') . '/lang') }}">اللغات</a>
              تحرير {{ $locale === 'ar' ? 'العربية' : 'English' }}
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</x-filament::page>
