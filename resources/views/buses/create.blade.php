<x-layout>

  <h1 class="header">Thêm xe</h1>
  <x-form>
    <x-slot name="action">{{ route('buses.store') }}</x-slot>

    <x-slot name="header">Thêm xe</x-slot>

    <x-input-floating-label>
      <x-slot name="type">text</x-slot>
      <x-slot name="inputName">So_xe</x-slot>
      <x-slot name="value">{{ old('So_xe') }}</x-slot>
      Số xe
    </x-input-floating-label>

    <x-input-floating-label>
      <x-slot name="type">number</x-slot>
      <x-slot name="inputName">Doi_xe</x-slot>
      <x-slot name="value">{{ old('Doi_xe') }}</x-slot>
      Đời xe
    </x-input-floating-label>

    <div class="grid grid-cols-2 gap-8 mb-6">
      <div class="flex justify-start gap-4 items-center">
        <label for="Loai_xe">Loại xe</label>
        <select name="Loai_xe" id="Loai_xe" class="mb-2">
          <option value="Giường nằm">Giường nằm</option>
          <option value="Ghế ngồi">Ghế ngồi</option>
          <option value="Limousine">Giường nằm</option>
        </select>
      </div>

      <div class="flex justify-start gap-4 items-center">
        <label for="So_Cho_Ngoi">Số ghế:</label>
        <select name="So_Cho_Ngoi" id="So_Cho_Ngoi" class="mb-2">
          <option value="32">32</option>
          <option value="40">42</option>
          <option value="44">44</option>
        </select>
      </div>
    </div>


    <x-input-floating-label>
      <x-slot name="type">text</x-slot>
      <x-slot name="inputName">IdNX</x-slot>
      <x-slot name="value">{{ old('IdNX') }}</x-slot>
      Mã nhà xe
    </x-input-floating-label>

    <x-submit-btn>Thêm</x-submit-btn>
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