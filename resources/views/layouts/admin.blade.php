<!DOCTYPE html>
<html lang="en" class="h-full bg-white"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BIAM Hostel Management')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased text-slate-900 h-full"> <div class="min-h-full flex flex-col"> <div class="sticky top-0 z-[60] flex-shrink-0">
            @include('admin.partials.header')
        </div>
        
        <div class="flex-shrink-0">
            @include('admin.partials.navigation')
        </div>

        <main class="flex-1 flex flex-col w-full pb-20 md:pb-0">
            <div class="flex-1 flex flex-col w-full">
                <div class="bg-white flex-1 w-full">
                    @yield('admin_contents')
                </div>
            </div>
        </main>

    </div>
    @stack('scripts')
</body>
</html>