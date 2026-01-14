<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'User Dashboard') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fb;
            /* Scrollbar body se hata kar main content me daalenge */
            overflow: hidden;
        }
    </style>
</head>

<body>
    <div class="flex h-screen overflow-hidden">

        <aside class="h-full overflow-y-auto border-r bg-white">
            @include('components.user_dashboard_sidebar')
        </aside>

        <div class="flex-1 flex flex-col min-w-0 h-full">

            <header class="flex-shrink-0">
                @include('components.user_dashboard_header')
            </header>

            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                @yield('content')
            </main>

        </div>
    </div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
