@extends('layouts.master')

@section('title', '| Wedding Photography')

@section('content')
    <section class="py-16 bg-gray-100">
        <div class="container px-4 mx-auto text-center">
            <h2 class="mb-12 text-3xl font-bold">Pilih Paket Wedding Impian Anda</h2>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                @php
                    // Define the helper function once for this view
                    function displayRichTextAsChecklist($content)
                    {
                        if (empty($content)) {
                            return '';
                        }
                        $htmlDecoded = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
                    $cleaned = preg_replace('/<br\s*\/@endphp/i', "\n", $htmlDecoded);
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
?>

                @forelse($paketBingkaiFoto as $paket)
                    <div
                        class="p-8 transition duration-300 transform bg-white rounded-lg shadow-lg hover:scale-105
                        {{ $paket->nama_paket == 'Paket Harmoni' ? 'border-2 border-accent' : '' }}">
                        <h3 class="mb-4 text-2xl font-bold text-accent">{{ $paket->nama_paket }}</h3>
                        <p class="mb-6 text-gray-600">{{ $paket->deskripsi_paket }}</p>
                        <ul class="mb-6 space-y-2 text-left text-gray-700">
                            {!! displayRichTextAsChecklist($paket->info_durasi) !!}
                            {!! displayRichTextAsChecklist($paket->info_output) !!}
                        </ul>
                        <div class="mb-4 text-3xl font-bold">
                            @if ($paket->harga_paket && is_numeric($paket->harga_paket))
                                Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}
                                @if ($paket->jasa && $paket->jasa->tipe_jasa == 'percetakan')
                                    <span class="text-lg text-gray-600">/ Pcs</span>
                                @endif
                            @else
                                <span class="text-2xl">Hubungi Kami</span>
                            @endif
                        </div>
                        <a href="{{ route('pemesanan.form', ['jasa_tipe' => $paket->jasa->tipe_jasa, 'paket_id' => $paket->id, 'kategori' => $paket->kategori]) }}"
                            class="px-8 py-3 font-semibold text-white transition duration-300 rounded-full shadow-md bg-accent hover:bg-accent-dark">
                            Pesan Paket Ini
                        </a>
                    </div>
                @empty
                    <div class="py-10 text-center text-gray-600 col-span-full">
                        Belum ada paket wedding yang tersedia saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>


@endsection
