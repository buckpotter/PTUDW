<x-layout>
  <x-flash-message />

  <div class="flex">
    <h1 class="header mr-auto">Thông tin chuyến xe {{ $trip->IdChuyen }}</h1>
    <div class="flex gap-2">
      <x-update-btn>{{ route('trips.edit', $trip->IdChuyen) }}</x-update-btn>
      <x-delete-btn>{{ route('trips.destroy', $trip->IdChuyen) }}</x-delete-btn>
    </div>
  </div>


  <div class="flex gap-4">
    <div class="flex flex-col">
      <span>Tuyến xe:</span>
      <span>Xe: </span>
      <span>Xuất phát:</span>
      <span>Đến (dự kiến):</span>
      <span>Số ghế:</span>
      <span>Ghế trống:</span>
      <span>Giá vé:</span>
      <span>Thuộc nhà xe:</span>
    </div>

    <div class="flex flex-col">
      <span>{{ $trip->TenTuyen }}</span>
      <span>{{ $trip->So_xe }}</span>
      <span>{{ $trip->GioDi }} {{ $trip->NgayDi }}</span>
      <span>{{ $trip->GioDen }} {{ $trip->NgayDen }}</span>
      <span>{{ $trip->So_Cho_Ngoi }} ghế</span>
      <span>{{ $availableSeats }} ghế</span>
      <span>{{ number_format($trip->GiaVe) }} đ</span>
      <span>{{ $trip->Ten_NX }}</span>
    </div>
  </div>


</x-layout>