<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PemesananController;
use App\Models\Paket;
use Illuminate\Support\Facades\Route;




Route::get('/', [FrontController::class, 'index'])->name('home');

Route::get('/portofolio', [FrontController::class, 'listPortofolios'])->name('portofolio.index');
Route::get('/portofolio/{id}', [FrontController::class, 'detailPortofolio'])->name('portofolio.show'); // Untuk detail portofolio (jika diperlukan)

// Fotografi
Route::get('/pakets-wedding', [PaketController::class, 'paketwedding'])->name('wedding.show');
Route::get('/pakets-prewedding', [PaketController::class, 'paketprewedding'])->name('prewedding.show');
Route::get('/pakets-sekolah', [PaketController::class, 'paketsekolah'])->name('photosekolah.show');
Route::get('/pakets-all-event', [PaketController::class, 'paketAllEvent'])->name('allevent.show');
Route::get('/pakets-vidioCinematic', [PaketController::class, 'paketVidioCinematic'])->name('vidioCinematic.show');
Route::get('/pakets-vidioLiputan', [PaketController::class, 'paketVidioLiputan'])->name('VidioLiputan.show');

// Percetakan
Route::get('/pakets-cetakIdCard', [PaketController::class, 'cetakIdCard'])->name('cetakIdCard.show');
Route::get('/pakets-cetakFoto', [PaketController::class, 'cetakFoto'])->name('cetakFoto.show');
Route::get('/pakets-cetakMIR', [PaketController::class, 'cetakMIR'])->name('cetakMIR.show');
Route::get('/pakets-medaliSekolah', [PaketController::class, 'medaliSekolah'])->name('medaliSekolah.show');
Route::get('/pakets-cetakJenisBuku', [PaketController::class, 'cetakJenisBuku'])->name('cetakJenisBuku.show');
Route::get('/pakets-cetakStikerLabel', [PaketController::class, 'cetakStikerLabel'])->name('cetakStikerLabel.show');
Route::get('/pakets-cetakKalender', [PaketController::class, 'cetakKalender'])->name('cetakKalender.show');
Route::get('/pakets-bingkaiFoto', [PaketController::class, 'bingkaiFoto'])->name('bingkaiFoto.show');

Route::get('/tentang-kami', [FrontController::class, 'TentangKami'])->name('tentang.kami');
Route::get('/kontak', [FrontController::class, 'Kontak'])->name('kontak');



Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {

    // Booking Form Routes
    Route::get('/pemesanan', [PemesananController::class, 'showPemesananForm'])->name('pemesanan.form');
    Route::post('/pemesanan', [PemesananController::class, 'storePemesanan'])->name('pemesanan.store');
    Route::post('/pemesanan/{pemesanan}/upload-pelunasan', [PemesananController::class, 'uploadPelunasan'])->name('pemesanan.upload_pelunasan');
    Route::get('/pemesanan/{pemesanan}/invoice', [PemesananController::class, 'showInvoice'])->name('pemesanan.invoice'); // Tambahkan ini
    Route::get('/pemesanan/success', [FrontController::class, 'showSuccessPage'])->name('pemesanan.success');
    Route::get('/pemesanan/history', [FrontController::class, 'history'])->name('pemesanan.history');
});
