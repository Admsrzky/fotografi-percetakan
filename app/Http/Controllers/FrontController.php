<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\Paket;
use App\Models\Pemesanan;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    /**
     * Display the homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $jasas = Jasa::where('aktif', true)->get();
        $portofolios = Portofolio::where('unggulan', true)->get();

        return view('welcome', compact('jasas', 'portofolios'));
    }

    /**
     * Display the list of portfolios.
     *
     * @return \Illuminate\View\View
     */
    public function listPortofolios()
    {
        $allPortofolios = Portofolio::orderBy('tahun', 'asc')->get();
        $portofoliosGrouped = $allPortofolios->groupBy('kategori');
        $categoriesFilter = $portofoliosGrouped->keys()->sort()->values()->all();

        return view('front.portofolio', compact('allPortofolios', 'portofoliosGrouped', 'categoriesFilter'));
    }

    /**
     * Display the detail of a single portfolio.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function detailPortofolio($id)
    {
        $portofolio = Portofolio::findOrFail($id);
        return view('front.details-portofolio', compact('portofolio'));
    }

    /**
     * Display the "About Us" page.
     *
     * @return \Illuminate\View\View
     */
    public function TentangKami()
    {
        return view('front.about');
    }

    /**
     * Display the "Contact Us" page.
     *
     * @return \Illuminate\View\View
     */
    public function Kontak()
    {
        return view('front.contact');
    }
    public function Informasikontak()
    {
        return view('front.kontak');
    }

    /**
     * Display the order success page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showSuccessPage(Request $request)
    {
        $pemesananId = $request->query('pemesanan_id');
        $totalHarga = $request->query('total_harga');
        $dpAmount = $request->query('dp_amount');
        $remainingPayment = $request->query('remaining_payment');
        $kategori = $request->query('kategori');

        $pemesanan = null;
        if ($pemesananId) {
            $pemesanan = Pemesanan::find($pemesananId);
        }

        return view('order.pemesanan-success', compact('pemesanan', 'totalHarga', 'dpAmount', 'remainingPayment', 'kategori'));
    }

    /**
     * Display the user account page.
     *
     * @return \Illuminate\View\View
     */
    public function akun()
    {
        return view('front.akun');
    }

    /**
     * Display the user settings page.
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        // Add any necessary logic to prepare data for the settings page here.
        // For now, it just returns the view.
        return view('front.settings');
    }

    public function history()
    {
        // Ensures only logged-in users can view their order history
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat riwayat pemesanan.');
        }

        $pemesanans = Pemesanan::where('pengguna_id', Auth::id())
            ->with(['pengguna', 'jasa', 'paket'])
            ->latest()
            ->paginate(10);

        return view('order.history', compact('pemesanans'));
    }


    /**
     * Display the user's order history page.
     *
     * @return \Illuminate\View\View
     */
    public function riwayatPemesanan()
    {
        // Ensures only logged-in users can view their order history
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat riwayat pemesanan.');
        }

        $pemesanans = Pemesanan::where('pengguna_id', Auth::id())
            ->with(['pengguna', 'jasa', 'paket'])
            ->latest()
            ->paginate(10);

        return view('front.riwayat-pemesanan', compact('pemesanans'));
    }
}
