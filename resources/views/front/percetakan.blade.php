@extends('layouts.master')

@section('title', '| Jasa Percetakan - Studio Foto & Cetak')

@section('content')
    <section class="relative flex items-center justify-center overflow-hidden text-center text-white h-96">
        <img src="{{ asset('assets/images/carousel-percetakan.jpg') }}" alt="Percetakan Hero"
            class="absolute inset-0 object-cover w-full h-full opacity-80">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
        <div class="relative z-10 p-4">
            <h1 class="mb-3 text-4xl font-bold md:text-5xl drop-shadow-lg">Layanan Percetakan Profesional</h1>
            <p class="text-lg md:text-xl opacity-90 drop-shadow-md">Kualitas cetak terbaik untuk kebutuhan pribadi dan bisnis
                Anda.</p>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container max-w-3xl px-4 mx-auto text-center">
            <h2 class="mb-6 text-3xl font-bold">Solusi Cetak Lengkap untuk Setiap Kebutuhan</h2>
            <p class="mb-6 leading-relaxed text-gray-700">Kami menyediakan berbagai layanan percetakan untuk mendukung
                kebutuhan personal, profesional, maupun acara Anda. Dari ID card yang praktis, buku tahunan yang berkesan,
                medali dan plakat penghargaan, hingga cetak foto berkualitas tinggi, kami berkomitmen memberikan hasil cetak
                terbaik dengan detail dan ketepatan warna yang optimal.</p>
            <p class="leading-relaxed text-gray-700">Dengan teknologi cetak modern dan tim ahli, kami siap membantu Anda
                mewujudkan desain menjadi produk cetak nyata. Jelajahi pilihan layanan percetakan kami di bawah ini.</p>
        </div>
    </section>

    <section class="py-16 bg-gray-100">
        <div class="container px-4 mx-auto text-center">
            <h2 class="mb-12 text-3xl font-bold">Pilihan Layanan Percetakan</h2>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                @php
                    // Define the helper function once
                    function displayRichTextAsChecklist($content)
                    {
                        if (empty($content)) {
                            return '';
                        }

                        // Convert HTML entities (like &nbsp;) to actual characters
                        $htmlDecoded = html_entity_decode($content, ENT_QUOTES, 'UTF-8');

                        // Replace <br> tags with newlines
                    $cleaned = preg_replace('/<br\s*\/@endphp/i', "\n", $htmlDecoded);

    // Replace block-level tags with newlines to ensure proper splitting
    $cleaned = preg_replace('/<\/?(p|div|ul|ol|li)[^>]*>/i', "\n", $cleaned);

    // Strip any remaining HTML tags
    $stripped = strip_tags($cleaned);

    // Split by newline and filter out empty lines
    $lines = array_filter(explode("\n", $stripped), 'trim');

    $output = '';
    foreach ($lines as $line) {
        $output .= '<li class="flex items-center">';
        $output .=
            '<svg class="flex-shrink-0 w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">';
        $output .=
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
        $output .= '</svg>';
        $output .= '<span>' . trim($line) . '</span>';
        $output .= '</li>';
    }
    return $output;
}
?>

                @forelse($layanan_percetakan as $paket)
                    <div
                        class="flex flex-col justify-between p-8 transition duration-300 transform bg-white shadow-lg rounded-xl hover:scale-105">
                        <div>
                            <h3 class="mb-4 text-2xl font-bold text-accent">{{ $paket->nama_paket }}</h3>
                            <p class="mb-6 text-sm text-gray-600">{{ $paket->deskripsi_paket }}</p>

                            <ul class="mb-6 space-y-2 text-sm text-left text-gray-700">
                                {{-- Tampilkan info_durasi dengan ceklis (jika ada) --}}
                                {!! displayRichTextAsChecklist($paket->info_durasi) !!}

                                {{-- Tampilkan info_output dengan ceklis --}}
                                {!! displayRichTextAsChecklist($paket->info_output) !!}
                            </ul>
                        </div>

                        {{-- Bagian Harga --}}
                        <div class="mt-auto">
                            <div class="mb-4 text-3xl font-bold text-gray-800">
                                @if ($paket->harga_paket && is_numeric($paket->harga_paket))
                                    Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                                    @if ($paket->jasa && $paket->jasa->tipe_jasa == 'percetakan')
                                        <span class="text-lg text-gray-600">/ Pcs</span>
                                    @endif
                                @else
                                    <span class="text-2xl">Hubungi Kami</span>
                                @endif
                            </div>
                            <a href="{{ url('/#kontak') }}"
                                class="inline-block w-full px-8 py-3 font-semibold text-white transition duration-300 rounded-full shadow-md bg-accent hover:bg-accent-dark">
                                Pesan Layanan Ini
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-gray-600 col-span-full">
                        Belum ada layanan percetakan yang tersedia saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
