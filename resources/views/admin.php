<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | BIAM Feedback System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen bg-gradient-to-br from-indigo-100 via-white to-indigo-200 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-sm shadow-sm p-6">
        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="BIAM Logo" class="h-16 w-auto mb-4">
            <h1 class="text-xl font-semibold text-gray-800">Welcome</h1>
            <p class="text-sm text-gray-500">BIAM Feedback Management System</p>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}" 
                    placeholder="username@gmail.com"
                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 transition-all @error('email') border-red-500 focus:ring-red-400 @else border-gray-300 focus:ring-indigo-500 @enderror"
                    required
                    autofocus
                    autocomplete="email"
                >
                @error('email')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 transition-all @error('password') border-red-500 focus:ring-red-400 @else border-gray-300 focus:ring-indigo-500 @enderror"
                    required
                    autocomplete="current-password"
                >
                @error('password')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button
                type="submit"
                class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-200 shadow-md hover:shadow-lg active:transform active:scale-[0.99]"
            >
                Sign In
            </button>
        </form>

        <footer class="text-center text-xs text-gray-400 mt-10">
            &copy; {{ date('Y') }} BIAM Foundation. All rights reserved.
        </footer>
    </div>

</body>
</html>