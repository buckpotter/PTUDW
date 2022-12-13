<x-layout>

  <h1 class="header">Thêm chuyến xe</h1>

  <form action="{{ route('trips.store') }}" method="POST" enctype="multipart/form-data" class="max-w-[500px] my-4 ">
    @csrf
    <div class="flex-between-center">
      <label for="DiemDi">Điểm đi: </label>
      <select name="DiemDi" id="DiemDi">
        @foreach ($cities as $city)
        <option value="{{ $city }}">{{ $city }}</option>
        @endforeach
      </select>
    </div>

    <div class="flex-between-center">
      <label for="DiemDen">Điểm đến: </label>
      <select name="DiemDen" id="DiemDen">
        @foreach ($cities as $city)
        <option value="{{ $city }}">{{ $city }}</option>
        @endforeach
      </select>
    </div>

    <div class="flex-between-center">
      <label for="XuatPhat">Ngày đi: </label>
      <input class='date' type="datetime-local" name='XuatPhat' value="{{ old('XuatPhat') }}" min="">
    </div>

    <div class="flex-between-center">
      <label for="Den">Ngày đến: </label>
      <input class='date' type="datetime-local" name='Den' value="{{ old('Den') }}">
    </div>

    <div class="flex-between-center">
      <label for="So_xe">Số xe: </label>
      <input type="text" name="So_xe" value="{{ old('So_xe') }}" placeholder="11A-12345">
    </div>

    <div class="flex-between-center">
      <label for="GiaVe">Giá vé: </label>
      <input type="number" name="GiaVe" value="{{ old('GiaVe') }}">
    </div>

    <button class="p-2 cursor-pointer bg-green-500 hover:opacity-70 hover:scale-105 duration-100" type="submit">
      Thêm
    </button>

    <div>
      @error('DiemDi')
      <p class="text-red-500">{{ $message }}</p>
      @enderror
      @error('DiemDen')
      <p class="text-red-500">{{ $message }}</p>
      @enderror
      @error('XuatPhat')
      <p class="text-red-500">{{ $message }}</p>
      @enderror
      @error('Den')
      <p class="text-red-500">{{ $message }}</p>
      @enderror
      @error('So_xe')
      <p class="text-red-500">{{ $message }}</p>
      @enderror
      @error('GiaVe')
      <p class="text-red-500">{{ $message }}</p>
      @enderror
    </div>
  </form>

  <script>
    // Vô hiệu hóa ngày đi, ngày đến trước thời điểm hiện tại
    const date = document.querySelectorAll('.date');
    let today = new Date().toISOString().slice(0, 16);
    date.forEach((element) => element.setAttribute('min', today));
  </script>
</x-layout>