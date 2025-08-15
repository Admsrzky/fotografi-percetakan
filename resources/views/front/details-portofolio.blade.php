@extends('layouts.master')

@section('title', $portofolio->judul . ' - Detail Portofolio')

@section('content')

    <section class="relative py-16 bg-gray-50 lg:py-16">
        <div class="container px-4 mx-auto">
            <h1 class="mb-12 text-4xl font-extrabold leading-tight text-center text-gray-900 lg:text-5xl">
                {{ $portofolio->judul }}
            </h1>

            <div class="flex flex-col gap-8 lg:flex-row lg:gap-12">
                {{-- Left Section: Images --}}
                <div class="flex flex-col items-center p-4 bg-white border border-gray-100 shadow-lg lg:w-2/3 rounded-xl">
                    {{-- Main Image --}}
                    @if ($portofolio->gambar_utama)
                        <div class="w-full max-w-3xl mb-6">
                            <img src="{{ asset('storage/' . $portofolio->gambar_utama) }}" alt="{{ $portofolio->judul }}"
                                class="rounded-lg shadow-xl w-full h-auto object-contain max-h-[600px]">
                        </div>
                    @endif

                    {{-- Gallery Images (if any) --}}
                    @if ($portofolio->gambar_galeri && count($portofolio->gambar_galeri) > 0)
                        <div class="grid w-full max-w-3xl grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                            @foreach ($portofolio->gambar_galeri as $galleryImage)
                                <img src="{{ asset('storage/' . $galleryImage) }}" alt="Galeri {{ $portofolio->judul }}"
                                    class="object-cover w-full h-32 transition-transform duration-200 rounded-lg shadow-md cursor-pointer md:h-40 hover:scale-105 hover:shadow-lg"
                                    onclick="openLightbox('{{ asset('storage/' . $galleryImage) }}')">
                            @endforeach
                        </div>
                    @else
                        <p class="mt-8 text-lg text-gray-500">Tidak ada gambar galeri tambahan.</p>
                    @endif
                </div>

                {{-- Right Section: Details --}}
                <div class="p-8 bg-white border border-gray-100 shadow-lg lg:w-1/3 rounded-xl">
                    <h2 class="mb-6 text-3xl font-bold text-gray-800">Ringkasan Portofolio</h2>

                    {{-- Kategori --}}
                    <div class="pb-4 mb-6 border-b border-gray-200">
                        <h3 class="flex items-center mb-2 text-xl font-semibold text-gray-700">
                            <i class="mr-3 text-blue-500 fas fa-tags"></i> Kategori
                        </h3>
                        <p class="text-lg text-gray-600">
                            {{ $portofolio->kategori ?: 'Tidak Dikategorikan' }}
                            @if ($portofolio->tahun)
                                <span class="block mt-1 text-base text-gray-500">Tahun Pengerjaan:
                                    {{ $portofolio->tahun }}</span>
                            @endif
                        </p>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="pb-4 mb-8 border-b border-gray-200">
                        <h3 class="flex items-center mb-2 text-xl font-semibold text-gray-700">
                            <i class="mr-3 text-green-500 fas fa-info-circle"></i> Deskripsi
                        </h3>
                        <p class="leading-relaxed text-gray-700 whitespace-pre-wrap">
                            {{ $portofolio->deskripsi ?: 'Belum ada deskripsi lengkap untuk proyek ini.' }}
                        </p>
                    </div>

                    {{-- Contact Button --}}
                    <a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20tertarik%20dengan%20portofolio%20%22{{ urlencode($portofolio->judul) }}%22.%0AMohon%20informasi%20lebih%20lanjut."
                        target="_blank"
                        class="flex items-center justify-center w-full px-6 py-4 text-lg font-bold text-white transition-all duration-300 transform bg-green-600 rounded-lg shadow-md hover:bg-green-700 hover:scale-105">
                        <i class="mr-3 text-xl fab fa-whatsapp"></i> Hubungi Kami via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Lightbox for gallery images (simple example) --}}
    <div id="lightbox" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-80"
        onclick="closeLightbox()">
        <img id="lightbox-img" src="" alt="Lightbox Image" class="max-w-full max-h-[90%] rounded-lg shadow-xl"
            onclick="event.stopPropagation()">
    </div>

@endsection

@push('scripts')
    {{-- Ensure Font Awesome is loaded for icons like fa-tags, fa-info-circle, fa-whatsapp --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40jBliWEaPmmh2HnpGVaLCsI7yUaaV0rX2z32QhGzP5w2hO9r+jG1J2/A/yJ+mO3O/b+w+A="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        // Simple Lightbox functionality for gallery images
        function openLightbox(imageUrl) {
            document.getElementById('lightbox-img').src = imageUrl;
            document.getElementById('lightbox').classList.remove('hidden');
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.getElementById('lightbox-img').src = ''; // Clear image to save memory
        }

        // Optional: Close lightbox with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('lightbox').classList.contains('hidden')) {
                closeLightbox();
            }
        });
    </script>
@endpush
