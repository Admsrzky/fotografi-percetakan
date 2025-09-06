<x-guest-layout>
    {{-- Main container for the guest layout --}}
    <div class="flex flex-col items-center justify-center min-h-screen px-4 py-8 bg-gray-900">

        {{-- Logo at the top of the card --}}
        <div class="flex justify-center mb-6">
            <img src="{{ asset('assets/images/logo1.png') }}" alt="Your Logo" class="w-24 h-24 p-1 border-2 border-gray-700 rounded-full shadow-lg">
        </div>

        {{-- Authentication card container with darker colors and adjusted padding --}}
        <div class="w-full px-6 py-6 bg-gray-800 rounded-lg shadow-xl sm:max-w-md">

            <x-validation-errors class="mb-3 text-red-400" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name Field --}}
                <div class="mb-3">
                    <x-label for="name" value="{{ __('Name') }}" class="text-sm text-white" />
                    <x-input id="name" class="block w-full px-3 py-1.5 mt-1 text-sm text-gray-700 placeholder-gray-500 bg-gray-700 border border-gray-600 rounded-md focus:border-blue-500 focus:ring-blue-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
                </div>

                {{-- Email Field --}}
                <div class="mb-3">
                    <x-label for="email" value="{{ __('Email') }}" class="text-sm text-white" />
                    <x-input id="email" class="block w-full px-3 py-1.5 mt-1 text-sm text-gray-700 placeholder-gray-500 bg-gray-700 border border-gray-600 rounded-md focus:border-blue-500 focus:ring-blue-500" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="your@example.com" />
                </div>

                {{-- Password Field --}}
                <div class="mb-3">
                    <x-label for="password" value="{{ __('Password') }}" class="text-sm text-white" />
                    <x-input id="password" class="block w-full px-3 py-1.5 mt-1 text-sm text-gray-700 placeholder-gray-500 bg-gray-700 border border-gray-600 rounded-md focus:border-blue-500 focus:ring-blue-500" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                </div>

                {{-- Confirm Password Field --}}
                <div class="mb-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-sm text-white" />
                    <x-input id="password_confirmation" class="block w-full px-3 py-1.5 mt-1 text-sm text-gray-700 placeholder-gray-500 bg-gray-700 border border-gray-600 rounded-md focus:border-blue-500 focus:ring-blue-500" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                </div>

                {{-- Terms and Privacy Policy --}}
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mb-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required class="w-4 h-4 text-blue-500 bg-gray-700 border-gray-600 rounded focus:ring-blue-500" />
                                <div class="text-sm text-gray-400 ms-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="font-medium text-blue-400 underline rounded-md hover:text-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="font-medium text-blue-400 underline rounded-md hover:text-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                @endif

                {{-- Action Buttons (Already Registered? & Register Button) --}}
                <div class="flex flex-col gap-3 mt-4 sm:flex-row sm:items-center sm:justify-between">
                    <a class="text-xs font-medium text-blue-700 underline transition duration-150 ease-in-out hover:text-blue-300" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-button class="flex items-center justify-center w-full px-4 py-2 text-sm font-bold text-white transition duration-200 ease-in-out transform bg-blue-600 rounded-lg shadow-md sm:w-auto hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-400 hover:scale-105">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
