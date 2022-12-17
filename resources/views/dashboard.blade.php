<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hồ sơ') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Xin chào!") }}
                    {{ $user->name }}
                    <table id="admin-info">
                        <tr>
                            <td>Họ tên:</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td>Số điện thoại:</td>
                            <td>
                                @if ($user->sdt == NULL)
                                {{ __('Chưa cập nhật') }}
                                @else
                                {{ $user->sdt }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Quyền:</td>
                            <td>
                                @if ($user->IdNX == NULL)
                                {{ __('Quản trị viên hệ thống') }}
                                @else
                                {{ __("Quản trị viên nhà xe $Ten_NX") }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <a class="float-right p-2 rounded-md bg-slate-400 m-2" href="{{ route('home.index') }}">Quay lại bảng
                    điều khiển</a>
            </div>
        </div>
    </div>
</x-app-layout>