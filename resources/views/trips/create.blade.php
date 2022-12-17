<x-layout>

  <x-error-flash-message />

  <h1 class="header">Thêm chuyến xe</h1>

  <x-form>
    <x-slot name="action">{{ route('trips.store') }}</x-slot>
    <x-slot name="header">Thêm chuyến xe</x-slot>

    <div class="grid grid-cols-2 gap-8 my-6">
      <div class="flex justify-start gap-4 items-center">
        <label for="DiemDi">Điểm đi: </label>
        <select name="DiemDi" id="DiemDi">
          @foreach ($cities as $city)
          <option value="{{ $city }}">{{ $city }}</option>
          @endforeach
        </select>
      </div>

      <div class="flex justify-start gap-4 items-center">
        <label for="DiemDen">Điểm đến: </label>
        <select name="DiemDen" id="DiemDen">
          @foreach ($cities as $city)
          <option value="{{ $city }}">{{ $city }}</option>
          @endforeach
        </select>
      </div>

      <div class="flex justify-start gap-4 items-center">
        <label for="XuatPhat">Ngày đi: </label>
        <input class='date' type="datetime-local" name='XuatPhat' value="{{ old('XuatPhat') }}" min="">
      </div>

      <div class="flex justify-start gap-4 items-center">
        <label for="Den">Ngày đến: </label>
        <input class='date' type="datetime-local" name='Den' value="{{ old('Den') }}">
      </div>
    </div>

    <x-input-floating-label>
      <x-slot name="type">text</x-slot>
      <x-slot name="inputName">So_xe</x-slot>
      <x-slot name="value">{{ old('So_xe') }}</x-slot>
      Số xe
    </x-input-floating-label>

    <x-input-floating-label>
      <x-slot name="type">number</x-slot>
      <x-slot name="inputName">GiaVe</x-slot>
      <x-slot name="value">{{ old('GiaVe') }}</x-slot>
      Giá vé
    </x-input-floating-label>

    <x-submit-btn>Thêm chuyến xe</x-submit-btn>
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


  <script>
    // Vô hiệu hóa ngày đi, ngày đến trước thời điểm hiện tại
    const date = document.querySelectorAll('.date');
    let today = new Date().toISOString().slice(0, 16);
    date.forEach((element) => element.setAttribute('min', today));
  </script>
</x-layout>