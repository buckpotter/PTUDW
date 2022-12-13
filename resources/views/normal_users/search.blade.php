<x-layout>

  <x-flash-message />

  <h1 class="header">Người dùng</h1>

  <div class="flex justify-between items-center my-8">
    <x-insert-btn>
      {{ route('normal_users.create') }}
    </x-insert-btn>

    <div class="inline-flex gap-4">
      <form action="{{route('normal_users.search')}}">
        <input placeholder="Tìm kiếm" class="px-2 rounded-md" name="search" type="search" />
        <button type="submit"><i class="bi bi-search text-blue-500 text-xl"></i>
        </button>
      </form>
    </div>
  </div>

  <!-- customer table -->
  <table>
    <thead>
      <tr>
        <th>STT</th>
        <th>ID</th>
        <th>Tên khách hàng</th>
        <th>Email</th>
        <th>Số điện thoại</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($normal_users as $user)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
          <a class="hover:underline" href="{{ route('normal_users.show', $user->IdUser) }}">{{
            $user->IdUser }}</a>
        </td>
        <td>{{ $user->HoTen }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->sdt }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- pagination --}}
  <div>
    {{ $normal_users->links() }}
  </div>
</x-layout>