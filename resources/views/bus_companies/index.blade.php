<x-layout>

  <x-flash-message />
  <x-error-flash-message />

  <h1 class="header">Nhà xe</h1>

  <!-- search component -->
  <x-search>
    <x-slot name='insertBtnUrl'>
      {{ route('bus_companies.create') }}
    </x-slot>

    <x-slot name='search'>{{ $search }}</x-slot>

    {{ route('bus_companies.index') }}
  </x-search>

  <table class="main-table">
    <thead>
      <tr>
        <!-- <th>STT</th> -->
        <th>@sortablelink('IdNX', 'Mã nhà xe')<i class="bi bi-arrow-down-up text-sm"></th>
        <th>@sortablelink('Ten_NX', 'Tên nhà xe')<i class="bi bi-arrow-down-up text-sm"></th>
        <th>@sortablelink('sdt', 'Số điện thoại')<i class="bi bi-arrow-down-up text-sm"></th>
        <th>@sortablelink('email', 'Email')<i class="bi bi-arrow-down-up text-sm"></th>
        <th>@sortablelink('DichVu', 'Dịch Vụ')<i class="bi bi-arrow-down-up text-sm"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($busCompanies as $busCompany)
      <tr>
        <!-- <td>{{ $loop->iteration }}</td> -->
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



  <script type="text/javascript">
    document.getElementById('form').addEventListener('submit', function() {
      // e.preventDefault();
      let search = document.getElementById('search');
      let value = search.value;
      search.value = value;
    });
  </script>
</x-layout>