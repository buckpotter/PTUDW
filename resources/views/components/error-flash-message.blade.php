@if (session()->has('error'))
<div x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)" x-show="show" class="fixed top-1 left-1/2 flex p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg duration-200">
  <p>{{ session('error') }}</p>
</div>
@endif