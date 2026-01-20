<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

{{-- <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Metawish Admin') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-RXf+QSDCUQs6Q0mBuNre4GXhF6lG1F54eLhM651c01C9vrLpzjAU6RzGJQ8h9vDOMkMt2rt7NmexGk4xg1L0Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">




    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('assets/js/admin_sidebar.js') }}"></script>


    <style>
        .main-container {
            /* border: 3px solid red; */
            overflow: scroll;
            scrollbar-width: none;
            /* height: max-content; */
            max-height: 85vh;
        }
    </style>

    @stack('scripts')
</head> --}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Metawish Admin') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-RXf+QSDCUQs6Q0mBuNre4GXhF6lG1F54eLhM651c01C9vrLpzjAU6RzGJQ8h9vDOMkMt2rt7NmexGk4xg1L0Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('assets/js/admin_sidebar.js') }}"></script>
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>


    <!-- ADD PUSHER HERE -->
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>

    <style>
        .main-container {
            overflow: scroll;
            scrollbar-width: none;
            max-height: 85vh;
        }
    </style>

    @stack('scripts')
</head>

<body class="bg-white">
    <div class="min-h-screen flex">

        <!-- Sidebar -->
        @include('components.admin_sidebar')

        <!-- Main content -->
        <div class="flex-1 flex flex-col">

            <!-- Header -->
            @include('components.admin_header')

            <!-- Page Content -->
            <main class="flex-1 p-4 main-container">
                @yield('content')
            </main>
            <!-- ================= CHAT FLOATING BUTTON ================= -->
            <a href="{{ url('/admin/chat') }}"
                class="fixed bottom-6 right-6 z-50 w-14 h-14 rounded-full bg-emerald-600 hover:bg-emerald-700 shadow-lg flex items-center justify-center transition-all duration-300 group">

                <!-- Chat Icon -->
                <i class="fa-solid fa-comments text-white text-xl"></i>

                <!-- Optional pulse effect -->
                <span
                    class="absolute inline-flex h-full w-full rounded-full bg-emerald-500 opacity-20 animate-ping group-hover:hidden">
                </span>
            </a>


            @include('components.admin_footer')
        </div>



    </div>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>



</body>

</html>
