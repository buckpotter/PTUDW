<div class="flex justify-between items-center my-8">
  <form class="flex gap-2 items-center justify-center flex-col lg:flex-row w-full">
    <div class="flex flex-col xl:flex-row gap-2">
      {{ $filters }}
    </div>

    <div class="inline-flex gap-2 items-center">
      <div class="relative">
        <input class="block p-2.5 z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-[300px]" placeholder="Tìm kiếm" placeholder="Tìm kiếm" class="px-2 rounded-md" name="search" type="search" id="search" value="{{ $search }}">
        <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
          <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
          <span class="sr-only">Search</span>
        </button>
      </div>
      <a class="text-xl text-red-600 hover:text-red-900" href="{{ $slot }}"><i class="bi bi-x-circle"></i></a>
    </div>
  </form>
</div>