<x-layout>

  <h1 class="header">Chỉnh sửa thông người dùng</h1>

  <form action="{{ route('normal_users.update', $normal_user->IdUser) }}" method="POST" enctype="multipart/form-data" class="max-w-[500px] my-4">
    @csrf
    @method('PUT')

    <div class="flex justify-between">
      <label for="HoTen">Họ tên:</label>
      <input class="mb-2" type="text" name="HoTen" value="{{ $normal_user->HoTen }}">
    </div>

    <div class="flex justify-between">
      <label for="email">Email:</label>
      <input type="text" class="mb-2" name="email" value="{{ $normal_user->email }}" disabled>
    </div>

    <div class="flex justify-between">
      <label for="sdt">Số điện thoại:</label>
      <input class="mb-2" type="text" name="sdt" value="{{ $normal_user->sdt }}">
    </div>

    <button class="p-2 cursor-pointer bg-[#537EC5] hover:opacity-70 hover:scale-105 duration-100" type="submit">
      Lưu thay đổi
    </button>

    <div>
      @error('HoTen')
      <div class="text-red-500">{{ $message }}</div>
      @enderror
      @error('sdt')
      <div class="text-red-500">{{ $message }}</div>
      @enderror
    </div>

  </form>

</x-layout>