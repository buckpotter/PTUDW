<x-layout>

  <h1 class="header">Chỉnh sửa thông tin nhà xe</h1>

  <x-form>
    @method('PUT')
    <x-slot name="action">{{ route('bus_companies.update', $busCompany->IdNX) }}</x-slot>

    <x-slot name="header">Nhà xe {{ $busCompany->IdNX }}</x-slot>

    <x-input-floating-label>
      <x-slot name="type">text</x-slot>
      <x-slot name="inputName">Ten_NX</x-slot>
      <x-slot name="value">{{ $busCompany->Ten_NX }}</x-slot>
      Tên nhà xe
    </x-input-floating-label>

    <x-input-floating-label>
      <x-slot name="type">text</x-slot>
      <x-slot name="inputName">sdt</x-slot>
      <x-slot name="value">{{ $busCompany->sdt }}</x-slot>
      Số điện thoại
    </x-input-floating-label>

    <x-input-floating-label>
      <x-slot name="type">email</x-slot>
      <x-slot name="inputName">email</x-slot>
      <x-slot name="value">{{ $busCompany->email }}</x-slot>
      Địa chỉ email
    </x-input-floating-label>

    <x-input-floating-label>
      <x-slot name="type">text</x-slot>
      <x-slot name="inputName">DichVu</x-slot>
      <x-slot name="value">{{ $busCompany->DichVu }}</x-slot>
      Dịch vụ
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