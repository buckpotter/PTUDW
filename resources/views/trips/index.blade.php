<x-layout>
  <x-flash-message />
  <x-error-flash-message />
  <h1 class="header">Chuyến xe</h1>

  <x-search>
    <x-slot name="insertBtnUrl">
      {{ route('trips.create') }}
    </x-slot>

    <x-slot name="search">{{ $search }}</x-slot>

    {{ route('trips.index') }}
  </x-search>

  <table class="main-table">
    <thead>
      <tr>
        <!-- <th>STT</th> -->
        <th>@sortablelink('IdChuyen', 'Mã chuyến')<i class="bi bi-arrow-down-up text-sm"></th>
        <th>Tuyến</th>
        <th>Số xe</th>
        <th>Nhà xe</th>
        <th>Xuất phát</th>
        <th>Đến</th>
        <th>@sortablelink('GiaVe', 'Giá vé')<i class="bi bi-arrow-down-up text-sm"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($trips as $trip)
      <tr>
        <!-- <td>{{ $loop->iteration }}</td> -->
        <td> <a class="hover:underline" href="{{ route('trips.show', $trip->IdChuyen) }}">
            {{ $trip->IdChuyen }}</a></td>
        <td>{{ $trip->TenTuyen }}</td>
        <td>{{ $trip->So_xe }}</td>
        <td>{{ $trip->Ten_NX }}</td>
        <td>
          {{ $trip->NgayDi }} {{ $trip->GioDi }}
        </td>
        <td>
          {{ $trip->NgayDen }} {{ $trip->GioDen }}
        <td>{{ number_format($trip->GiaVe ) }} đ</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{-- pagination --}}
  <div>
    {{ $trips->links() }}
  </div>
</x-layout>