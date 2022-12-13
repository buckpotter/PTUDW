<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @vite('resources/css/app.css')

  <title>Runeterra</title>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>

  <!-- AlpineJS -->
  <script src="//unpkg.com/alpinejs" defer></script>


  <!-- Fonts -->
  <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>
  <section class="">
    <button class="md:hidden text-xl absolute right-0" onclick="showMenu()">
      <i class="bi bi-list"></i>
    </button>

    <div class="flex gap-2">

      <!-- Sidebar -->
      <div id="sidebar" class="bg-slate-400 flex-col hidden md:flex h-screen justify-between gap-4 sticky top-0 text-white">
        <div class="inline-flex justify-between items-center py-4 px-2">
          <a href="/"> <img src="{{ asset('imgs/logo.png') }}" alt="logo" class="object-cover max-w-[180px]"></a>
        </div>
        <div class="flex-col flex grow">
          <?php
          $sidebarLinks = array(
            array(
              'icon' => '<i class="bi bi-speedometer2 mr-2 text-xl"></i>',
              'name' => 'Bảng điều khiển',
              'link' => '/'
            ),
            array(
              'icon' => '<i class="bi bi-person-circle mr-2 text-xl"></i>',
              'name' => 'Hồ sơ',
              'link' => '/profile'
            ),
            array(
              'icon' => '<i class="bi bi-person mr-2 text-xl"></i>',
              'name' => 'Người dùng',
              'link' => '/normal_users'
            ),
            array(
              'icon' => '<i class="bi bi-building mr-2 text-xl"></i>',
              'name' => 'Nhà xe',
              'link' => '/bus_companies'
            ),
            array(
              'icon' => '<i class="bi bi-truck-front mr-2 text-xl"></i>',
              'name' => 'Xe',
              'link' => '/buses'
            ),
            array(
              'icon' => '<i class="bi bi-truck-front mr-2 text-xl"></i>',
              'name' => 'Chuyến xe',
              'link' => '/trips'
            ),
          );

          foreach ($sidebarLinks as $link) {
            echo '<a href="' . $link['link'] . '" class="font-bold px-4 py-4 hover:opacity-60 hover:bg-slate-800 transition-all cursor-pointer">' . $link['icon'] . $link['name'] . '</a>';
          }
          ?>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="route('logout')" onclick="event.preventDefault();
                this.closest('form').submit();" class="font-bold px-4 py-4 hover:opacity-60 hover:bg-slate-800 transition-all cursor-pointer block w-full">
              <i class=" bi bi-box-arrow-right mr-2 text-xl"></i>Đăng xuất
            </a>
          </form>
        </div>
      </div>


      <div class="grow md:p-10 p-4">
        {{ $slot }}
      </div>

    </div>

  </section>


  <script src="<?php echo asset('js/index.js') ?>"></script>
</body>

</html>