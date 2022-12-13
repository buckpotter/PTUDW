<form action="{{ $slot }}" method="POST" {{ $attributes->merge(['class' => 'inline-flex items-center bg-red-600 border
  border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700
  focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
  transition ease-in-out duration-150 cursor-pointer']) }}>
  @csrf
  @method('DELETE')
  <button type="submit" class="px-4 py-2" onclick="return confirm('Xác nhận yêu cầu xóa')">Xóa</button>
</form>