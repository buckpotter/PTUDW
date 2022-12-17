<x-layout>
  <x-flash-message />
  <x-error-flash-message />

  <div class="flex">
    <h1 class="header mr-auto">Nhà xe {{ $busCompany->IdNX }}</h1>
    <div class="flex gap-2">
      <x-update-btn>{{ route('bus_companies.edit', $busCompany->IdNX) }}</x-update-btn>
      <x-delete-btn>{{ route('bus_companies.destroy', $busCompany->IdNX) }}</x-delete-btn>
    </div>
  </div>


  <table class="sub-table w-4/5 lg:w-1/2">
    <caption class="header">
      Nhà xe {{ $busCompany->IdNX }}
    </caption>
    <tbody>
      <tr>
        <th>Tên nhà xe</th>
        <td>{{ $busCompany->Ten_NX }}</td>
      </tr>
      <tr>
        <th>Số điện thoại</th>
        <td>{{ $busCompany->sdt }}</td>
      </tr>
      <tr>
        <th>Email</th>
        <td>{{ $busCompany->email }}</td>
      </tr>
      <tr>
        <th>Dịch vụ</th>
        <td>{{ $busCompany->DichVu }}</td>
      </tr>
      <tr>
        <th>Đánh giá</th>
        <td style="color:#FBB454">{{ number_format((float)$rate, 2, '.', '') }} <i class="bi bi-star-fill"></i></td>
      </tr>
    </tbody>
  </table>

</x-layout>