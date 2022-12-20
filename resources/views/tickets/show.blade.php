<x-layout>
  <table class="sub-table lg:w-1/2 w-[90%]">
    <caption class="header">
      Hóa đơn {{ $ticket->IdBanVe }}
    </caption>
    <tbody>
      <tr>
        <th>Mã chuyến</th>
        <td>{{ $ticket->IdChuyen }}</td>
      </tr>
      <tr>
        <th>Tên tuyến</th>
        <td>{{ $ticket->TenTuyen }}</td>
      </tr>
      <tr>
        <th>Tên hành khách</th>
        <td>{{ $ticket->HoTen }}</td>
      </tr>
      <tr>
        <th>Email</th>
        <td>{{ $ticket->email }}</td>
      </tr>
      <tr>
        <th>Số điện thoại</th>
        <td>{{ $ticket->sdt }}</td>
      </tr>
      <tr>
        <th>Tổng tiền</th>
        <td>{{ number_format($ticket->TongTien) }} đ</td>
      </tr>
      <tr>
        <th>Số vé</th>
        <td>{{ $ticket->SoVe }}</td>
      </tr>
      <tr>
        <th>Ghế</th>
        <td>
          @foreach ($seats as $seat)
          {{ $seat->TenChoNgoi }}
          @endforeach
        </td>
      </tr>
      <tr>
        <th>Xe</th>
        <td>{{ $bus->So_xe }}</td>
      </tr>
      <tr>
        <th>Nhà xe</th>
        <td>{{ $bus->Ten_NX }}</td>
      </tr>
      <tr>
        <th>Xuất phát</th>
        <td>{{ $XuatPhat }}</td>
      </tr>
      <tr>
        <th>Ngày đặt</th>
        <td>{{ date('H:i:s d-m-Y', strtotime($ticket->created_at)) }}</td>
      </tr>
      <tr>
        <th>Phương thức thanh toán</th>
        <td>{{ $pttt }}</td>
      </tr>
    </tbody>
  </table>

</x-layout>