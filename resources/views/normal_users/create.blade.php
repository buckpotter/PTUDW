<x-layout>

  <h1 class="header">Thêm người dùng cuối</h1>

  <form action="{{ route('normal_users.store') }}" method="POST" enctype="multipart/form-data" class="max-w-[500px] my-4">
    @csrf

    <div class="flex-between-center">
      <label for="HoTen">Họ tên:</label>
      <input class="text-black mb-2" type="text" name="HoTen" value="{{ old('HoTen') }}" placeholder="Nguyễn Văn A">
    </div>

    <div class="flex-between-center">
      <label for="email">Email:</label>
      <input class="text-black mb-2" type="text" name="email" value="{{ old('email') }}" placeholder="youremail@gmail.com">
    </div>

    <div class="flex-between-center">
      <label for="sdt">Số điện thoại:</label>
      <input class="text-black mb-2" type="text" name="sdt" value="{{ old('sdt') }}" placeholder="0123456789">
    </div>

    <div class="flex-between-center">
      <label for="password">Mật khẩu:</label>
      <input class="text-black mb-2" type="password" name="password" value="{{ old('password') }}">
    </div>

    <div class="flex-between-center">
      <label for="password_confirmation">Nhập lại mật khẩu:</label>
      <input class="text-black mb-2" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
    </div>

    <div>
      @error('HoTen')
      <div class="text-red-700">{{ $message }}</div>
      @enderror
      @error('email')
      <div class="text-red-700">{{ $message }}</div>
      @enderror
      @error('password')
      <div class="text-red-700">{{ $message }}</div>
      @enderror
      @error('password_confirmation')
      <div class="text-red-500">{{ $message }}</div>
      @enderror
    </div>

    <button class="p-2 cursor-pointer bg-green-500 hover:opacity-70 hover:scale-105 duration-100" type="submit">
      Thêm
    </button>
  </form>

</x-layout>