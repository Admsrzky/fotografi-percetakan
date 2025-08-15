@extends('layouts.master')

@section('title', 'Kontak Kami - Studio Foto & Cetak')

@section('content')
    <section class="relative py-20 overflow-hidden bg-gradient-to-br from-blue-50 to-white">
        {{-- Background pattern - optional --}}
        <div class="absolute inset-0 z-0 opacity-20">
            <svg class="w-full h-full" fill="none" viewBox="0 0 100 100">
                <defs>
                    <pattern id="pattern-grid" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <path d="M20 0L0 0L0 20" stroke="#dbeafe" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect x="0" y="0" width="100%" height="100%" fill="url(#pattern-grid)" />
            </svg>
        </div>

        <div class="container relative z-10 px-4 mx-auto">
            <h1 class="mb-12 text-5xl font-extrabold leading-tight text-center text-gray-900">
                Hubungi <span class="text-blue-600">Kami</span>
            </h1>

            <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-2xl p-10 md:p-16 border border-gray-100 transform hover:scale-[1.005] transition-transform duration-300 ease-in-out">
                <div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:gap-16">
                    {{-- Informasi Kontak --}}
                    <div>
                        <h2 class="pb-4 mb-8 text-3xl font-bold text-gray-800 border-b-2 border-blue-200">Informasi Kontak</h2>
                        <div class="space-y-6 text-lg text-gray-700">
                            <p class="flex items-start">
                                <svg class="flex-shrink-0 w-8 h-8 mt-1 mr-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 00.959.69L12 7l-1.683 1.683a2 2 0 00-.593 1.157l-.887 2.126a1.25 1.25 0 001.077 1.614l2.126-.887a2 2 0 001.157-.593L17 12l4-2.583V17a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>
                                <div>
                                    <strong class="block text-gray-900">Telepon & WhatsApp</strong>
                                    <a href="tel:+6281234567890" class="text-blue-600 hover:underline">0896-7570-4877 / re project</a>
                                </div>
                            </p>
                            <p class="flex items-start">
                                <svg class="flex-shrink-0 w-8 h-8 mt-1 mr-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-2 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7l9 6 9-6z"></path></svg>
                                <div>
                                    <strong class="block text-gray-900">Email</strong>
                                    <a href="mailto:info@namastudioanda.com" class="text-blue-600 hover:underline">info@reproject.com</a>
                                </div>
                            </p>
                            <p class="flex items-start">
                                <svg class="flex-shrink-0 w-8 h-8 mt-1 mr-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <div>
                                    <strong class="block text-gray-900">Alamat Studio</strong>
                                    Jl. Luwung Sawo No. 123, Kota Cilegon, Banten, 42411
                                </div>
                            </p>
                            <p class="flex items-start">
                                <svg class="flex-shrink-0 w-8 h-8 mt-1 mr-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>
                                    <strong class="block text-gray-900">Jam Operasional</strong>
                                    <p>Senin - Sabtu: 09.00 - 18.00 WIB</p>
                                </div>
                            </p>
                        </div>
                    </div>

                    {{-- Informasi Pembayaran / Rekening --}}
                    <div>
                        <h2 class="pb-4 mb-8 text-3xl font-bold text-gray-800 border-b-2 border-blue-200">Informasi Pembayaran</h2>
                        <p class="mb-6 text-lg text-gray-700">Untuk kemudahan transaksi pemesanan layanan, Anda dapat melakukan pembayaran melalui rekening bank berikut. Mohon konfirmasi setelah transfer.</p>
                        <div class="p-8 space-y-6 text-lg text-gray-700 border border-blue-100 rounded-lg shadow-inner bg-blue-50">
                            <div class="pb-4 border-b border-blue-200">
                                <p class="text-xl font-semibold text-gray-900">Bank BCA</p>
                                <p><strong>Nomor Rekening:</strong> <span class="font-medium text-blue-700">1234 567 890</span></p>
                                <p><strong>Atas Nama:</strong> Reza Adya Pratama</p>
                            </div>
                            <div class="pb-4 border-b border-blue-200">
                                <p class="text-xl font-semibold text-gray-900">Bank Mandiri</p>
                                <p><strong>Nomor Rekening:</strong> <span class="font-medium text-blue-700">9876 543 210</span></p>
                                <p><strong>Atas Nama:</strong> Reza Adya Pratama</p>
                            </div>
                            <div>
                                <p class="mb-2 text-xl font-semibold text-gray-900">Metode Pembayaran Lainnya:</p>
                                <ul class="ml-4 text-gray-700 list-disc list-inside">
                                    <li>Pembayaran tunai langsung di studio</li>
                                    <li>Pembayaran via QRIS (segera hadir)</li>
                                </ul>
                            </div>
                        </div>
                        <p class="mt-8 text-base italic text-center text-gray-600">
                            Pastikan Anda melakukan transfer ke rekening yang benar dan jangan ragu menghubungi kami jika ada kendala.
                        </p>
                    </div>
                </div>

                {{-- Bagian Formulir Kontak (Opsional, jika ingin menambahkan form) --}}
                {{-- <div class="mt-20">
                    <h2 class="mb-8 text-4xl font-bold text-center text-gray-800">Kirim Pesan kepada Kami</h2>
                    <p class="max-w-2xl mx-auto mb-10 text-lg text-center text-gray-700">
                        Punya pertanyaan atau ingin berdiskusi lebih lanjut? Isi formulir di bawah ini dan kami akan segera menghubungi Anda.
                    </p>
                    <form class="max-w-3xl mx-auto space-y-6">
                        <div>
                            <label for="name" class="block mb-2 font-semibold text-gray-700">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="w-full px-5 py-3 transition-all duration-200 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label for="email" class="block mb-2 font-semibold text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="w-full px-5 py-3 transition-all duration-200 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan email Anda">
                        </div>
                        <div>
                            <label for="subject" class="block mb-2 font-semibold text-gray-700">Subjek</label>
                            <input type="text" id="subject" name="subject" class="w-full px-5 py-3 transition-all duration-200 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Subjek pesan Anda">
                        </div>
                        <div>
                            <label for="message" class="block mb-2 font-semibold text-gray-700">Pesan Anda</label>
                            <textarea id="message" name="message" rows="6" class="w-full px-5 py-3 transition-all duration-200 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="px-10 py-4 font-semibold text-white transition-all duration-300 ease-in-out transform bg-blue-600 rounded-full shadow-lg hover:bg-blue-700 hover:scale-105">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div> --}}

                {{-- Lokasi di Google Maps --}}
                <div class="mt-20">
                    <h2 class="mb-8 text-4xl font-bold text-center text-gray-800">Lokasi Kami</h2>
                    <p class="max-w-2xl mx-auto mb-8 text-lg text-center text-gray-700">
                        Kunjungi studio kami untuk konsultasi langsung atau pengambilan hasil. Kami menantikan kedatangan Anda!
                    </p>
                    <div class="overflow-hidden border border-gray-200 shadow-xl rounded-xl" style="height: 480px; width: 100%;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.5702280261376!2d106.09635297441335!3d-6.077227193910543!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e42211910a33113%3A0xc3b09232938f3259!2sAlun-alun%20Kota%20Cilegon!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                            width="100%" height="480" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
