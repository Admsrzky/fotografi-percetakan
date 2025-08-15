<x-guest-layout>
    {{-- Main container for the guest layout --}}
    <div class="flex flex-col items-center min-h-screen pt-6 sm:justify-center sm:pt-0 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-800 dark:to-gray-700">

        {{-- Logo (positioned above the card) --}}
        <div class="mb-8 -mt-40 sm:mb-10 sm:-mt-24"> {{-- Adjust mb and -mt values for desired overlap and spacing --}}
            <img src="{{ asset('assets/images/logo1.png') }}" alt="Your Logo" class="object-contain w-32 h-32 p-1 mt-20 mb-16 border-4 border-white rounded-full shadow-lg dark:border-gray-700">
        </div>

        {{-- Authentication card container --}}
        {{-- Added -mt-16 to pull the card up and overlap the logo --}}
        <div class="w-full px-6 py-8 -mt-16 transition-all duration-300 ease-in-out transform bg-white border border-gray-100 shadow-2xl sm:max-w-md rounded-xl dark:bg-gray-700 dark:border-gray-600 hover:scale-105">

            {{-- Removed x-slot for logo as it's now outside the card --}}
            {{-- <x-slot name="logo">
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('assets/images/logo1.png') }}" alt="" srcset="">
                </div>
            </x-slot> --}}

            <x-validation-errors class="mb-4 font-medium text-red-600 dark:text-red-300" />

            @session('status')
                <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-300">
                    {{ $value }}
                </div>
            @endsession

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <x-label for="email" value="{{ __('Email') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-200" />
                    <x-input id="email" class="block w-full px-4 py-2 mt-2 transition duration-150 ease-in-out border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" />
                </div>

                <div class="mb-6">
                    <x-label for="password" value="{{ __('Password') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-200" />
                    <x-input id="password" class="block w-full px-4 py-2 mt-2 transition duration-150 ease-in-out border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-400" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                </div>

                <div class="block mb-6">
                    <label for="remember_me" class="flex items-center text-gray-700 cursor-pointer dark:text-gray-300">
                        <x-checkbox id="remember_me" name="remember" class="w-4 h-4 text-blue-600 transition duration-150 ease-in-out rounded form-checkbox dark:bg-gray-600 dark:border-gray-500" />
                        <span class="text-sm ms-2">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex flex-col gap-4 mt-6 sm:flex-row sm:items-center sm:justify-between">
                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-blue-600 underline transition duration-150 ease-in-out hover:text-blue-800 dark:text-blue-300 dark:hover:text-blue-200" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-button class="flex items-center justify-center w-full px-6 py-2 font-bold text-white transition duration-200 ease-in-out transform bg-blue-600 rounded-lg shadow-md sm:w-auto hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 hover:scale-105">
                        {{ __('Log in') }}
                    </x-button>
                </div>

                {{-- New section for the registration link --}}
                @if (Route::has('register'))
                    <div class="mt-6 text-sm text-center">
                        <span class="text-gray-600 dark:text-gray-300">{{ __("Don't have an account?") }}</span>
                        <a class="ml-1 font-semibold text-blue-600 transition duration-150 ease-in-out hover:text-blue-800 dark:text-blue-300 dark:hover:text-blue-200" href="{{ route('register') }}">
                            {{ __('Register here') }}
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-guest-layout>
