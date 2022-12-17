<x-layout>

  <x-flash-message />
  <x-error-flash-message />

  <h1 class="header">Xe</h1>

  <x-search>
    <x-slot name="insertBtnUrl">
      {{ route('buses.create') }}
    </x-slot>

    <x-slot name="search">{{ $search }}</x-slot>

    {{ route('buses.index') }}
  </x-search>

  <table class="main-table">
    <thead>
      <tr>
        <!-- <th>STT</th> -->
        <th>@sortablelink('IdXe', 'Mã xe')<i class="bi bi-arrow-down-up text-sm"></th>
        <th>@sortablelink('So_xe', 'Số xe')<i class="bi bi-arrow-down-up text-sm"></th>
        <th>@sortablelink('Doi_xe', 'Đời xe')<i class="bi bi-arrow-down-up text-sm"></th>
        <th>@sortablelink('Loai_xe', 'Loại xe')<i class="bi bi-arrow-down-up text-sm"></th>
        <th>Số ghế</th>
        <th>Nhà xe</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($buses as $bus)
      <tr>
        <!-- <td>{{ $loop->iteration }}</td> -->
        <td> <a class="hover:underline" href="{{ route('buses.show', $bus->IdXe) }}">{{ $bus->IdXe }}</a></td>
        <td>{{ $bus->So_xe }}</td>
        <td>{{ $bus->Doi_xe }}</td>
        <td>{{ $bus->Loai_xe }}</td>
        <td>{{ $bus->So_Cho_Ngoi }}</td>
        <td>{{ $bus->Ten_NX }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>


  {{-- pagination --}}
  <div>
    {{ $buses->links() }}
  </div>

</x-layout>