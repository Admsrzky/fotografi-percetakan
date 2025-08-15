<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function paketwedding()
    {
        $jasaFotografi = Jasa::where('slug', 'fotografi')->first();

        $paketwedding = collect();

        if ($jasaFotografi) {
            $paketwedding = Paket::where('aktif', true)
                ->where('jasa_id', $jasaFotografi->id)
                ->where('kategori', 'wedding')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.fotografi.paket-wedding', compact('paketwedding'));
    }

    public function paketprewedding()
    {
        $jasaFotografi = Jasa::where('slug', 'fotografi')->first();

        $paketprewedding = collect();

        if ($jasaFotografi) {
            $paketprewedding = Paket::where('aktif', true)
                ->where('jasa_id', $jasaFotografi->id)
                ->where('kategori', 'prewedding')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.fotografi.paket-prewedding', compact('paketprewedding'));
    }

    public function paketsekolah()
    {
        $jasaFotografi = Jasa::where('slug', 'fotografi')->first();

        $paketsekolah = collect();

        if ($jasaFotografi) {
            $paketsekolah = Paket::where('aktif', true)
                ->where('jasa_id', $jasaFotografi->id)
                ->where('kategori', 'photosekolah')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.fotografi.paket-photosekolah', compact('paketsekolah'));
    }

    public function paketAllEvent()
    {
        $jasaFotografi = Jasa::where('slug', 'fotografi')->first();

        $paketAllEvent = collect();

        if ($jasaFotografi) {
            $paketAllEvent = Paket::where('aktif', true)
                ->where('jasa_id', $jasaFotografi->id)
                ->where('kategori', 'allevent')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.fotografi.paket-allevent', compact('paketAllEvent'));
    }

    public function paketVidioCinematic()
    {
        $jasaVidio = Jasa::where('slug', 'fotografi')->first();

        $paketVidioCinematic = collect();

        if ($jasaVidio) {
            $paketVidioCinematic = Paket::where('aktif', true)
                ->where('jasa_id', $jasaVidio->id)
                ->where('kategori', 'videocinematic')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.fotografi.paket-vidiocinematic', compact('paketVidioCinematic'));
    }

    public function paketVidioLiputan()
    {
        $jasaVidio = Jasa::where('slug', 'fotografi')->first();

        $paketVidioLiputan = collect();

        if ($jasaVidio) {
            $paketVidioLiputan = Paket::where('aktif', true)
                ->where('jasa_id', $jasaVidio->id)
                ->where('kategori', 'videoliputan')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.fotografi.paket-vidioliputan', compact('paketVidioLiputan'));
    }

    // Bagian Percetakan

    public function cetakIdCard()
    {
        $jasaPercetakan = Jasa::where('slug', 'percetakan')->first();

        $paketIdCard = collect();

        if ($jasaPercetakan) {
            $paketIdCard = Paket::where('aktif', true)
                ->where('jasa_id', $jasaPercetakan->id)
                ->where('kategori', 'cetakidcard')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.percetakan.paket-idcard', compact('paketIdCard'));
    }

    public function cetakFoto()
    {
        $jasaPercetakan = Jasa::where('slug', 'percetakan')->first();

        $paketCetakFoto = collect();

        if ($jasaPercetakan) {
            $paketCetakFoto = Paket::where('aktif', true)
                ->where('jasa_id', $jasaPercetakan->id)
                ->where('kategori', 'cetakfoto')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.percetakan.paket-cetakfoto', compact('paketCetakFoto'));
    }

    public function cetakMIR()
    {
        $jasaPercetakan = Jasa::where('slug', 'percetakan')->first();

        $paketMIR = collect();

        if ($jasaPercetakan) {
            $paketMIR = Paket::where('aktif', true)
                ->where('jasa_id', $jasaPercetakan->id)
                ->where('kategori', 'mapijazahraport')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.percetakan.paket-MIR', compact('paketMIR'));
    }

    public function medaliSekolah()
    {
        $jasaPercetakan = Jasa::where('slug', 'percetakan')->first();

        $paketMedaliSekolah = collect();

        if ($jasaPercetakan) {
            $paketMedaliSekolah = Paket::where('aktif', true)
                ->where('jasa_id', $jasaPercetakan->id)
                ->where('kategori', 'medalisekolah')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.percetakan.paket-medalisekolah', compact('paketMedaliSekolah'));
    }

    public function cetakJenisBuku()
    {
        $jasaPercetakan = Jasa::where('slug', 'percetakan')->first();

        $paketJenisBuku = collect();

        if ($jasaPercetakan) {
            $paketJenisBuku = Paket::where('aktif', true)
                ->where('jasa_id', $jasaPercetakan->id)
                ->where('kategori', 'cetakjenisbuku')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.percetakan.paket-cetakbuku', compact('paketJenisBuku'));
    }

    public function cetakStikerLabel()
    {
        $jasaPercetakan = Jasa::where('slug', 'percetakan')->first();

        $paketStikerLabel = collect();

        if ($jasaPercetakan) {
            $paketStikerLabel = Paket::where('aktif', true)
                ->where('jasa_id', $jasaPercetakan->id)
                ->where('kategori', 'cetakstikerlabel')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.percetakan.paket-cetakstiker', compact('paketStikerLabel'));
    }

    public function cetakKalender()
    {
        $jasaPercetakan = Jasa::where('slug', 'percetakan')->first();

        $paketKalender = collect();

        if ($jasaPercetakan) {
            $paketKalender = Paket::where('aktif', true)
                ->where('jasa_id', $jasaPercetakan->id)
                ->where('kategori', 'cetakkalender')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.percetakan.paket-cetakkalender', compact('paketKalender'));
    }

    public function bingkaiFoto()
    {
        $jasaPercetakan = Jasa::where('slug', 'percetakan')->first();

        $paketBingkaiFoto = collect();

        if ($jasaPercetakan) {
            $paketBingkaiFoto = Paket::where('aktif', true)
                ->where('jasa_id', $jasaPercetakan->id)
                ->where('kategori', 'bingkaifoto')
                ->orderBy('urutan_tampil', 'asc')
                ->get();
        }
        return view('paket.percetakan.paket-bingkaifoto', compact('paketBingkaiFoto'));
    }
}
