<x-layout>
  <h1 class="header">Thêm nhà xe</h1>

  <form action="{{ route('bus_companies.store') }}" method="POST" enctype="multipart/form-data" class="max-w-[500px] my-4">
    @csrf

    <div class="flex-between-center">
      <label for="Ten_NX">Tên nhà xe:</label>
      <input class="text-black mb-2" type="text" name="Ten_NX" value="{{ old('Ten_NX') }}" placeholder="Hồng Tâm">
    </div>

    <div class="flex-between-center">
      <label for="sdt">Số điện thoại:</label>
      <input class="text-black mb-2" type="text" name="sdt" value="{{ old('sdt') }}" placeholder="0123456789">
    </div>

    <div class="flex-between-center">
      <label for="email">Email:</label>
      <input class="text-black mb-2" type="text" name="email" value="{{ old('email') }}" placeholder="youremail@gmail.com">
    </div>

    <div class="flex-between-center">
      <label for="DichVu">Dịch vụ:</label>
      <input class="text-black mb-2" type="text" name="DichVu" value="{{ old('DichVu') }}" placeholder="Nước suối">
    </div>

    <div>
      @error('Ten_NX')
      <div class="text-red-700">{{ $message }}</div>
      @enderror
      @error('sdt')
      <div class="text-red-700">{{ $message }}</div>
      @enderror
      @error('email')
      <div class="text-red-700">{{ $message }}</div>
      @enderror
      @error('DichVu')
      <div class="text-red-700">{{ $message }}</div>
      @enderror
    </div>


    <button class="p-2 cursor-pointer bg-green-500 hover:opacity-70 hover:scale-105 duration-100" type="submit">
      Thêm
    </button>
  </form>

</x-layout>