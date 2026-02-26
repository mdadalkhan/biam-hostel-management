<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="flex min-h-screen items-center justify-center bg-gray-100 font-sans text-gray-700 text-center">
        <div class="max-w-[400px] p-8">
            <h1 class="text-[6rem] font-extrabold leading-none text-gray-300 m-0">
                @yield('code')
            </h1>

            <h2 class="text-2xl mt-[1rem] mb-4 font-semibold text-gray-800">
                @yield('title')
            </h2>

            <p class="text-gray-500 mb-8">
                @yield('message')
            </p>

            <a href="{{ url('/admin/hostel') }}" 
               class="inline-block px-6 py-2 bg-indigo-600 text-white font-medium rounded-md no-underline hover:bg-indigo-700 transition-colors">
                Return Home
            </a>

            <p class="mt-[2rem] text-sm text-sky-900 font-bold">
                BIAM Foundation &copy; {{ date('Y') }}
            </p>
        </div>
    </div>
</body>
</html>