<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Studio Foto & Cetak - Abadikan Momen Berharga Anda')</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_green.css">

    <style>
        /* ... CSS kustom Anda yang sudah ada ... */
        body {
            font-family: 'Poppins', sans-serif;
            color: #333333;
            background-color: #F8F8F8;
            /* Tambahkan padding di bawah agar konten tidak tertutup navigasi */
            padding-bottom: 64px; /* Sesuaikan dengan tinggi nav (h-16) */
        }
        h1, h2, h3, h4, h5, h6 { font-family: 'Playfair Display', serif; color: #222222; }
        .text-accent { color: #B8860B; }
        .bg-accent { background-color: #B8860B; }
        .hover\:bg-accent-dark:hover { background-color: #A0720B; }
        .form-input-elegent { ... }
        .form-input-elegent:focus { ... }
        .form-input-elegent::placeholder { ... }
        /* Tambahkan CSS untuk tombol WhatsApp jika belum ada */
        .whatsapp-float-styled {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background-color: #F3F4F6;
            color: #4B5563;
            border-radius: 9999px;
            padding: 10px 20px 10px 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
            text-decoration: none;
            white-space: nowrap;
        }
        .whatsapp-float-styled:hover { transform: translateY(-3px); box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3); }
        .whatsapp-float-styled img { width: 32px; height: 32px; margin-right: 8px; }
    </style>

    @stack('styles')
    @livewireStyles
</head>

<body class="bg-gray-50">

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- NAVIGASI BAWAH UNTUK MOBILE TELAH DIPINDAHKAN KESINI --}}
    <nav class="fixed bottom-0 left-0 right-0 z-50 block w-full bg-white border-t border-gray-200 lg:hidden">
        <div class="flex items-center justify-around h-16">
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center flex-grow text-gray-700 transition duration-300 hover:text-gray-900 active-nav-link">
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
            <a href="{{ route('akun') }}" class="flex flex-col items-center justify-center flex-grow text-gray-500 transition duration-300 hover:text-gray-900">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-xs">Akun</span>
            </a>
        </div>
    </nav>

    {{-- TOMBOL WHATSAPP JUGA ADA DISINI --}}
    <a href="https://wa.me/6289675704877" target="_blank" aria-label="Chat via WhatsApp"
        class="fixed z-40 flex items-center p-3 pr-6 transition duration-300 bg-green-500 rounded-full shadow-lg bottom-20 right-4 hover:bg-green-600 focus:outline-none focus:ring-4 focus:ring-green-300">
        <img src="{{ asset('assets/images/icons/wa1.svg') }}" class="w-8 h-8" alt="WhatsApp Icon">
        <span class="ml-2 font-semibold text-white">WhatsApp Us</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('scripts')
    @livewireScripts
    @stack('modals')
</body>
</html>
