<x-layout>
  <x-flash-message />

  <div class="flex">
    <h1 class="header mr-auto"> Nhà xe {{ $busCompany->IdNX }}</h1>
    <div class="flex gap-2">
      <x-update-btn>{{ route('bus_companies.edit', $busCompany->IdNX) }}</x-update-btn>
      <x-delete-btn>{{ route('bus_companies.destroy', $busCompany->IdNX) }}</x-delete-btn>
    </div>
  </div>

  <div class="flex gap-4">


    <div class="flex flex-col">
      <span>Tên nhà xe:</span>
      <span>Số điện thoại:</span>
      <span>Email:</span>
      <span>Dịch vụ:</span>
    </div>

    <div class="flex flex-col">
      <span>{{ $busCompany->Ten_NX }}</span>
      <span>{{ $busCompany->sdt }}</span>
      <span>{{ $busCompany->email }}</span>
      <span>{{ $busCompany->DichVu }}</span>
    </div>
  </div>

</x-layout>