<x-guest-layout>
    {{-- Main container with a dark background --}}
    <div class="flex flex-col items-center justify-center min-h-screen px-4 py-8 bg-gray-900">

        {{-- Logo at the top of the card --}}
        <div class="flex justify-center mb-6">
            <img src="{{ asset('assets/images/logo1.png') }}" alt="Your Logo" class="w-24 h-24 p-1 border-2 border-gray-700 rounded-full shadow-lg">
        </div>

        {{-- Authentication card container with darker colors --}}
        <div class="w-full px-6 py-8 bg-gray-800 rounded-lg shadow-xl sm:max-w-md">

            <x-validation-errors class="mb-4 text-red-400" />

            @session('status')
                <div class="mb-4 text-sm font-medium text-green-400">
                    {{ $value }}
                </div>
            @endsession

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <x-label for="email" value="{{ __('Email') }}" class="text-sm text-white" />
                    <x-input id="email" class="block w-full px-3 py-2 mt-1 text-black placeholder-gray-500 bg-gray-700 border border-gray-600 rounded-md focus:border-blue-500 focus:ring-blue-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" />
                </div>

                <div class="mb-6">
                    <x-label for="password" value="{{ __('Password') }}" class="text-sm text-white" />
                    <x-input id="password" class="block w-full px-3 py-2 mt-1 text-black placeholder-gray-500 bg-gray-700 border border-gray-600 rounded-md focus:border-blue-500 focus:ring-blue-500" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="flex items-center text-gray-400 cursor-pointer">
                        <x-checkbox id="remember_me" name="remember" class="w-4 h-4 text-blue-500 bg-gray-700 border-gray-600 rounded focus:ring-blue-500" />
                        <span class="text-sm ms-2">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-xs font-medium text-blue-700 underline hover:text-blue-300" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div class="flex flex-col items-center gap-4">
                    <x-button class="flex items-center justify-center w-full px-4 py-2 font-semibold text-white transition duration-200 bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        {{ __('Log in') }}
                    </x-button>
                </div>

                @if (Route::has('register'))
                    <div class="mt-6 text-sm text-center">
                        <span class="text-gray-400">{{ __("Don't have an account?") }}</span>
                        <a class="ml-1 font-semibold text-blue-700 hover:text-blue-300" href="{{ route('register') }}">
                            {{ __('Register here') }}
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-guest-layout>
