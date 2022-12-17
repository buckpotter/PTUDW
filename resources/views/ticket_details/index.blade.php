<x-layout>
  <x-flash-message />
  <x-error-flash-message />
  <h1 class="header">Chi tiết bán vé</h1>

  <x-search>
    <x-slot name="insertBtnUrl" class="hidden">
      {{ route('ticket_details.create') }}
    </x-slot>

    <x-slot name="search">{{ $search }}</x-slot>

    {{ route('ticket_details.index') }}
  </x-search>

  <table class="main-table">
    <thead>
      <tr>
        <th>Mã hóa đơn</th>
        <th>Mã vé</th>
        <th>Mã chuyến</th>
        <th>Số ghế</th>
        <th>Giá vé</th>
        <th>Ngày đặt</th>
        <th>Phương thức thanh toán</th>
        <th>Tình trạng vé</th>
        <th>Duyệt</th>
      </tr>


    </thead>
    <tbody>
      @foreach ($ticket_details as $ticket_detail)
      <tr>
        <td>{{ $ticket_detail->IdBanVe }}</td>
        <td><a class="hover:underline" href="{{ route('ticket_details.show', $ticket_detail->IdCTBV) }}">{{ $ticket_detail->IdCTBV }}</a></td>
        <td>{{ $ticket_detail->IdChuyen }}</td>
        <td>{{ $ticket_detail->TenChoNgoi }}</td>
        <td>{{ number_format($ticket_detail->GiaVe ) }} đ</td>
        <td>{{ $ticket_detail->GioBan }} {{ $ticket_detail->NgayBan }}</td>
        <td>{{ $ticket_detail->pttt }}</td>
        <td> {{ $ticket_detail->TinhTrangVe }}</td>
        <td>
          <form action="{{ route('ticket_details.update', $ticket_detail->IdCTBV) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="success-btn">Duyệt</button>
          </form>
      </tr>
      @endforeach
    </tbody>
  </table>


  {{ $ticket_details->links() }}
</x-layout>