@extends('layouts.main')

@section('title', 'Login - ARDFYA')

@section('content')
<div class="py-10 md:py-16 flex-grow">
    <div class="container mx-auto px-4">
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                    <div class="bg-green-700 text-white px-6 py-3 text-center">
                        <h1 class="text-xl font-semibold">Login</h1>
                    </div>

                    <div class="px-6 py-6">
                        <form method="POST" action="{{ route('login') }}" class="space-y-4">
                            @csrf

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input id="email" type="email" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-700 focus:border-green-700 @error('email') border-red-500 @enderror" 
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="admin@ardfya.com">

                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <input id="password" type="password" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-700 focus:border-green-700 @error('password') border-red-500 @enderror" 
                                    name="password" required autocomplete="current-password" placeholder="********">

                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input class="h-4 w-4 text-green-700 border-gray-300 rounded focus:ring-green-700" 
                                    type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="ml-2 block text-sm text-gray-700" for="remember">
                                    Remember Me
                                </label>
                            </div>

                            <div>
                                <button type="submit" class="w-full bg-green-700 text-white px-4 py-2 rounded font-semibold hover:bg-green-800 transition-colors">
                                    Login
                                </button>
                            </div>
                            
                            <div class="flex justify-end">
                                @if (Route::has('password.request'))
                                    <a class="text-sm text-green-700 hover:underline" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                @endif
                            </div>
                            
                            @if (Route::has('register'))
                                <div class="text-center mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-sm text-gray-600">
                                        Don't have an account? <a href="{{ route('register') }}" class="text-green-700 font-medium hover:underline">Register here</a>
                                    </p>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Removed the duplicate footer - using only the main footer from the layout -->
@endsection
