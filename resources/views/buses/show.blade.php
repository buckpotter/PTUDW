<x-layout>

  <x-flash-message />
  <x-error-flash-message />

  <div class="flex">
    <h1 class="header mr-auto"> Xe {{ $bus->IdXe }}</h1>
    <div class="flex gap-2">
      <x-update-btn>{{ route('buses.edit', $bus->IdXe) }}</x-update-btn>
      <x-delete-btn>{{ route('buses.destroy', $bus->IdXe) }}</x-delete-btn>
    </div>
  </div>

  <table class="sub-table lg:w-1/2 w-[90%]">
    <caption class="header">
      Xe {{ $bus->So_xe }}
    </caption>
    <tbody>
      <tr>
        <th>Số xe</th>
        <td>{{ $bus->So_xe }}</td>
      </tr>
      <tr>
        <th>Đời xe</th>
        <td>{{ $bus->Doi_xe }}</td>
      </tr>
      <tr>
        <th>Loại xe</th>
        <td>{{ $bus->Loai_xe }}</td>
      </tr>
      <tr>
        <th>Số ghế</th>
        <td>{{ $bus->So_Cho_Ngoi }} ghế</td>
      </tr>
      <tr>
        <th>Thuộc nhà xe</th>
        <td>{{ $bus->Ten_NX }}</td>
      </tr>
    </tbody>
  </table>


</x-layout>