<x-layout>

  <h1 class="header">Chỉnh sửa thông tin xe </h1>

  <form action="{{ route('buses.update', $bus->IdXe) }}" method="POST" enctype="multipart/form-data" class="max-w-[500px] my-4">
    @csrf
    @method('PUT')

    <div class="flex-between-center">
      <label for="So_xe">Số xe:</label>
      <input class="text-black mb-2" type="text" name="So_xe" value="{{ $bus->So_xe }}">
    </div>

    <div class="flex-between-center">
      <label for="Doi_xe">Đời xe</label>
      <input class="text-black mb-2" type="number" name="Doi_xe" value="{{ $bus->Doi_xe }}">
    </div>

    <div class="flex-between-center">
      <label for="Loai_xe">Loại xe:</label>
      <select name="Loai_xe" id="Loai_xe" class="mb-2">
        <option value="Giường nằm" {{ $bus->Loai_xe == 'Giường nằm' ? 'selected' : '' }}>Giường nằm</option>
        <option value="Ghế ngồi" {{ $bus->Loai_xe == 'Ghế ngồi' ? 'selected' : '' }}>Ghế ngồi</option>
        <option value="Limousine" {{ $bus->Loai_xe == 'Limousine' ? 'selected' : '' }}>Limousine</option>
      </select>
    </div>

    <div class="flex-between-center">
      <label for="So_Cho_Ngoi">Số ghế</label>
      <input type="number" name="So_Cho_Ngoi" value="{{ $bus->So_Cho_Ngoi }}">
    </div>


    <div class="flex-between-center">
      <label for="IdNX">Mã nhà xe</label>
      <input class="text-black mb-2" type="text" name="IdNX" value="{{ $bus->IdNX }}">
    </div>

    <button class="p-2 cursor-pointer bg-[#537EC5] hover:opacity-70 hover:scale-105 duration-100" type="submit">
      Lưu thay đổi
    </button>

    <div>
      @error('So_xe')
      <p class="text-red-500">{{ $message }}</p>
      @enderror
      @error('Doi_xe')
      <p class="text-red-500">{{ $message }}</p>
      @enderror
      @error('Loai_xe')
      <p class="text-red-500">{{ $message }}</p>
      @enderror
      @error('So_Cho_Ngoi')
      <p class="text-red-500">{{ $message }}</p>
      @enderror
      @error('IdNX')
      <p class="text-red-500">{{ $message }}</p>
      @enderror
  </form>

</x-layout>