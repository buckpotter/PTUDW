<x-layout>

  <x-flash-message />
  <x-error-flash-message />

  <h1 class="header">Người dùng</h1>

  <x-search>
    <x-slot name="insertBtnUrl">
      {{ route('normal_users.create') }}
    </x-slot>

    <x-slot name="search">{{ $search }}</x-slot>

    {{ route('normal_users.index') }}
  </x-search>

  <!-- customer table -->
  <table class="main-table">
    <thead>
      <tr>
        <!-- <th>STT</th> -->
        <th>@sortablelink('IdUser', 'Mã người dùng')<i class="bi bi-arrow-down-up text-sm"></th>
        <th>@sortablelink('HoTen', 'Tên người dùng')<i class="bi bi-arrow-down-up text-sm"></th>
        <th>@sortablelink('email', 'Email')<i class="bi bi-arrow-down-up text-sm"></th>
        <th>@sortablelink('sdt', 'Số điện thoại')<i class="bi bi-arrow-down-up text-sm"></th>
        <th>@sortablelink('role', 'Chức năng')<i class="bi bi-arrow-down-up text-sm"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($normal_users as $user)
      <tr>
        <!-- <td>{{ $loop->iteration }}</td> -->
        <td>
          <a class="hover:underline" href="{{ route('normal_users.show', $user->IdUser) }}">{{
            $user->IdUser }}</a>
        </td>
        <td>{{ $user->HoTen }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->sdt }}</td>
        <td>
          @if ($user->role == 1)
          Quản trị
          @else
          Người dùng
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- pagination --}}
  <div>
    {{ $normal_users->links() }}
  </div>
</x-layout>