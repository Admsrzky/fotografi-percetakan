@extends('layouts.master')

@section('title', $portofolio->judul . ' - Detail Portofolio')

@section('content')

    <section class="py-8 bg-gray-50 md:py-16">
        <div class="container px-4 mx-auto">

            <h1 class="mb-8 text-3xl font-extrabold leading-tight text-center text-gray-900 md:text-5xl md:mb-12">
                {{ $portofolio->judul }}
            </h1>

            <div class="flex flex-col gap-6 lg:flex-row lg:gap-10">

                <div class="flex flex-col items-center flex-1 p-4 bg-white border border-gray-100 shadow-xl lg:p-8 rounded-xl">
                    @if ($portofolio->gambar_utama)
                        <div class="w-full mb-6 max-h-[600px] overflow-hidden rounded-lg">
                            <img src="{{ asset('storage/' . $portofolio->gambar_utama) }}" alt="{{ $portofolio->judul }}"
                                class="object-contain w-full h-auto transition-transform duration-300 transform rounded-lg hover:scale-105">
                        </div>
                    @endif

                    @if ($portofolio->gambar_galeri && count($portofolio->gambar_galeri) > 0)
                        <div class="grid w-full grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                            @foreach ($portofolio->gambar_galeri as $galleryImage)
                                <img src="{{ asset('storage/' . $galleryImage) }}" alt="Galeri {{ $portofolio->judul }}"
                                    class="object-cover w-full h-32 transition-transform duration-200 rounded-lg shadow-md cursor-pointer md:h-40 hover:scale-105 hover:shadow-lg"
                                    onclick="openLightbox('{{ asset('storage/' . $galleryImage) }}')">
                            @endforeach
                        </div>
                    @else
                        <p class="mt-2 text-lg text-gray-500"></p>
                    @endif
                </div>

                <div class="w-full lg:w-1/3">
                    <div class="sticky flex flex-col h-full p-4 bg-white border border-gray-200 shadow-xl top-20 md:p-8 rounded-xl">

                        <h2 class="pb-4 mb-4 text-2xl font-bold text-gray-800 border-b md:text-3xl">Ringkasan Portofolio</h2>

                        <div class="flex flex-col gap-6">

                            <div class="flex flex-col">
                                <h3 class="flex items-center mb-2 text-xl font-semibold text-gray-700">
                                    <i class="text-blue-500 fas fa-tags"></i>Kategori
                                </h3>
                                <p class="text-lg text-left text-gray-600">
                                    {{ $portofolio->kategori ?: 'Tidak Dikategorikan' }}
                                </p>
                                @if ($portofolio->tahun)
                                    <p class="mt-1 text-base text-left text-gray-500">
                                        Tahun Pengerjaan: {{ $portofolio->tahun }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex flex-col">
                                <h3 class="flex items-center mb-2 text-xl font-semibold text-gray-700">
                                    <i class="text-green-500 fas fa-info-circle"></i>Deskripsi
                                </h3>
                                <p class="text-left text-gray-700 md:text-left">
                                    {{ $portofolio->deskripsi ?: 'Belum ada deskripsi lengkap untuk proyek ini.' }}
                                </p>
                            </div>

                        </div>

                        <div class="pt-6 mt-auto">
                            <a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20tertarik%20dengan%20portofolio%20%22{{ urlencode($portofolio->judul) }}%22.%0AMohon%20informasi%20lebih%20lanjut."
                                target="_blank"
                                class="flex items-center justify-center w-full px-6 py-4 text-lg font-bold text-white transition-all duration-300 transform bg-green-600 rounded-lg shadow-md hover:bg-green-700 hover:scale-105">
                                <i class="mr-3 text-xl fab fa-whatsapp"></i> Hubungi Kami via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="lightbox" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-80"
        onclick="closeLightbox()">
        <img id="lightbox-img" src="" alt="Lightbox Image" class="max-w-full max-h-[90%] rounded-lg shadow-xl"
            onclick="event.stopPropagation()">
    </div>

@endsection

@push('scripts')
    {{-- Ensure Font Awesome is loaded --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40jBliWEaPmmh2HnpGVaLCsI7yUaaV0rX2z32QhGzP5w2hO9r+jG1J2/A/yJ+mO3O/b+w+A="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        function openLightbox(imageUrl) {
            document.getElementById('lightbox-img').src = imageUrl;
            document.getElementById('lightbox').classList.remove('hidden');
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.getElementById('lightbox-img').src = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('lightbox').classList.contains('hidden')) {
                closeLightbox();
            }
        });
    </script>
@endpush
