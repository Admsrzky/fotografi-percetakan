<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- PASTIKAN BARIS INI ADA --}}
    <title>@yield('title', 'Studio Foto & Cetak - Abadikan Momen Berharga Anda')</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Flatpickr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_green.css">

    {{-- Custom CSS Anda untuk Global, Form, dan Flatpickr --}}
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #333333;
            background-color: #F8F8F8;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
            color: #222222;
        }

        .text-accent {
            color: #B8860B;
        }

        .bg-accent {
            background-color: #B8860B;
        }

        .hover\:bg-accent-dark:hover {
            background-color: #A0720B;
        }

        /* Styling untuk Input Form yang lebih detail */
        .form-input-elegent {
            width: 100%;
            padding: 0.75rem 1.25rem;
            border-width: 1px;
            border-color: #D1D5DB;
            border-radius: 0.75rem;
            color: #1F2937;
            background-color: #FFFFFF;
            outline: none;
            transition: all 0.3s ease-in-out;
        }

        .form-input-elegent:focus {
            box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.15), 0 0 0 1px #B8860B;
            border-color: #B8860B;
        }

        .form-input-elegent::placeholder {
            color: #9CA3AF;
        }


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

        .whatsapp-float-styled:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .whatsapp-float-styled img {
            width: 32px;
            height: 32px;
            margin-right: 8px;
        }

        /* Custom styling for Flatpickr disabled/available dates */
        .flatpickr-day.flatpickr-disabled {
            background-color: #FEE2E2 !important;
            color: #EF4444 !important;
            text-decoration: line-through;
            opacity: 0.7;
            cursor: not-allowed;
        }

        .flatpickr-day:not(.flatpickr-disabled):not(.flatpickr-day.selected):not(.flatpickr-day.today):not(.nextMonthDay):not(.prevMonthDay) {
            background-color: #D1FAE5;
            color: #059669;
        }

        /* Fix for prev/next month days that are available */
        .flatpickr-day.nextMonthDay:not(.flatpickr-disabled),
        .flatpickr-day.prevMonthDay:not(.flatpickr-disabled) {
            background-color: transparent !important;
            color: #CBD5E0 !important;
        }

        .flatpickr-day.today:not(.flatpickr-disabled) {
            background-color: #BFDBFE !important;
            color: #1D4ED8 !important;
            border-color: #BFDBFE !important;
        }

        .flatpickr-day.today.flatpickr-disabled {
            background-color: #FEE2E2 !important;
            color: #EF4444 !important;
            border-color: #EF4444 !important;
        }

        .flatpickr-day.selected {
            background-color: #B8860B !important;
            border-color: #B8860B !important;
            color: white !important;
        }

        .flatpickr-calendar {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
        }

        .flatpickr-months .flatpickr-month {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        .flatpickr-current-month .flatpickr-monthDropdown-months {
            font-family: 'Playfair Display', serif;
        }

        .flatpickr-weeks {
            margin-top: 1rem;
        }
    </style>

    @stack('styles') {{-- Untuk CSS tambahan dari child views --}}
    @livewireStyles {{-- PENTING: Untuk CSS Livewire --}}
</head>

<body class="bg-gray-50">

    @include('partials.header') {{-- Header Anda --}}

    <main>
        @yield('content') {{-- Konten halaman spesifik --}}
    </main>

    @include('partials.footer') {{-- Footer Anda --}}

    <a href="https://wa.me/6289675704877" target="_blank" class="whatsapp-float-styled" aria-label="Chat via WhatsApp">
        <img src="{{ asset('assets/images/icons/wa1.svg') }}" alt="WhatsApp Icon" class="w-8 h-8 mr-2">
        <span class="font-semibold text-gray-700">WhatsApp us</span>
    </a>

    {{-- Flatpickr JavaScript CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    {{-- Alpine.js CDN (jika digunakan) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('scripts') {{-- Stack untuk JavaScript tambahan dari child views --}}
    @livewireScripts {{-- PENTING: Untuk JavaScript Livewire --}}
    @stack('modals') {{-- PENTING: Untuk modal Jetstream (misal konfirmasi hapus akun) --}}
</body>

</html>
