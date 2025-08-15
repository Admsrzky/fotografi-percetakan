@extends('layouts.master')

@section('title', 'Portofolio Kami - Studio Foto & Cetak')

@section('content')

    <section class="relative flex items-center justify-center overflow-hidden text-center text-white h-96">
        <img src="{{ asset('assets/images/carousel1.jpg') }}" alt="Portfolio Hero"
            class="absolute inset-0 object-cover w-full h-full opacity-80">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
        <div class="relative z-10 p-4">
            <h1 class="mb-3 text-4xl font-bold text-white md:text-5xl drop-shadow-lg">Koleksi Terbaik Kami</h1>
            <p class="text-lg md:text-xl opacity-90 drop-shadow-md">Lihatlah hasil karya yang telah kami abadikan dengan
                passion dan profesionalisme.</p>
        </div>
    </section>

    <section class="py-8 bg-gray-100">
        <div class="container px-4 mx-auto text-center">
            <div class="flex flex-wrap justify-center gap-4 animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                {{-- "Semua" button - ALWAYS active on load --}}
                <button
                    class="px-6 py-2 font-medium text-gray-700 transition-colors duration-200 bg-white rounded-full shadow-md tab-button hover:bg-gray-100 focus:outline-none active-tab"
                    data-category="all">
                    Semua
                </button>

                {{-- Dynamic Category Buttons from Database --}}
                @foreach ($portofoliosGrouped as $categoryName => $items)
                    <button
                        class="px-6 py-2 font-medium text-gray-700 transition-colors duration-200 bg-white rounded-full shadow-md tab-button hover:bg-gray-100 focus:outline-none"
                        data-category="{{ Str::slug($categoryName) }}">
                        {{ $categoryName }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container px-4 mx-auto">

            {{-- "All" Content Section - VISIBLE by default --}}
            <div id="all-content"
                class="grid grid-cols-1 gap-6 tab-content md:grid-cols-2 lg:grid-cols-3 animate__animated animate__fadeInUp"
                data-wow-delay="0.1s">
                @forelse ($allPortofolios as $portofolio)
                    <div class="overflow-hidden bg-white rounded-lg shadow-md group">
                        {{-- Image, clickable to detail page --}}
                        <a href="{{ route('portofolio.show', $portofolio->id) }}" class="block">
                            <img class="object-cover w-full h-64 transition-transform duration-300 group-hover:scale-105"
                                src="{{ asset('storage/' . $portofolio->gambar_utama) }}" alt="{{ $portofolio->judul }}" />
                        </a>

                        {{-- Title and Category --}}
                        <div class="p-4">
                            <h3 class="mb-2 text-xl font-semibold text-gray-800">
                                <a href="{{ route('portofolio.show', $portofolio->id) }}"
                                    class="transition-colors duration-200 hover:text-primary-600">
                                    {{ $portofolio->judul }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-500">{{ $portofolio->kategori_portofolio }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-600 col-span-full">Belum ada portofolio yang tersedia saat ini.</p>
                @endforelse
            </div>

            {{-- Dynamic Category Content Sections - HIDDEN by default --}}
            @foreach ($portofoliosGrouped as $categoryName => $portofolios)
                <div id="{{ Str::slug($categoryName) }}-content"
                    class="grid hidden grid-cols-1 gap-6 tab-content md:grid-cols-2 lg:grid-cols-3 animate__animated animate__fadeInUp"
                    data-wow-delay="0.1s">
                    @forelse ($portofolios as $portofolio)
                        <div class="overflow-hidden bg-white rounded-lg shadow-md group">
                            {{-- Image, clickable to detail page --}}
                            <a href="{{ route('portofolio.show', $portofolio->id) }}" class="block">
                                <img class="object-cover w-full h-64 transition-transform duration-300 group-hover:scale-105"
                                    src="{{ asset('storage/' . $portofolio->gambar_utama) }}"
                                    alt="{{ $portofolio->judul }}" />
                            </a>

                            {{-- Title and Category --}}
                            <div class="p-4">
                                <h3 class="mb-2 text-xl font-semibold text-gray-800">
                                    <a href="{{ route('portofolio.show', $portofolio->id) }}"
                                        class="transition-colors duration-200 hover:text-primary-600">
                                        {{ $portofolio->judul }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-500">{{ $portofolio->kategori_portofolio }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-600 col-span-full">No portofolio found in this category.</p>
                    @endforelse
                </div>
            @endforeach

            {{-- Hardcoded "Jasa Percetakan" content section - HIDDEN by default --}}
            <div id="jasa-percetakan-content"
                class="grid hidden grid-cols-1 gap-6 tab-content md:grid-cols-2 lg:grid-cols-3 animate__animated animate__fadeInUp"
                data-wow-delay="0.1s">
                <p class="py-10 text-center text-gray-600 col-span-full">
                    Portofolio untuk Jasa Percetakan akan segera ditambahkan! Mohon kembali lagi nanti.
                </p>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    tabButtons.forEach(btn => btn.classList.remove('active-tab'));
                    // Add active class to clicked button
                    this.classList.add('active-tab');

                    const category = this.dataset.category;

                    // Hide all tab contents
                    tabContents.forEach(content => content.classList.add('hidden'));

                    // Show the corresponding tab content
                    document.getElementById(category + '-content').classList.remove('hidden');
                });
            });
        });
    </script>
@endpush
