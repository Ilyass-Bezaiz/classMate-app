<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>UAE | {{  ucfirst(Route::currentRouteName()) }}</title>

  <link rel="icon" href="{{ asset('app-logo/UAES-v-logo.png') }}" type="image/png">
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rammetto+One&display=swap"
    rel="stylesheet">


  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
  <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/lineWobble.js"></script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>


  <!-- Styles -->
  @livewireStyles
</head>


<body>
  <x-banner />
  <x-toaster-hub />

  <div class="min-h-screen bg-white dark:bg-gray-800">
    <!-- Page Content -->
    <main class="flex">

      <x-side-menu />
      <div class="flex flex-col w-full">
        @livewire('navigation-menu')

        <div class="w-full bg-[#F1F2F7] flex-1 rounded-tl-[30px] dark:bg-gray-900 relative">

          {{ $slot }}

        </div>

      </div>

    </main>
  </div>

  @stack('modals')

  @livewireScripts
</body>

</html>
