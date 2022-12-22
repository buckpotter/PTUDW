<x-mail::message>
  # Cảm ơn bạn đã đặt vé tại Runeterra

  Vé {{ $IdCTBV }} thuộc hóa đơn {{ $IdBanVe }}
  @if ($status == 'Duyệt')
  đã được duyệt.
  @else
  đã bị hủy.
  @endif

  {{-- <table>
    <tr>
      <td>Tuyến</td>
      <td>{{ $TenTuyen }}</td>
    </tr>
    <tr>
      <td>Giờ khởi hành</td>
      <td>{{ $GioKhoiHanh }}</td>
    </tr>
    <tr>
      <td>Giờ đến</td>
      <td>{{ $GioDen }}</td>
    </tr>
    <tr>
      <td>Giá vé</td>
      <td>{{ $GiaVe }}</td>
    </tr>
    <tr>
      <td>Số ghế</td>
      <td>{{ $SoGhe }}</td>
    </tr>
  </table> --}}

  {{-- <x-mail::button :url="''">
    Đến Runeterra
  </x-mail::button> --}}

  Thanks,<br>
  {{ config('app.name') }}
</x-mail::message>