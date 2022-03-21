<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased">
<x-jet-banner/>

<div class="min-h-screen bg-gray-100 flex flex-wrap">

    @livewire('navigation-menu')


    <!-- Page Content -->
    <aside class="bg-blue-900 md:w-2/12 sm:w-3/12 min-h-screen">
        <ul class="list-none flex flex-col text-left justify-between text-lg p-2 mt-3 h-fit">
            <li class="text-white  cursor-pointer m-2">
                <a href="{{route('employee')}}"> Employee Management</a>
            </li>
            <hr>
            <li class="text-white m-2 cursor-pointer" x-data="{
                        dropdown : false
                    }" @click="dropdown = !dropdown" @click.outside="dropdown =false">

                <div class="flex w-full h-5 justify-between items-center">
                    <h2> System Management </h2>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                <ul class="flex flex-col text-white text-sm mt-1" x-show="dropdown" x-transition.duration.200ms>
                    <li class="m-1 ml-2 hover:bg-blue-600 transition-all duration-200 ease-in"><a
                            href="{{route('country')}}" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                            Country </a></li>
                    <li class="m-1 ml-2 hover:bg-blue-600 transition-all duration-200 ease-in"><a
                            href="{{route('city')}}" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                            City </a></li>
                    <li class="m-1 ml-2 hover:bg-blue-600 transition-all duration-200 ease-in"><a
                            href="{{route('department')}}" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                            Department </a></li>


                </ul>
            </li>
            <hr>
            <li class="text-white m-2  cursor-pointer" x-data="{
                dropdown : false
}" @click="dropdown = !dropdown" @click.outside="dropdown = false">
                <div class="flex w-full h-5 justify-between items-center">
                    <h2> User Management </h2>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                <ul class="flex flex-col text-white text-sm mt-1" x-show="dropdown" x-transition.duration.300ms>
                    <li class="m-1 ml-2 hover:bg-blue-600 transition-all duration-200 ease-in"><a
                            href="{{route('user-index')}}" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                            User </a></li>
                </ul>
            </li>

        </ul>

    </aside>

    <main class="w-9/12 p-4">
        {{ $slot }}
    </main>


</div>

@stack('modals')

@livewireScripts
</body>
</html>
