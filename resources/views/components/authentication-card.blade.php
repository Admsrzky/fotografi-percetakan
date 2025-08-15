<div class="flex flex-col items-center justify-center min-h-screen pt-6 sm:pt-0 bg-gray-50 dark:bg-gray-900">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full px-6 py-8 mt-6 overflow-hidden bg-white border border-gray-100 shadow-xl sm:max-w-md dark:bg-gray-800 sm:rounded-2xl dark:border-gray-700">
        {{ $slot }}
    </div>
</div>
