<x-guest-layout>
    {{-- Main container for the guest layout --}}
    <div class="flex flex-col items-center justify-center min-h-screen pt-10 sm:pt-0 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-800 dark:to-gray-700"> {{-- Added pt-10 for initial top margin on mobile --}}

        {{-- Logo (positioned above the card) --}}
        {{-- Simplified margin management for better control --}}
        <div class="relative z-10 -mb-12 sm:mb-0 sm:-mt-24">
            <img src="{{ asset('assets/images/logo1.png') }}" alt="Your Logo" class="object-contain p-1 mt-20 border-4 border-white rounded-full shadow-lg w-28 h-28 sm:w-32 sm:h-32 dark:border-gray-700">
        </div>

        {{-- Authentication card container --}}
        {{-- Adjusted -mt for mobile, and removed redundant 'mt-6' as it's now handled by the logo's spacing --}}
        <div class="relative w-full px-6 py-8 -mt-16 transition-all duration-300 ease-in-out transform bg-white border border-gray-100 shadow-2xl sm:max-w-md sm:mt-6 rounded-xl dark:bg-gray-700 dark:border-gray-600 hover:scale-105">

            <x-validation-errors class="mb-4 font-medium text-red-600 dark:text-red-300" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name Field --}}
                <div class="mb-4">
                    <x-label for="name" value="{{ __('Name') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-200" />
                    <x-input id="name" class="block w-full px-4 py-2 mt-2 transition duration-150 ease-in-out border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-400" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
                </div>

                {{-- Email Field --}}
                <div class="mb-4">
                    <x-label for="email" value="{{ __('Email') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-200" />
                    <x-input id="email" class="block w-full px-4 py-2 mt-2 transition duration-150 ease-in-out border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-400" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="your@example.com" />
                </div>

                {{-- Password Field --}}
                <div class="mb-4">
                    <x-label for="password" value="{{ __('Password') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-200" />
                    <x-input id="password" class="block w-full px-4 py-2 mt-2 transition duration-150 ease-in-out border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-400" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                </div>

                {{-- Confirm Password Field --}}
                <div class="mb-6">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-200" />
                    <x-input id="password_confirmation" class="block w-full px-4 py-2 mt-2 transition duration-150 ease-in-out border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-400" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                </div>

                {{-- Terms and Privacy Policy --}}
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mb-6">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required class="w-4 h-4 text-blue-600 transition duration-150 ease-in-out rounded form-checkbox dark:bg-gray-600 dark:border-gray-500" />

                                <div class="text-sm text-gray-700 ms-2 dark:text-gray-300">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="font-medium text-blue-600 underline rounded-md hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="font-medium text-blue-600 underline rounded-md hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                @endif

                {{-- Action Buttons (Already Registered? & Register Button) --}}
                <div class="flex flex-col gap-4 mt-6 sm:flex-row sm:items-center sm:justify-between">
                    {{-- The "Already registered?" link is already here, perfectly placed. --}}
                    <a class="text-sm font-medium text-blue-600 underline transition duration-150 ease-in-out hover:text-blue-800 dark:text-blue-300 dark:hover:text-blue-200" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-button class="flex items-center justify-center w-full px-6 py-2 font-bold text-white transition duration-200 ease-in-out transform bg-blue-600 rounded-lg shadow-md sm:w-auto hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 hover:scale-105">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
