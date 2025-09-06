<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun - Studio Foto & Cetak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js"></script>
    <style>
        /* Anda bisa menambahkan CSS kustom di sini jika diperlukan */
        /* Pastikan ada padding di bagian bawah body agar konten tidak tertutup nav bar */
        body {
            padding-bottom: 4rem; /* Sesuaikan dengan tinggi nav bar (h-16 = 4rem) */
        }
        .active-nav-link {
            color: #1a202c; /* Warna teks untuk link aktif */
        }
    </style>
</head>
<body class="bg-gray-100">

    {{-- KONTEN UTAMA DARI AKUN.BLADE.PHP --}}
    <div class="container px-4 pb-20 mx-auto">
        {{-- Profile Section --}}
        <div class="py-8">
            @auth
                {{-- State: User is logged in --}}
                <a href="#" class="w-full">
                    <div class="flex items-center p-6 space-x-4 bg-yellow-100 rounded-lg shadow-md">
                        <div class="flex-shrink-0 w-16 h-16 bg-yellow-300 rounded-full">
                            <img src="{{ Auth::user()->profile_photo_url ?? asset('assets/images/default-avatar.png') }}"
                                alt="{{ Auth::user()->name }}"
                                class="object-cover w-full h-full rounded-full">
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-800">{{ Auth::user()->name }}</h1>
                            <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </a>
            @else
                {{-- State: User is not logged in --}}
                <button id="openModalBtn" class="w-full">
                    <div class="flex items-center p-6 space-x-4 bg-yellow-100 rounded-lg shadow-md">
                        <div class="flex-shrink-0 w-16 h-16 bg-yellow-300 rounded-full">
                            {{-- Placeholder for profile image --}}
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-800">Apa kabar</h1>
                            <p class="text-sm text-gray-600">Kamu belum masuk</p>
                        </div>
                    </div>
                </button>
            @endauth
        </div>

        {{-- Menu List Section --}}
        <div class="mt-8 space-y-2">
            <a href="{{ route('history') }}" class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm">
                <div class="flex items-center space-x-4">
                    {{-- SVG icon for Order History --}}
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                    <span class="font-medium text-gray-700">Riwayat Pesanan</span>
                </div>
                {{-- Chevron icon --}}
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="{{ route('kontakinfo') }}" class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm">
                <div class="flex items-center space-x-4">
                    {{-- SVG icon for Contact Info --}}
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-2 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7l9 6 9-6z"></path>
                    </svg>
                    <span class="font-medium text-gray-700">Informasi Kontak</span>
                </div>
                {{-- Chevron icon --}}
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="{{ route('settings') }}" class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm">
                <div class="flex items-center space-x-4">
                    {{-- SVG icon for Settings --}}
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.18-.329.443-.635.75-.92l1.172-1.171a.999.999 0 011.414 0l1.172 1.171c.307.285.57.591.75.92m-5.414 5.414a2 2 0 100 2.828 2 2 0 000-2.828zM12 17h.01M16 11h.01M10 11h.01M12 15a4 4 0 100-8 4 4 0 000 8z"></path>
                    </svg>
                    <span class="font-medium text-gray-700">Pengaturan</span>
                </div>
                {{-- Chevron icon --}}
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        {{-- Version Info --}}
        <p class="mt-8 text-xs text-center text-gray-400">Versi v2.15.0.1_8077f80_250820_2.15.0.1</p>

        {{-- Login/Register Modal (Only shown when user is not logged in) --}}
        @guest
        <div id="loginModal" class="fixed inset-0 z-50 items-end justify-center hidden bg-black bg-opacity-50 sm:flex sm:items-center">
            <div class="relative w-full max-w-sm p-4 mx-auto bg-white rounded-t-xl sm:rounded-lg">
                {{-- Modal Header --}}
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Masuk/Daftar</h2>
                    {{-- Discount Image --}}
                    <div class="relative w-24 h-16">
                    </div>
                </div>
                <p class="mt-1 text-sm text-gray-600">Masuk untuk memesan jasa ini</p>

                {{-- Close button --}}
                <button id="closeModalBtn" class="absolute text-gray-500 top-4 right-4 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <div class="mt-6 space-y-4">
                    {{-- Login Button --}}
                    <a href="{{ route('login') }}">
                        <button class="flex items-center justify-center w-full px-4 py-3 text-base font-semibold text-white bg-green-500 rounded-lg hover:bg-green-600">
                            Login
                        </button>
                    </a>

                    {{-- Register Button--}}
                    <a href="{{ route('register') }}">
                        <button class="flex items-center justify-center w-full px-4 py-3 text-base font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                            Register
                        </button>
                    </a>
                </div>

                {{-- Privacy Policy and Terms --}}
                <p class="mt-4 text-xs text-center text-gray-400">
                    Dengan melanjutkan proses ini, anda menyetujui
                    <a href="#" class="text-blue-500 hover:underline">Perjanjian Pengguna</a>
                    dan
                    <a href="#" class="text-blue-500 hover:underline">Kebijakan Privasi</a>
                </p>
            </div>
        </div>
        @endguest
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const loginModal = document.getElementById('loginModal');

            // Only add listeners if the elements exist (i.e., user is a guest)
            if (openModalBtn && closeModalBtn && loginModal) {
                openModalBtn.addEventListener('click', function () {
                    loginModal.classList.remove('hidden');
                    loginModal.classList.add('flex');
                });

                closeModalBtn.addEventListener('click', function () {
                    loginModal.classList.remove('flex');
                    loginModal.classList.add('hidden');
                });

                // Close modal when clicking outside of it
                loginModal.addEventListener('click', function (e) {
                    if (e.target === loginModal) {
                        loginModal.classList.remove('flex');
                        loginModal.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    {{-- NAVIGASI BAWAH UNTUK MOBILE --}}
    <nav class="fixed bottom-0 left-0 right-0 z-50 block w-full bg-white border-t border-gray-200 lg:hidden">
        <div class="flex items-center justify-around h-16">
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center flex-grow text-gray-500 transition duration-300 hover:text-gray-900">
                <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                <span class="text-xs">Beranda</span>
            </a>
            <a href="{{ route('portofolio.index') }}" class="flex flex-col items-center justify-center flex-grow text-gray-500 transition duration-300 hover:text-gray-900">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-xs">Portofolio</span>
            </a>
            <a href="{{ route('akun') }}" class="flex flex-col items-center justify-center flex-grow text-gray-700 transition duration-300 hover:text-gray-900 active-nav-link">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-xs">Akun</span>
            </a>
        </div>
    </nav>
</body>
</html>
