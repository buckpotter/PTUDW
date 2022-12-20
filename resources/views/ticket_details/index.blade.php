<x-layout>
  <x-flash-message />
  <x-error-flash-message />
  <h1 class="header">Chi tiết bán vé</h1>

  <x-search-filters>

    <x-slot name="filters">
      <div class="flex flex-col md:flex-row items-center bg-white pt-8 px-4 gap-4 rounded-lg">
        <x-input-floating-label>
          <x-slot name="type">number</x-slot>
          <x-slot name="inputName">min</x-slot>
          <x-slot name="value">{{ $min }}</x-slot>
          Giá vé từ
        </x-input-floating-label>

        <x-input-floating-label>
          <x-slot name="type">number</x-slot>
          <x-slot name="inputName">max</x-slot>
          <x-slot name="value">{{ $max }}</x-slot>
          đến
        </x-input-floating-label>
      </div>

      <div class="flex flex-col md:flex-row items-center bg-white pt-8 px-4 gap-4 rounded-lg">
        <x-input-floating-label>
          <x-slot name="type">date</x-slot>
          <x-slot name="inputName">lower-limit</x-slot>
          <x-slot name="value">{{ $lowerlimit }}</x-slot>
          Ngày đặt từ
        </x-input-floating-label>

        <x-input-floating-label>
          <x-slot name="type">date</x-slot>
          <x-slot name="inputName">upper-limit</x-slot>
          <x-slot name="value">{{ $upperlimit }}</x-slot>
          đến
        </x-input-floating-label>
      </div>
    </x-slot>

    <x-slot name="search">{{ $search }}</x-slot>

    {{ route('ticket_details.index') }}

  </x-search-filters>

  <table class="main-table">
    <thead>
      <tr>
        <th>Mã vé</th>
        <th>Mã hóa đơn</th>
        <th>Mã chuyến</th>
        <th>Tên tuyến</th>
        <th>Email</th>
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
        <td><a class="hover:underline" href="{{ route('ticket_details.show', $ticket_detail->IdCTBV) }}">{{
            $ticket_detail->IdCTBV }}</a></td>
        <td>{{ $ticket_detail->IdBanVe }}</td>
        <td>{{ $ticket_detail->IdChuyen }}</td>
        <td>{{ $ticket_detail->TenTuyen }}</td>
        <td>{{ $ticket_detail->email }}</td>
        <td>{{ $ticket_detail->TenChoNgoi }}</td>
        <td>{{ number_format($ticket_detail->GiaVe ) }} đ</td>
        <td>{{ date('H:i:s d-m-Y', strtotime($ticket_detail->created_at)) }}</td>
        <td>{{ $ticket_detail->pttt }}</td>
        <td> {{ $ticket_detail->TinhTrangVe }}</td>
        <td>
          <form action="{{ route('ticket_details.update', $ticket_detail->IdCTBV) }}" method="POST" class="mb-2">
            @csrf
            @method('PUT')
            <button type="submit" class="success-btn" onclick='return confirm("Bạn muốn duyệt vé {{ $ticket_detail->IdCTBV }}")'>Duyệt</button>
          </form>

          <form action="{{ route('ticket_details.cancel', $ticket_detail->IdCTBV) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="danger-btn" onclick="return confirm('Xác nhận yêu cầu hủy vé')">Hủy</button>
          </form>
      </tr>
      @endforeach
    </tbody>
  </table>


  {{ $ticket_details->links() }}
</x-layout>