<x-layout>
  <!-- Hiển thị thông báo cập nhật thành công nếu có -->
  <x-flash-message />
  <x-error-flash-message />

  <div class="flex">
    <h1 class="header mr-auto">Thông tin người dùng {{ $normal_user->IdUser }}</h1>
    <div class="flex gap-2">
      <x-update-btn>{{ route('normal_users.edit', $normal_user->IdUser) }}</x-update-btn>
      <x-delete-btn>{{ route('normal_users.destroy', $normal_user->IdUser) }}</x-delete-btn>
    </div>
  </div>
  <div class="flex flex-col md:flex-row gap-4 items-center justify-center mt-4">
    <x-avatar>{{ $normal_user->image }} {{ $normal_user->IdUser }}</x-avatar>
    <div class="text-xl text-white">
      <p><strong>Tên người dùng: </strong>{{ $normal_user->HoTen }}</p>
      <p><strong>Số điện thoại: </strong>{{ $normal_user->sdt }}</p>
      <p><strong>Email: </strong>{{ $normal_user->email }}</p>
    </div>
  </div>
  <div>
    <h1 class="sub-header">Lịch sử mua vé</h1>
    <table class="main-table">
      <thead>
        <tr>
          <th class="px-4 py-2">Mã hóa đơn</th>
          <th class="px-4 py-2">Mã vé</th>
          <th class="px-4 py-2">Tuyến xe</th>
          <th class="px-4 py-2">Biển kiểm soát</th>
          <th class="px-4 py-2">Tên chỗ ngồi</th>
          <th class="px-4 py-2">Giá vé</th>
          <th class="px-4 py-2">Ngày mua</th>
          <th class="px-4 py-2">Phương thức thanh toán</th>
          <th class="px-4 py-2">Trạng thái</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($orders as $order)
        {{-- Đặt format cho giá tiền --}}
        <?php
        $gia = number_format($order->GiaVe, 0, ',', '.');
        ?>

        <tr>
          <td class="border px-4 py-2">{{ $order->IdBanVe }}</td>
          <td class="border px-4 py-2">{{ $order->IdCTBV }}</td>
          <td class="border px-4 py-2">{{ $order->TenTuyen }}</td>
          <td class="border px-4 py-2">{{ $order->So_xe }}</td>
          <td class="border px-4 py-2">{{ $order->TenChoNgoi }}</td>
          <td class="border px-4 py-2"> {{ $gia }}</td>
          <td class="border px-4 py-2">{{ $order->NgayBan }} {{ $order->GioBan }}</td>
          <td class="border px-4 py-2">{{ $order->pttt }}</td>
          <td class="border px-4 py-2">{{ $order->TinhTrangVe }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $orders->links() }}
  </div>
</x-layout>