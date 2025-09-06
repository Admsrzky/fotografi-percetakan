<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Studio Foto & Cetak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js"></script>
    <style>
        /* Anda bisa menambahkan CSS kustom di sini jika diperlukan */
        .page-header {
            padding: 1rem 1rem;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100">

    {{-- HEADER (Ganti dengan header Anda jika ada) --}}
    <div class="sticky top-0 z-50 flex items-center justify-between page-header">
        <div class="flex items-center">
            <a href="{{ route('akun') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="ml-4 text-2xl font-semibold text-gray-800">Pengaturan</h1>
        </div>
    </div>

    {{-- KONTEN UTAMA DARI SETTINGS.BLADE.PHP --}}
    <div class="container px-4 py-8 mx-auto">
        <div class="space-y-1" x-data="{
            showProfile: false,
            showPassword: false,
            showAccountDeletion: false
        }">
            {{-- Menu Informasi Profil --}}
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updateProfileInformation()))
            <a href="#" @click.prevent="showProfile = !showProfile; showPassword = false; showAccountDeletion = false;"
               class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm">
                <span class="font-medium text-gray-700">Informasi Profil</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <div x-show="showProfile" x-collapse.duration.500ms>
                <div class="p-6 mt-4 rounded-lg bg-gray-50 md:p-8">
                    @livewire('profile.update-profile-information-form')
                </div>
            </div>
            @endif

            {{-- Menu Perbarui Kata Sandi --}}
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <a href="#" @click.prevent="showPassword = !showPassword; showProfile = false; showAccountDeletion = false;"
               class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm">
                <span class="font-medium text-gray-700">Perbarui Kata Sandi</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <div x-show="showPassword" x-collapse.duration.500ms>
                <div class="p-6 mt-4 rounded-lg bg-gray-50 md:p-8">
                    @livewire('profile.update-password-form')
                </div>
            </div>
            @endif

            {{-- Menu Hapus Akun --}}
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <a href="#" @click.prevent="showAccountDeletion = !showAccountDeletion; showProfile = false; showPassword = false;"
               class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm">
                <span class="font-medium text-gray-700">Hapus Akun</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <div x-show="showAccountDeletion" x-collapse.duration.500ms>
                <div class="p-6 mt-4 rounded-lg bg-gray-50 md:p-8">
                    @livewire('profile.delete-user-form')
                </div>
            </div>
            @endif
        </div>

        {{-- Tombol Keluar --}}
        <div class="mt-8 text-center">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="inline-block px-8 py-3 font-semibold text-pink-600 transition duration-300 rounded-lg hover:bg-pink-50">
                Keluar
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</body>
</html>
