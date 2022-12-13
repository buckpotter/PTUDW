<x-layout>

  <h1 class="header">Thêm xe</h1>

  <form action="{{ route('buses.store') }}" method="POST" enctype="multipart/form-data" class="max-w-[500px] my-4">
    @csrf

    <div class="flex-between-center">
      <label for="So_xe">Số xe:</label>
      <input class="text-black mb-2" type="text" name="So_xe" value="{{ old('So_xe') }}" placeholder="11A-12345">
    </div>

    <div class="flex-between-center">
      <label for="Doi_xe">Đời xe</label>
      <input class="text-black mb-2" type="number" name="Doi_xe" value="{{ old('Doi_xe') }}" placeholder="2020">
    </div>

    <div class="flex-between-center">
      <label for="Loai_xe">Loại xe:</label>
      <select name="Loai_xe" id="Loai_xe" class="mb-2">
        <option value="Giường nằm">Giường nằm</option>
        <option value="Ghế ngồi">Ghế ngồi</option>
        <option value="Limousine">Giường nằm</option>
      </select>
    </div>

    <div class="flex-between-center">
      <label for="So_Cho_Ngoi">Số ghế:</label>
      <select name="So_Cho_Ngoi" id="So_Cho_Ngoi" class="mb-2">
        <option value="32">32</option>
        <option value="40">42</option>
        <option value="44">44</option>
      </select>
    </div>

    <div class="flex-between-center">
      <label for="IdNX">Mã nhà xe:</label>
      <input class="text-black mb-2" type="text" name="IdNX" value="{{ old('IdNX') }}" placeholder="BC1">
    </div>



    <div>
      @error('So_xe')
      <div class="text-red-700">{{ $message }}</div>
      @enderror
      @error('Doi_xe')
      <div class="text-red-700">{{ $message }}</div>
      @enderror
      @error('So_Cho_Ngoi')
      <div class="text-red-700">{{ $message }}</div>
      @enderror
      @error('IdNX')
      <div class="text-red-700">{{ $message }}</div>
      @enderror
    </div>


    <button class="p-2 cursor-pointer bg-green-500 hover:opacity-70 hover:scale-105 duration-100" type="submit">
      Thêm
    </button>
  </form>

</x-layout>