@if (session()->has('message'))
<div x-data="{show: true}" x-init="setTimeout(() => show = false, 1500)" x-show="show" class="fixed top-1 left-1/2 flex p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg mx-auto duration-200">
  <p>{{ session('message') }}</p>
</div>
@endif