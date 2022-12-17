<x-layout>

  <h1 class="header">Chỉnh sửa thông tin xe </h1>
  <x-form>
    @method('PUT')
    <x-slot name="action">{{ route('buses.update', $bus->IdXe) }}</x-slot>
    <x-slot name="header">Xe {{ $bus->IdXe }}</x-slot>
    <x-input-floating-label>
      <x-slot name="type">text</x-slot>
      <x-slot name="inputName">So_xe</x-slot>
      <x-slot name="value">{{ $bus->So_xe }}</x-slot>
      Số xe
    </x-input-floating-label>

    <x-input-floating-label>
      <x-slot name="type">number</x-slot>
      <x-slot name="inputName">Doi_xe</x-slot>
      <x-slot name="value">{{ $bus->Doi_xe }}</x-slot>
      Đời xe
    </x-input-floating-label>

    <div class="grid grid-cols-2 gap-8 mb-6">
      <div class="flex justify-start gap-4 items-center">
        <label for="Loai_xe">Loại xe</label>
        <select name="Loai_xe" id="Loai_xe">
          <option value="Giường nằm" {{ $bus->Loai_xe == 'Giường nằm' ? 'selected' : '' }}>Giường nằm</option>
          <option value="Ghế ngồi" {{ $bus->Loai_xe == 'Ghế ngồi' ? 'selected' : '' }}>Ghế ngồi</option>
          <option value="Limousine" {{ $bus->Loai_xe == 'Limousine' ? 'selected' : '' }}>Limousine</option>
        </select>
      </div>

      <div class="flex justify-start gap-4 items-center">
        <label for="So_Cho_Ngoi">Số ghế:</label>
        <select name="So_Cho_Ngoi" id="So_Cho_Ngoi">
          <option value="36" selected>36</option>
        </select>
      </div>
    </div>

    <x-input-floating-label>
      <x-slot name="type">text</x-slot>
      <x-slot name="inputName">IdNX</x-slot>
      <x-slot name="value">{{ $bus->IdNX }}</x-slot>
      Mã nhà xe
    </x-input-floating-label>

    <x-submit-btn>Lưu</x-submit-btn>
  </x-form>

  @if ($errors->any())
  <div class="mt-4 p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg max-w-[400px] mx-auto" role="alert">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
</x-layout>