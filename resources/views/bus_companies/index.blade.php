<x-layout>

  <x-flash-message />

  <h1 class="header">Nhà xe</h1>

  <div class="flex justify-between items-center my-8">
    <x-insert-btn>
      {{ route('bus_companies.create') }}
    </x-insert-btn>
    <div class="inline-flex gap-4">
      <form>
        <input placeholder="Tìm kiếm" class="px-2 rounded-md" name="search" type="search" value="{{ $search }}" />
        <button type="submit"><i class="bi bi-search text-blue-500 text-xl"></i>
        </button>
      </form>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>STT</th>
        <th>ID</th>
        <th>Tên nhà xe</th>
        <th>Số điện thoại</th>
        <th>Email</th>
        <th>Dịch vụ</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($busCompanies as $busCompany)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
          <a class="hover:underline" href="{{ route('bus_companies.show', $busCompany->IdNX) }}">{{ $busCompany->IdNX
            }}</a>
        </td>
        <td>{{ $busCompany->Ten_NX }}</td>
        <td>{{ $busCompany->sdt }}</td>
        <td>{{ $busCompany->email }}</td>
        <td>{{ $busCompany->DichVu }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- pagination --}}
  <div>
    {{ $busCompanies->links() }}
  </div>

</x-layout>