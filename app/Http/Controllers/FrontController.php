<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\Paket;
use App\Models\Pemesanan;
use App\Models\Portofolio; // Import model Portofolio
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FrontController extends Controller
{
    public function index()
    {
        $jasas = Jasa::where('aktif', true)->get();

        $portofolios = Portofolio::where('unggulan', true)->get();

        return view('welcome', compact('jasas', 'portofolios'));
    }

    public function listPortofolios()
    {
        $allPortofolios = Portofolio::orderBy('tahun', 'asc')->get();

        $portofoliosGrouped = Portofolio::orderBy('tahun', 'asc')
            ->get()
            ->groupBy('kategori');


        $categoriesFilter = $portofoliosGrouped->keys()->sort()->values()->all();


        return view('front.portofolio', compact('allPortofolios', 'portofoliosGrouped', 'categoriesFilter'));
    }

    public function detailPortofolio($id)
    {
        $portofolio = Portofolio::findOrFail($id);
        return view('front.details-portofolio', compact('portofolio'));
    }

    public function TentangKami()
    {
        return view('front.about');
    }

    public function Kontak()
    {
        return view('front.contact');
    }

    public function showSuccessPage(Request $request)
    {
        // Ambil data dari query parameters
        $pemesananId = $request->query('pemesanan_id');
        $totalHarga = $request->query('total_harga');
        $dpAmount = $request->query('dp_amount');
        $remainingPayment = $request->query('remaining_payment');
        $kategori = $request->query('kategori');

        // Opsional: Ambil objek Pemesanan dari database jika Anda butuh lebih banyak detail
        $pemesanan = null;
        if ($pemesananId) {
            $pemesanan = Pemesanan::find($pemesananId);
        }

        return view('order.pemesanan-success', compact('pemesanan', 'totalHarga', 'dpAmount', 'remainingPayment', 'kategori'));
    }

    // Metode untuk menampilkan riwayat pemesanan
    public function history()
    {
        // Pastikan hanya pengguna yang login yang bisa melihat riwayatnya
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat riwayat pemesanan.');
        }

        $user_id_logged_in = Auth::id();
        $pemesanans = Pemesanan::where('pengguna_id', $user_id_logged_in) // Menggunakan 'pengguna_id'
            ->with(['pengguna', 'jasa', 'paket']) // Muat relasi 'pengguna', 'jasa', dan 'paket'
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10); // Tambahkan pagination

        return view('order.history', compact('pemesanans'));
    }
}
