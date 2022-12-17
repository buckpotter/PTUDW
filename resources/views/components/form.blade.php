<form {{ $attributes->merge(['class' => 'bg-white p-4 rounded-md w-4/5 mx-auto mt-4']) }} method="POST" enctype="multipart/form-data" action="{{ $action }}">
  @csrf

  <h1 class="dark-header text-center mb-6">{{ $header }}</h1>

  {{-- input and label go here --}}
  {{ $slot }}

</form>