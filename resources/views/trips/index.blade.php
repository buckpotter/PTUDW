<x-layout>
  <x-flash-message />
  <h1 class="header">Chuyến xe</h1>
  <div class="flex justify-between items-center">
    <x-insert-btn>
      {{ route('trips.create') }}
    </x-insert-btn>
    <div class="inline-flex gap-4">
      <input type="text" placeholder="Tìm kiếm" class="px-2 rounded-md" />
      <button type="submit"><i class="bi bi-search text-blue-500 text-xl"></i>
      </button>
    </div>
  </div>
  <table>
    <thead>
      <tr>
        <th>STT</th>
        <th>ID chuyến</th>
        <th>Tuyến</th>
        <th>Xe</th>
        <th>Nhà xe</th>
        <th>Xuất phát</th>
        <th>Đến</th>
        <th>Giá vé</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($trips as $trip)
      <tr>
        <td>{{ $loop->iteration }}</td>
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
        <td>{{ number_format($trip->GiaVe ) }} VNĐ</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{-- pagination --}}
  <div>
    {{ $trips->links() }}
  </div>
</x-layout>