<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Kontak - Studio Foto & Cetak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js"></script>
    <style>
        body {
            padding-bottom: 4rem; /* Agar konten tidak tertutup nav bar */
        }
        .active-nav-link {
            color: #1a202c;
        }
    </style>
</head>
<body class="bg-gray-100">

    {{-- HEADER (Tampilan Mobile) --}}
    <div class="flex items-center justify-between p-4 bg-white shadow-sm">
        <a href="{{ route('akun') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <h1 class="text-xl font-semibold text-gray-800">Informasi Kontak</h1>
        <div class="w-6 h-6"></div>
    </div>

    {{-- KONTEN UTAMA --}}
    <section class="py-8">
        <div class="container px-4 mx-auto">
            <div class="space-y-4" x-data="{
                showContactInfo: false,
                showPaymentInfo: false,
                showAddress: false,
                showWorkingHours: false
            }">

                {{-- Menu Informasi Kontak --}}
                <a href="#" @click.prevent="showContactInfo = !showContactInfo; showPaymentInfo = false; showAddress = false; showWorkingHours = false;" class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm">
                    <div class="flex items-center space-x-4">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-2 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7l9 6 9-6z"></path>
                        </svg>
                        <span class="font-medium text-gray-700">Informasi Kontak</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <div x-show="showContactInfo" x-collapse.duration.500ms>
                    <div class="p-6 mt-2 rounded-lg bg-gray-50 md:p-8">
                        <p class="text-sm"><strong>Telepon & WhatsApp:</strong> <a href="tel:+6289521003170" class="text-blue-600 hover:underline">0896-7570-4877 / re project</a></p>
                        <p class="mt-2 text-sm"><strong>Email:</strong> <a href="mailto:reproject@gmail.com" class="text-blue-600 hover:underline">reproject@gmail.com</a></p>
                    </div>
                </div>

                {{-- Menu Informasi Pembayaran --}}
                <a href="#" @click.prevent="showPaymentInfo = !showPaymentInfo; showContactInfo = false; showAddress = false; showWorkingHours = false;" class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm">
                    <div class="flex items-center space-x-4">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span class="font-medium text-gray-700">Informasi Pembayaran</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <div x-show="showPaymentInfo" x-collapse.duration.500ms>
                    <div class="p-6 mt-2 rounded-lg bg-gray-50 md:p-8">
                        <p class="text-sm">Untuk kemudahan transaksi pemesanan layanan, Anda dapat melakukan pembayaran melalui rekening bank berikut:</p>
                        <div class="p-4 mt-4 rounded-lg bg-blue-50">
                            <p class="text-sm font-semibold">Bank BNI</p>
                            <p class="text-sm"><strong>Nomor Rekening:</strong> <span class="text-blue-700">847421903</span></p>
                            <p class="text-sm"><strong>Atas Nama:</strong> Reza Adya Pratama</p>
                        </div>
                    </div>
                </div>

                {{-- Menu Alamat Studio --}}
                <a href="#" @click.prevent="showAddress = !showAddress; showContactInfo = false; showPaymentInfo = false; showWorkingHours = false;" class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm">
                    <div class="flex items-center space-x-4">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium text-gray-700">Alamat Studio</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <div x-show="showAddress" x-collapse.duration.500ms>
                    <div class="p-6 mt-2 rounded-lg bg-gray-50 md:p-8">
                        <p class="text-sm">Jl. Luwung Sawo, Kota Cilegon, Banten, 42411</p>
                        <div class="mt-4 overflow-hidden border border-gray-200 rounded-lg shadow-xl" style="height: 300px; width: 100%;">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.5702280261376!2d106.09635297441335!3d-6.077227193910543!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e42211910a33113%3A0xc3b09232938f3259!2sAlun-alun%20Kota%20Cilegon!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>

                {{-- Menu Jam Operasional --}}
                <a href="#" @click.prevent="showWorkingHours = !showWorkingHours; showContactInfo = false; showPaymentInfo = false; showAddress = false;" class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm">
                    <div class="flex items-center space-x-4">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium text-gray-700">Jam Operasional</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <div x-show="showWorkingHours" x-collapse.duration.500ms>
                    <div class="p-6 mt-2 rounded-lg bg-gray-50 md:p-8">
                        <p class="text-sm">Senin - Sabtu: 09.00 - 18.00 WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
            <a href="{{ route('akun') }}" class="flex flex-col items-center justify-center flex-grow text-gray-500 transition duration-300 hover:text-gray-900">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-xs">Akun</span>
            </a>
        </div>
    </nav>
</body>
</html>
