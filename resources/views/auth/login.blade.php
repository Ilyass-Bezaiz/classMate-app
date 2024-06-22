<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UAE | {{ ucfirst(Route::currentRouteName()) }}</title>

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
    <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/lineWobble.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>


    <!-- Styles -->
    @livewireStyles

    <style>
        .landing-page {
            background-image: url("images/UAE-bg.jpg");
            background-size: inherit;
            background-position: top;
        }

        .main-bg {
            background-image: url("images/bg.jpg");
            background-size: cover;
            background-position: right bottom;
            filter: contrast(1);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
            /* Dark overlay */
            z-index: 1;
        }

        .content {
            position: relative;
            z-index: 2;
        }
    </style>
</head>

<body>

    <div class="bg-gray-100 min-h-screen min-w-screen relative flex justify-center items-center z-50">
        {{-- login card --}}
        <div class="login-card  w-1/3 absolute right-[40%] inset-y-10 flex flex-col justify-center items-center">
            <div>
                <x-application-logo />
            </div>

            <div class="w-full mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden rounded-[30px]">
                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Mot de passe') }}" />
                        <x-input-password id="password" class="block mt-1 w-full" name="password" required
                            placeholder="" autocomplete="current-password" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span
                                class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Se souvenir de moi') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                href="{{ route('password.request') }}">
                                {{ __('Mot de passe oublié ?') }}
                            </a>
                        @endif

                        <x-button class="ms-4">
                            {{ __('Se connecter') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Image card --}}
        <div class="img-card w-[45%] h-[86%] landing-page absolute right-[2%] inset-y-10 rounded-[30px] -z-30 shadow-xl pt-14">
            <div class="overlay rounded-[30px] shadow-lg"></div>
            <div class="h-full w-full flex flex-col justify-start items-center text-center text-white gap-2">
                <h1 class="font-bold text-2xl z-30">BIENVENUE !</h1>
                <p class="text-gray-100 z-30">Veuillez vous connectez</p>
                <p class="text-gray-100 z-30">ou</p>
                <x-secondary-button wire:navigate href="{{ route('demande.compte') }}"
                    class="mt-4 z-30 shadow-md hover:bg-trasparent">Demander un compte</x-secondary-button>
            </div>
        </div>

        {{-- bg cards --}}
        <div
            class="bg-card bg-card1 w-[45%] h-[900px] bg-indigo-500 absolute -left-80 -top-72 rounded-[60px] -z-50 pt-14 rotate-45">
        </div>
        <div
            class="bg-card bg-card2 w-[300px] h-[300px] bg-indigo-500 absolute left-8 -bottom-44 rounded-[40px] -z-50 pt-14 rotate-45">
        </div>
        <div class="bg-card bg-card3 w-[300px] h-[300px] bg-indigo-500 absolute -right-44 -bottom-44 -z-50 pt-14 rotate-45">
        </div>
        
    </div>
    <x-loading/>
    <x-toaster-hub />
    @livewireScripts
</body>

</html>
