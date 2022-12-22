<x-layout>
  <x-flash-message />
  <x-error-flash-message />

  <div class="flex">
    <h1 class="header mr-auto">Thông tin chuyến xe {{ $trip->IdChuyen }}</h1>
    <div class="flex gap-2">
      <x-update-btn>{{ route('trips.edit', $trip->IdChuyen) }}</x-update-btn>
      <x-delete-btn>{{ route('trips.destroy', $trip->IdChuyen) }}</x-delete-btn>
    </div>
  </div>

  <table class="sub-table lg:w-1/2 w-[90%]">
    <caption class="header">
      Chuyến xe {{ $trip->IdChuyen }}
    </caption>
    <tbody>
      <tr>
        <th>Tuyến xe</th>
        <td>{{ $trip->TenTuyen }}</td>
      </tr>
      <tr>
        <th>Xe</th>
        <td>{{ $trip->So_xe }}</td>
      </tr>
      <tr>
        <th>Xuất phát</th>
        <td>{{ $trip->GioDi }} {{ $trip->NgayDi }}</td>
      </tr>
      <tr>
        <th>Đến (dự kiến)</th>
        <td>{{ $trip->GioDen }} {{ $trip->NgayDen }}</td>
      </tr>
      <tr>
        <th>Số ghế</th>
        <td>{{ $trip->So_Cho_Ngoi }} ghế</td>
      </tr>
      <tr>
        <th>Ghế trống</th>
        <td>{{ $availableSeats }} ghế</td>
      </tr>
      <tr>
        <th>Giá vé</th>
        <td>{{ number_format($trip->GiaVe) }} đ</td>
      </tr>
      <tr>
        <th>Điểm đón</th>
        <td>
          <ol>
            @foreach ($DiemDon as $d)
            <li title="{{ $d->DiaChi }}" style="cursor: pointer;">{{ $d->Ten }}</li>
            @endforeach
          </ol>
        </td>
      </tr>
      <tr>
        <th>Thuộc nhà xe</th>
        <td>{{ $trip->Ten_NX }}</td>
      </tr>
    </tbody>
  </table>
</x-layout>