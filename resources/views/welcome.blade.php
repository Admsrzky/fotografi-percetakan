@extends('layouts.master')

@section('title', 'Beranda - Studio Foto & Cetak')

@section('content')
    {{-- Bagian Hero Section --}}
    <section
        class="relative flex items-center justify-center text-center text-white overflow-hidden
            h-[256px] md:h-[320px] max-w-7xl mx-auto
            lg:h-[600px] lg:mx-0 lg:max-w-none lg:rounded-none">
        <img src="{{ asset('assets/images/carousel1.jpg') }}" alt="Hero Background"
            class="absolute inset-0 object-contain w-full h-full lg:object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
        <div class="relative z-10 p-4">
            <h1 class="mb-2 text-2xl font-bold text-white md:text-3xl drop-shadow-lg lg:text-5xl">
                Abadikan Moment Berharga dan Harga Terjaga
            </h1>
            <p class="text-sm md:text-base opacity-90 drop-shadow-md lg:text-xl">
                Lihatlah harga dan karya yang telah kami abadikan dengan passion dan profesionalisme.
            </p>
        </div>
    </section>

    {{-- Bagian Why Choose Us Section (Tetap sama) --}}
    <section id="tentang" class="py-16 bg-white">
        <div class="container px-4 mx-auto text-center">
            <h2 class="mb-12 text-4xl font-bold">Mengapa Memilih Kami?</h2>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="p-8 transition duration-300 bg-gray-100 rounded-lg shadow-sm hover:shadow-md">
                    <div class="mb-4 text-accent">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-2xl font-semibold">Fotografer Berpengalaman</h3>
                    <p class="text-gray-600">Tim kami terdiri dari fotografer profesional dengan pengalaman
                        bertahun-tahun dalam mengabadikan setiap detail.</p>
                </div>
                <div class="p-8 transition duration-300 bg-gray-100 rounded-lg shadow-sm hover:shadow-md">
                    <div class="mb-4 text-accent">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.002 2.002A3.004 3.004 0 0118 7.994V10c0 .414.168.814.464 1.109l.48.48A.997.997 0 0120 12.001v2c0 .265-.105.52-.293.707l-1.414 1.414A.997.997 0 0118.001 17h-2c-.265 0-.52-.105-.707-.293l-1.414-1.414A.997.997 0 0114 14.001v-2c0-.414-.168-.814-.464-1.109l-.48-.48A.997.997 0 0112.001 9H10c-.265 0-.52-.105-.707-.293l-1.414-1.414A.997.997 0 018.001 5H6c-.265 0-.52-.105-.707-.293l-1.414-1.414A.997.997 0 014.001 2H2c-.265 0-.52-.105-.707-.293l-1.414-1.414A.997.997 0 010 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-2xl font-semibold">Hasil Berkualitas Tinggi</h3>
                    <p class="text-gray-600">Kami menjamin kualitas foto dan cetakan terbaik dengan peralatan canggih
                        dan teknik editing modern.</p>
                </div>
                <div class="p-8 transition duration-300 bg-gray-100 rounded-lg shadow-sm hover:shadow-md">
                    <div class="mb-4 text-accent">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21H6.737a2 2 0 01-1.789-2.894l3.5-7A2 2 0 019.236 10H14zm-4 0v7m-3-7v7">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mb-3 text-2xl font-semibold">Pelayanan Prima</h3>
                    <p class="text-gray-600">Kepuasan klien adalah prioritas kami. Kami siap mendengarkan kebutuhan dan
                        memberikan solusi terbaik.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- START: Bagian LAYANAN KAMI yang Diperbarui --}}
    <section id="layanan" class="py-16 bg-gray-100">
        <div class="container px-4 mx-auto text-center">
            <h2 class="mb-12 text-4xl font-bold">Layanan Kami</h2>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2"> {{-- Grid 2 kolom untuk 2 layanan --}}
                @forelse($jasas as $jasa)
                    <div id="{{ $jasa->slug }}"
                        class="overflow-hidden transition duration-300 transform bg-white rounded-lg shadow-lg hover:scale-105">
                        <img src="{{ asset('storage/' . $jasa->gambar_jasa) }}" alt="{{ $jasa->nama_jasa }}"
                            class="object-cover w-full h-64">
                        <div class="p-6">
                            <h3 class="mb-2 text-2xl font-semibold">{{ $jasa->nama_jasa }}</h3>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center col-span-full">
                        <p class="text-gray-600">Belum ada layanan utama yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    {{-- END: Bagian LAYANAN KAMI yang Diperbarui --}}

    {{-- Bagian Portofolio Pilihan Kami (Tetap sama) --}}
    <section id="portofolio" class="py-16 bg-white">
        <div class="container px-4 mx-auto text-center">
            <h2 class="mb-12 text-4xl font-bold">Portofolio Pilihan Kami</h2>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($portofolios as $portofolio)
                    <div class="relative overflow-hidden rounded-lg shadow-md group">
                        <img src="{{ asset('storage/' . $portofolio->gambar_utama) }}" alt="{{ $portofolio->judul }}"
                            class="object-cover w-full transition-transform duration-300 h-72 group-hover:scale-105">
                        <div
                            class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100">
                            <p class="text-xl font-semibold text-white">{{ $portofolio->judul }}</p>
                        </div>
                        <a href="{{ route('portofolio.show', $portofolio->id) }}" class="absolute inset-0 z-10"
                            aria-label="Lihat detail portofolio {{ $portofolio->judul }}"></a>
                    </div>
                @empty
                    <div class="py-10 text-center col-span-full">
                        <p class="text-gray-600">Belum ada portofolio yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
            <a href="{{ route('portofolio.index') }}"
                class="inline-block px-8 py-3 mt-10 font-semibold text-gray-800 transition duration-300 bg-gray-200 rounded-full hover:bg-gray-300">
                Lihat Semua Portofolio
            </a>
        </div>
    </section>
@endsection
