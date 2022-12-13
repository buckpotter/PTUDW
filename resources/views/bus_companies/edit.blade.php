<x-layout>

  <h1 class="header">Chỉnh sửa thông tin nhà xe </h1>

  <form action="{{ route('bus_companies.update', $busCompany->IdNX) }}" method="POST" enctype="multipart/form-data" class="max-w-[500px] my-4">
    @csrf
    @method('PUT')

    <div class="flex justify-between">
      <label for="Ten_NX">Tên nhà xe:</label>
      <input class="mb-2" type="text" name="Ten_NX" value="{{ $busCompany->Ten_NX }}">
    </div>

    <div class="flex justify-between">
      <label for="sdt">Số điện thoại</label>
      <input class="mb-2" type="text" name="sdt" value="{{ $busCompany->sdt }}">
    </div>

    <div class="flex justify-between">
      <label for="email">Email</label>
      <input class="mb-2" type="text" name="email" value="{{ $busCompany->email }}">
    </div>

    <div class="flex justify-between items-center">
      <label for="DichVu">Dịch vụ</label>
      <textarea class="mb-2" type="text" name="DichVu">{{ $busCompany->DichVu }}
      </textarea>
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

    <button class="p-2 cursor-pointer bg-[#537EC5] hover:opacity-70 hover:scale-105 duration-100" type="submit">
      Lưu thay đổi
    </button>
  </form>

</x-layout>