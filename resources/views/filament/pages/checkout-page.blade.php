<x-filament::page class="max-w-lg mx-auto space-y-6">
  <h1 class="text-3xl font-extrabold text-center">الدفع وإتمام الطلب</h1>

  <form wire:submit.prevent="placeOrder" class="space-y-4">
    <div>
      <label class="block mb-1 font-medium">الاسم</label>
      <input type="text" wire:model.defer="name" class="w-full input input-bordered"/>
    </div>
    <div>
      <label class="block mb-1 font-medium">البريد الإلكتروني</label>
      <input type="email" wire:model.defer="email" class="w-full input input-bordered"/>
    </div>
    <div>
      <label class="block mb-1 font-medium">العنوان</label>
      <textarea wire:model.defer="address" class="w-full textarea textarea-bordered"></textarea>
    </div>
    <div>
      <label class="block mb-1 font-medium">رقم الجوال</label>
      <input type="text" wire:model.defer="phone" class="w-full input input-bordered"/>
    </div>

    <button type="submit" class="btn btn-primary w-full">أكمل الطلب</button>
  </form>
</x-filament::page>
