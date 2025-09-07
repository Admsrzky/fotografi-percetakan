@extends('layouts.master')

@section('title', '| Percetakan ID Card')

@section('content')
    <section class="py-16 bg-gray-100">
        <div class="container px-4 mx-auto text-center">
            <h2 class="mb-12 text-3xl font-bold">Pilih Paket ID Card</h2>
            {{-- Updated grid class for mobile responsiveness --}}
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                @php
                    function displayRichTextAsChecklist($content)
                    {
                        if (empty($content)) {
                            return '';
                        }
                        $htmlDecoded = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
                        $cleaned = preg_replace('/<br\s*\/?>/i', "\n", $htmlDecoded);
                        $cleaned = preg_replace('/<\/?(p|div|ul|ol|li)[^>]*>/i', "\n", $cleaned);
                        $stripped = strip_tags($cleaned);
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
                @endphp

                @forelse($paketIdCard as $paket)
                    <div
                        class="relative overflow-hidden transition-shadow duration-300 transform bg-white rounded-lg shadow-xl hover:scale-105 hover:shadow-2xl">
                        @if ($paket->foto_paket)
                            <div class="relative w-full rounded-t-lg overflow-hidden h-96 sm:h-80 md:h-[32rem]"> {{-- Reduced default height to h-48 (12rem) --}}
                                <img src="{{ asset('storage/' . $paket->foto_paket) }}" alt="Foto Paket {{ $paket->nama_paket }}"
                                    class="object-cover object-center w-full h-full transition duration-500 group-hover:scale-110">
                            </div>
                        @endif
                        <div class="p-4 sm:p-6 md:p-8"> {{-- Reduced padding for smaller screens --}}
                            <h3 class="mb-2 text-xl font-bold sm:text-2xl text-accent">{{ $paket->nama_paket }}</h3> {{-- Adjusted font size --}}
                            <p class="mb-4 text-xs text-gray-600 sm:text-sm line-clamp-2">{{ $paket->deskripsi_paket }}</p> {{-- Added line-clamp to shorten description --}}
                            <ul class="mb-4 space-y-1 text-sm text-left text-gray-700"> {{-- Reduced space and font size for list items --}}
                                {!! displayRichTextAsChecklist($paket->info_durasi) !!}
                                {!! displayRichTextAsChecklist($paket->info_output) !!}
                            </ul>
                            <div class="flex items-baseline justify-center mb-4 font-bold text-gray-900">
                                @if ($paket->harga_paket && is_numeric($paket->harga_paket))
                                    <span class="text-2xl sm:text-3xl">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</span> {{-- Adjusted font size --}}
                                    @if ($paket->jasa && $paket->jasa->tipe_jasa == 'percetakan')
                                        <span class="ml-1 text-sm text-gray-600 sm:text-lg">/ Pcs</span> {{-- Adjusted font size --}}
                                    @endif
                                @else
                                    <span class="text-xl sm:text-2xl">Hubungi Kami</span> {{-- Adjusted font size --}}
                                @endif
                            </div>
                            <a href="{{ route('pemesanan.form', ['jasa_tipe' => $paket->jasa->tipe_jasa, 'paket_id' => $paket->id, 'kategori' => $paket->kategori]) }}"
                                class="inline-block w-full px-4 py-2 text-sm font-semibold text-white transition duration-300 rounded-full shadow-md sm:px-8 sm:py-3 bg-accent hover:bg-accent-dark"> {{-- Reduced padding and font size for button --}}
                                Pesan Paket Ini
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-gray-600 col-span-full">
                        Belum ada paket Paket ID Card yang tersedia saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
