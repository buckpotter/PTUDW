<x-layout>

  <x-flash-message />

  <div class="flex">
    <h1 class="header mr-auto"> Xe {{ $bus->IdXe }}</h1>
    <div class="flex gap-2">
      <x-update-btn>{{ route('buses.edit', $bus->IdXe) }}</x-update-btn>
      <x-delete-btn>{{ route('buses.destroy', $bus->IdXe) }}</x-delete-btn>
    </div>
  </div>

  <div class="flex gap-4">


    <div class="flex flex-col">
      <span>Số xe:</span>
      <span>Đời xe</span>
      <span>Loại xe</span>
      <span>Số ghế</span>
      <span>Thuộc nhà xe:</span>
    </div>

    <div class="flex flex-col">
      <span>{{ $bus->So_xe }}</span>
      <span>{{ $bus->Doi_xe }}</span>
      <span>{{ $bus->Loai_xe }}</span>
      <span>{{ $bus->So_Cho_Ngoi }} ghế</span>
      <span>{{ $bus->Ten_NX }}</span>
    </div>
  </div>


</x-layout>