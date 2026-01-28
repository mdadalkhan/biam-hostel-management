<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BAIM Feedback')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased text-slate-900">
    <div class="min-h-screen flex flex-col">
        <div class="sticky top-0 z-[60]">
            @include('admin.partials.header')
        </div>

        @include('admin.partials.navigation')

        <main class="flex-1 p-4 md:p-8 pb-24 md:pb-8">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white rounded-sm shadow-sm border border-gray-100 min-h-[400px]">
                    @yield('admin_contents')
                </div>
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>