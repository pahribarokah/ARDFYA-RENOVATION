@extends('layouts.main')

@section('title', 'Reset Password - ARDFYA')

@section('content')
<div class="py-10 md:py-16 flex-grow">
    <div class="container mx-auto px-4">
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                    <div class="bg-green-700 text-white px-6 py-3 text-center">
                        <h1 class="text-xl font-semibold">Reset Password</h1>
                    </div>

                    <div class="px-6 py-6">
                        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input id="email" type="email" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-700 focus:border-green-700 @error('email') border-red-500 @enderror" 
                                    name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

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
                                    name="password" required autocomplete="new-password">

                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                <input id="password-confirm" type="password" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-green-700 focus:border-green-700" 
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full bg-green-700 text-white px-4 py-2 rounded font-semibold hover:bg-green-800 transition-colors">
                                    Reset Password
                                </button>
                            </div>
                            
                            <div class="text-center mt-4 pt-4 border-t border-gray-200">
                                <a href="{{ route('login') }}" class="text-sm text-green-700 hover:underline">
                                    Back to Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Removed the duplicate footer - using only the main footer from the layout -->
@endsection
