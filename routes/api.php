<?php

use App\Http\Controllers\PemesananController;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rute untuk mendapatkan kategori paket berdasarkan ID paket
Route::get('/pakets/{paket}/category', function (Paket $paket) {
    return response()->json(['kategori' => $paket->kategori]);
})->name('api.pakets.category');

// Rute untuk mendapatkan daftar paket berdasarkan jenis jasa
Route::get('/pakets-by-jasa-tipe', [PemesananController::class, 'getPaketsByJasaTipe'])->name('api.pakets.by.jasa.tipe');
