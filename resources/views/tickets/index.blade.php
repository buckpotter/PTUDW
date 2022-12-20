<x-layout>
  <x-flash-message />
  <x-error-flash-message />
  <h1 class="header">Hóa đơn</h1>

  <x-search-filters>

    <x-slot name="filters">
      <div class="flex flex-col md:flex-row items-center bg-white pt-8 px-4 gap-4 rounded-lg">
        <x-input-floating-label>
          <x-slot name="type">number</x-slot>
          <x-slot name="inputName">min</x-slot>
          <x-slot name="value">{{ $min }}</x-slot>
          Tổng tiền từ
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
          Ngày bán từ
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

    {{ route('tickets.index') }}

  </x-search-filters>

  @if ($errors->any())
  <div class="mt-4 p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg max-w-[400px] mx-auto" role="alert">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <!-- Bộ lọc theo tổng tiền và ngày đi -->
  <table class="main-table">
    <thead>
      <tr>
        <th>@sortablelink('IdBanVe', 'Mã hóa đơn')</th>
        <th>Mã chuyến</th>
        <th>Tuyến</th>
        <th>Hành khách</th>
        <th>Email</th>
        <th>Giá vé</th>
        <th>Số vé</th>
        <th>Tổng tiền</th>
        <th>Ngày đi</th>
        <th>Ngày bán</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($tickets as $ticket)
      <tr>
        <td><a class="hover:underline" href="{{ route('tickets.show', $ticket->IdBanVe) }}">{{ $ticket->IdBanVe }}</a>
        </td>
        <td>{{ $ticket->IdChuyen }}</td>
        <td>{{ $ticket->TenTuyen }}</td>
        <td>{{ $ticket->HoTen }}</td>
        <td>{{ $ticket->email }}</td>
        <td>{{ number_format($ticket->GiaVe ) }} đ</td>
        <td>{{ $ticket->SoVe }}</td>
        <td>{{ number_format($ticket->TongTien ) }} đ</td>
        <td>{{ date("d/m/Y", strtotime($ticket->NgayDi)) }}</td>
        <td>{{ date('H:i d/m/Y', strtotime($ticket->created_at)) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>


  {{ $tickets->links() }}
</x-layout>