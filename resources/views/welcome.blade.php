<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UAE</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite('resources/css/app.css')

    <style>
        .landing-page {
            background-image: url("images/UAE-bg.png");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-blend-mode: overlay;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.1);
            /* Dark overlay */
            z-index: 1;
        }

        .content {
            position: relative;
            z-index: 2;
        }

        /*--------------------------APP CARDS-----------------------------*/
        .container .card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            clip-path: circle(150px at 80% 20%);
            transition: 0.5s ease-in-out;
        }

        .container .card:hover:before {
            clip-path: circle(300px at 80% -20%);
        }

        .container .card .imgBx {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10000;
            width: 100%;
            height: 220px;
            transition: 0.5s;
        }

        .container .card:hover .imgBx {
            top: 0%;
            transform: translateY(5%);

        }

        .container .card .imgBx img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 250px;
        }

        .container .card .contentBx {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100px;
            text-align: center;
            transition: 1s;
            z-index: 10;
        }

        .container .card:hover .contentBx {
            height: 180px;
        }

        .container .card .contentBx h2 {
            position: relative;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
            color: rgb(41 37 36);
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .container .card:hover .btnBx a {
            opacity: 1;
            transform: translateY(0px);
            transition-delay: 0.25s;

        }
    </style>
</head>

<body>
    <div class="landing-page">
        <div class="overlay"></div>
        <div class="content">

            {{-- @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    @auth
                        <a href="{{ url('/accueil') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Accueil</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                            in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif --}}


            <div class="h-screen w-screen p-4 flex flex-col items-center justify-start gap-6">
                <div class="flex justify-start p-1 items-center rounded-[30px] bg-gradient-to-t from-indigo-100 shadow-xlg">
                    <x-application-logo />
                </div>

                <div class="container flex justify-center gap-6 items-center">
                    <div
                        class="card before:bg-indigo-400 relative h-[400px] w-80 bg-white rounded-[30px] shadow-lg overflow-hidden border-2">
                        <div class="imgBx">
                            <img src="images/teacher.png">
                        </div>
                        <div class="contentBx">
                            <h2>Professeur</h2>
                            <div class="btnBx flex flex-col w-fit text-center m-auto gap-1">
                                <a href="#"
                                    class="text-indigo-600 font-semibold opacity-0 translate-y-[50px] duration-200 hover:underline">Connexion</a>
                                <a href="#"
                                    class="text-indigo-600  font-semibold opacity-0 translate-y-[50px] duration-200 hover:underline">Demande
                                    Compte</a>
                            </div>
                        </div>
                    </div>

                    <div
                        class="card before:bg-orange-400 relative h-[400px] w-80 bg-white rounded-[30px] shadow-lg overflow-hidden border-2">
                        <div class="imgBx pl-10">
                            <img src="images/student.png">
                        </div>
                        <div class="contentBx">
                            <h2>Etudiant</h2>
                            <div class="btnBx flex flex-col w-fit text-center m-auto gap-1">
                                <a href="#"
                                    class="text-orange-600 font-semibold opacity-0 translate-y-[50px] duration-200 hover:underline">Connexion</a>
                                <a href="#"
                                    class="text-orange-600  font-semibold opacity-0 translate-y-[50px] duration-200 hover:underline">Demande
                                    compte</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
