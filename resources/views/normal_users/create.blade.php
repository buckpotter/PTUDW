<x-layout>

  <h1 class="header">Thêm người dùng cuối</h1>

  </form>

  <x-form>
    <x-slot name="action">{{ route('normal_users.store') }}</x-slot>
    <x-slot name="header">Thêm người dùng</x-slot>

    <x-input-floating-label>
      <x-slot name="type">text</x-slot>
      <x-slot name="inputName">HoTen</x-slot>
      <x-slot name="value">{{ old('HoTen') }}</x-slot>
      Họ tên
    </x-input-floating-label>

    <x-input-floating-label>
      <x-slot name="type">email</x-slot>
      <x-slot name="inputName">email</x-slot>
      <x-slot name="value">{{ old('email') }}</x-slot>
      Email
    </x-input-floating-label>

    <x-input-floating-label>
      <x-slot name="type">text</x-slot>
      <x-slot name="inputName">sdt</x-slot>
      <x-slot name="value">{{ old('sdt') }}</x-slot>
      Số điện thoại
    </x-input-floating-label>

    <x-input-floating-label>
      <x-slot name="type">password</x-slot>
      <x-slot name="inputName">password</x-slot>
      <x-slot name="value">{{ old('password') }}</x-slot>
      Mật khẩu
    </x-input-floating-label>

    <x-input-floating-label>
      <x-slot name="type">password</x-slot>
      <x-slot name="inputName">password_confirmation</x-slot>
      <x-slot name="value">{{ old('password_confirmation') }}</x-slot>
      Nhập lại mật khẩu
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