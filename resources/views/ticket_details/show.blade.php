<x-layout>

  <table class="sub-table lg:w-1/2 w-[90%]">
    <caption class="header">
      Chi tiết vé {{ $ticket_detail->IdCTBV }}
    </caption>
    <tbody>
      <tr>
        <th>Hóa đơn:</th>
        <td>{{ $ticket_detail->IdBanVe }}</td>
      </tr>
      <tr>
        <th>Mã chuyến:</th>
        <td>{{ $ticket_detail->IdChuyen }}</td>
      </tr>
      <tr>
        <th>Tuyến xe:</th>
        <td>{{ $ticket_detail->TenTuyen }}</td>
      </tr>
      <tr>
        <th>Xe:</th>
        <td>{{ $ticket_detail->So_xe }}</td>
      </tr>
      <tr>
        <th>Xuất phát:</th>
        <td>{{ $ticket_detail->GioDi }} {{ $ticket_detail->NgayDi }}</td>
      </tr>
      <tr>
        <th>Đến (dự kiến):</th>
        <td>{{ $ticket_detail->GioDen }} {{ $ticket_detail->NgayDen }}</td>
      </tr>
      <tr>
        <th>Số ghế:</th>
        <td>{{ $ticket_detail->TenChoNgoi }}</td>
      </tr>
      <tr>
        <th>Giá vé:</th>
        <td>{{ number_format($ticket_detail->GiaVe) }} đ</td>
      </tr>
      <tr>
        <th>Thuộc nhà xe:</th>
        <td>{{ $ticket_detail->Ten_NX }}</td>
      </tr>
    </tbody>
  </table>

</x-layout>