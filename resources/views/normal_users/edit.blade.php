<x-layout>

  <h1 class="header">Chỉnh sửa thông người dùng</h1>

  <x-form>
    @method('PUT')
    <x-slot name="action">{{ route('normal_users.update', $normal_user->IdUser) }}</x-slot>
    <x-slot name="header">Người dùng {{ $normal_user->IdUser }}</x-slot>

    <x-input-floating-label>
      <x-slot name="type">text</x-slot>
      <x-slot name="inputName">HoTen</x-slot>
      <x-slot name="value">{{ $normal_user->HoTen }}</x-slot>
      Họ tên
    </x-input-floating-label>

    <x-input-floating-label>
      <x-slot name="type">email</x-slot>
      <x-slot name="inputName">email</x-slot>
      <x-slot name="value">{{ $normal_user->email }}</x-slot>
      Email
    </x-input-floating-label>

    <x-input-floating-label>
      <x-slot name="type">text</x-slot>
      <x-slot name="inputName">sdt</x-slot>
      <x-slot name="value">{{ $normal_user->sdt }}</x-slot>
      Số điện thoại
    </x-input-floating-label>

    <x-input-floating-label>
      <x-slot name="type">number</x-slot>
      <x-slot name="inputName">role</x-slot>
      <x-slot name="value">{{ $normal_user->role }}</x-slot>
      Chức năng
    </x-input-floating-label>
    <x-submit-btn>Lưu</x-submit-btn>
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