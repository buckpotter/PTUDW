<x-layout>

  <x-flash-message />

  <h1 class="header">Xe</h1>

  <div class="flex justify-between items-center">
    <x-insert-btn>
      {{ route('buses.create') }}
    </x-insert-btn>
    <div class="inline-flex gap-4">
      <input type="text" placeholder="Tìm kiếm" class="px-2 rounded-md" />
      <button type="submit"><i class="bi bi-search text-blue-500 text-xl"></i>
      </button>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>STT</th>
        <th>Id</th>
        <th>Số xe</th>
        <th>Nhà xe</th>
        <th>Đời xe</th>
        <th>Loại xe</th>
        <th>Số ghế</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($buses as $bus)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td> <a class="hover:underline" href="{{ route('buses.show', $bus->IdXe) }}">{{ $bus->IdXe }}</a></td>
        <td>{{ $bus->So_xe }}</td>
        <td>{{ $bus->Ten_NX }}</td>
        <td>{{ $bus->Doi_xe }}</td>
        <td>{{ $bus->Loai_xe }}</td>
        <td>{{ $bus->So_Cho_Ngoi }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>


  {{-- pagination --}}
  <div>
    {{ $buses->links() }}
  </div>

</x-layout>