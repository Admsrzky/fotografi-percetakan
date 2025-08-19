<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Jasa;
use App\Models\Paket;
use App\Models\Pemesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PemesananController extends Controller
{
    /**
     * Menampilkan formulir pemesanan dengan tanggal yang tidak tersedia.
     */
    public function showPemesananForm(Request $request)
    {
        // Mendapatkan semua tanggal yang tidak tersedia dari tabel 'jadwal'
        // Memfilter tanggal yang sudah lewat agar hanya menampilkan jadwal di masa depan atau hari ini
        $jadwals = Jadwal::where(function ($query) {
            $query->where('tanggal_mulai', '>=', Carbon::today()->toDateString())
                ->orWhere('tanggal_akhir', '>=', Carbon::today()->toDateString());
        })
            ->get();

        $disabledDates = [];
        $disabledDateReasons = []; // Array untuk menyimpan alasan per tanggal

        foreach ($jadwals as $jadwal) {
            $mulai = Carbon::parse($jadwal->tanggal_mulai);
            $akhir = $jadwal->tanggal_akhir ? Carbon::parse($jadwal->tanggal_akhir) : null;
            $alasan = $jadwal->alasan ?? 'Tanggal tidak tersedia'; // Ambil alasan dari DB, default jika null

            if ($akhir && $mulai->lt($akhir)) { // Jika ini adalah rentang tanggal
                $disabledDates[] = [
                    'from' => $mulai->format('Y-m-d'),
                    'to' => $akhir->format('Y-m-d'),
                ];
                // Tambahkan alasan untuk setiap hari dalam rentang ini
                $currentDate = $mulai->copy();
                while ($currentDate->lte($akhir)) {
                    $disabledDateReasons[$currentDate->format('Y-m-d')] = $alasan;
                    $currentDate->addDay();
                }
            } else { // Jika ini adalah tanggal tunggal
                $dateString = $mulai->format('Y-m-d');
                $disabledDates[] = $dateString;
                $disabledDateReasons[$dateString] = $alasan;
            }
        }

        // Mengambil tanggal dari tabel 'pemesanan' dengan status 'diproses'
        $processedBookings = Pemesanan::where('status_pemesanan', 'diproses')
            ->where('tanggal_acara', '>=', Carbon::today()->toDateString())
            ->pluck('tanggal_acara')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();

        // Gabungkan tanggal yang dinonaktifkan dari jadwal dan tanggal pesanan yang sudah diproses
        // Untuk pemesanan, alasan default bisa "Sudah ada pemesanan"
        foreach ($processedBookings as $date) {
            // Hanya tambahkan alasan jika tanggal belum memiliki alasan dari jadwal
            if (!isset($disabledDateReasons[$date])) {
                $disabledDateReasons[$date] = 'Sudah ada pemesanan lain';
            }
            // Pastikan tanggal juga ada di disabledDates untuk Flatpickr
            // Hindari duplikasi jika sudah ada sebagai bagian dari rentang
            if (!in_array($date, $disabledDates) && !collect($disabledDates)->contains(function ($item) use ($date) {
                return is_array($item) && Carbon::parse($date)->between(Carbon::parse($item['from']), Carbon::parse($item['to']));
            })) {
                $disabledDates[] = $date;
            }
        }

        // Mendapatkan jenis jasa unik untuk dropdown di formulir
        $jasaTipes = Jasa::select('tipe_jasa')
            ->distinct()
            ->pluck('tipe_jasa', 'tipe_jasa')
            ->mapWithKeys(function ($item, $key) {
                return [$key => ucfirst($key)]; // Contoh: 'fotografi' menjadi 'Fotografi'
            })
            ->toArray();

        // Dapatkan kategori awal jika paket_id disediakan melalui URL atau old input
        $initialKategori = null;
        $initialPaketId = $request->query('paket_id') ?? old('paket_pilihan');

        if ($initialPaketId) {
            $initialPaket = Paket::find($initialPaketId);
            if ($initialPaket) {
                $initialKategori = $initialPaket->kategori;
            }
        }

        // Mengirim data ke view 'order.pemesanan'
        return view('order.pemesanan', compact('disabledDates', 'jasaTipes', 'disabledDateReasons', 'initialKategori'));
    }

    /**
     * API endpoint untuk mendapatkan paket berdasarkan jenis jasa.
     * Sekarang juga mengembalikan harga dan kategori.
     */
    public function getPaketsByJasaTipe(Request $request)
    {
        $jasa_tipe = $request->query('jasa_tipe');
        $pakets_data = []; // Menggunakan array asosiatif untuk menyimpan lebih banyak data

        if ($jasa_tipe) {
            $jasa_ids = Jasa::where('tipe_jasa', $jasa_tipe)->pluck('id');
            $pakets = Paket::whereIn('jasa_id', $jasa_ids)
                ->where('aktif', true) // Pastikan hanya paket yang aktif
                ->orderBy('nama_paket', 'asc')
                ->get(['id', 'nama_paket', 'harga_paket', 'kategori']); // Ambil harga dan kategori juga

            foreach ($pakets as $paket) {
                $display_name = $paket->nama_paket;
                if ($paket->harga_paket && is_numeric($paket->harga_paket)) {
                    $display_name .= ' (Rp ' . number_format($paket->harga_paket, 0, ',', '.') . ')';
                }
                $pakets_data[] = [ // Simpan sebagai array objek
                    'id' => $paket->id,
                    'name' => $display_name,
                    'harga_paket' => $paket->harga_paket,
                    'kategori' => $paket->kategori,
                    'tipe_jasa' => $jasa_tipe // Tambahkan tipe jasa untuk memudahkan di frontend
                ];
            }
        }
        return response()->json($pakets_data);
    }

    /**
     * Menyimpan data formulir pemesanan.
     */
    public function storePemesanan(Request $request)
    {
        // Validasi umum
        $rules = [
            'tanggal_acara' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $selectedDate = Carbon::parse($value)->startOfDay();
                    $errorMessage = 'Tanggal yang Anda pilih sudah terisi penuh atau tidak tersedia. Silakan pilih tanggal lain.';

                    $isSingleDateBookedJadwal = Jadwal::where('tanggal_mulai', $selectedDate->toDateString())
                        ->whereNull('tanggal_akhir')
                        ->first();

                    $isDateWithinRangeBookedJadwal = Jadwal::whereNotNull('tanggal_akhir')
                        ->where('tanggal_mulai', '<=', $selectedDate->toDateString())
                        ->where('tanggal_akhir', '>=', $selectedDate->toDateString())
                        ->first();

                    $isDateBookedPemesanan = Pemesanan::where('tanggal_acara', $selectedDate->toDateString())
                        ->where('status_pemesanan', 'diproses')
                        ->exists();

                    if ($isSingleDateBookedJadwal) {
                        $errorMessage = $isSingleDateBookedJadwal->alasan ?? 'Tanggal ini sudah dipesan.';
                    } elseif ($isDateWithinRangeBookedJadwal) {
                        $errorMessage = $isDateWithinRangeBookedJadwal->alasan ?? 'Tanggal ini berada dalam rentang jadwal penuh.';
                    } elseif ($isDateBookedPemesanan) {
                        $errorMessage = 'Tanggal ini sudah ada pemesanan lain.';
                    }

                    if ($isSingleDateBookedJadwal || $isDateWithinRangeBookedJadwal || $isDateBookedPemesanan) {
                        $fail($errorMessage);
                    }
                },
            ],
            'jenis_jasa' => 'required|string',
            'paket_pilihan' => 'required|numeric',
            'nama_pemesan' => 'required|string|max:255',
            'email_pemesan' => 'required|email|max:255',
            'telepon_pemesan' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'bukti_pembayaran' => 'required|image|max:2048|mimes:jpeg,png,jpg,gif,svg', // Bukti pembayaran selalu wajib
            'payment_option' => 'required|string|in:dp,full_payment',
            'dp_amount' => 'nullable|numeric|min:0',
        ];

        // Dapatkan paket yang dipilih untuk validasi dan perhitungan
        $paket_valid = Paket::where('id', $request->paket_pilihan)
            ->where('aktif', true)
            ->first();

        if (!$paket_valid) {
            return redirect()->back()->withErrors(['paket_pilihan' => 'Pilihan paket tidak valid.'])->withInput();
        }

        // Validasi kondisional berdasarkan jenis jasa
        if ($request->jenis_jasa === 'percetakan') {
            $rules['quantity'] = 'required|integer|min:1';
            $rules['lokasi_acara'] = 'required|string|max:255'; // Untuk alamat pengiriman
        } else { // Asumsikan ini untuk jasa fotografi/videografi
            $rules['lokasi_acara'] = 'required|string|max:255'; // Untuk lokasi acara
            $rules['quantity'] = 'nullable|integer|min:1'; // Kuantitas opsional untuk non-percetakan
        }

        $request->validate($rules);

        // --- Logika Batasan Pemesanan Fotografi (maks 3 per hari untuk semua user) ---
        if ($request->jenis_jasa === 'fotografi') {
            $tanggalAcara = Carbon::parse($request->tanggal_acara)->toDateString();
            $fotografiJasaId = Jasa::where('tipe_jasa', 'fotografi')->first()->id ?? null;

            if ($fotografiJasaId) {
                $bookingsCount = Pemesanan::where('tanggal_acara', $tanggalAcara)
                    ->where('jasa_id', $fotografiJasaId)
                    ->whereNotIn('status_pemesanan', ['dibatalkan', 'selesai']) // Hitung pemesanan yang aktif
                    ->count();

                if ($bookingsCount >= 3) {
                    return redirect()->back()->withErrors(['tanggal_acara' => 'Maaf, tanggal ini sudah penuh untuk layanan fotografi. Maksimal 3 pemesanan per hari.'])->withInput();
                }
            }
        }
        // --- Akhir Logika Batasan Pemesanan Fotografi ---


        // Ambil kategori dari paket
        $kategoriPaket = $paket_valid->kategori;

        // Batasi pemesanan maksimal 3 kali berdasarkan kategori (untuk email pemesan)
        $jumlahPemesananKategori = Pemesanan::where('email_pelanggan', $request->email_pemesan)
            ->whereHas('paket', function ($query) use ($kategoriPaket) {
                $query->where('kategori', $kategoriPaket);
            })
            ->count();

        if ($jumlahPemesananKategori >= 3) {
            return redirect()->back()->withErrors(['general' => "Anda hanya dapat melakukan pemesanan maksimal 3 kali untuk kategori $kategoriPaket."])->withInput();
        }

        // --- Perhitungan Harga di Sisi Server (Ini yang paling penting!) ---
        // Pastikan harga paket adalah float untuk perhitungan yang akurat
        $hargaPaket = (float) $paket_valid->harga_paket;
        $quantity = ($request->jenis_jasa === 'percetakan') ? (int) $request->quantity : 1;

        $subtotal = $hargaPaket * $quantity;
        $totalHarga = $subtotal; // Untuk saat ini, total sama dengan subtotal sebelum DP

        // Tentukan dpAmount dan paymentType berdasarkan payment_option dari request
        $selectedPaymentOption = $request->input('payment_option');
        $dpAmount = 0.00; // Inisialisasi dengan float
        $paymentType = '';

        if ($selectedPaymentOption === 'full_payment') {
            $dpAmount = $totalHarga; // Jika bayar penuh, DP adalah total harga
            $paymentType = 'full_payment';
        } else { // 'dp'
            // Ambil nilai dp_amount dari request, pastikan di-cast ke float
            $dpAmount = (float) ($request->dp_amount ?? 0);
            // Pastikan DP tidak melebihi total harga
            if ($dpAmount > $totalHarga) {
                $dpAmount = $totalHarga;
            }
            $paymentType = 'dp';
        }

        $kategoriPaket = $request->input('kategori_paket'); // Ini dari hidden input yang Anda tambahkan

        $remainingPayment = $totalHarga - $dpAmount;

        // Pastikan semua nilai desimal diformat dengan benar untuk penyimpanan
        // Ini akan memastikan nilai disimpan dengan 2 desimal di database DECIMAL(X,2)
        $subtotal = number_format($subtotal, 2, '.', '');
        $totalHarga = number_format($totalHarga, 2, '.', '');
        $dpAmount = number_format($dpAmount, 2, '.', '');
        $remainingPayment = number_format($remainingPayment, 2, '.', '');
        // --- Akhir Perhitungan Harga ---

        // Handle upload bukti pembayaran
        $buktiPembayaranPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPembayaranPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        try {
            $pemesanan = Pemesanan::create([ // Simpan hasil create ke variabel
                'pengguna_id' => Auth::check() ? Auth::id() : null,
                'jasa_id' => $paket_valid->jasa_id,
                'paket_id' => $paket_valid->id,
                'kategori_paket' => $kategoriPaket, // <-- PASTIKAN BARIS INI ADA DAN TERISI
                'nama_pelanggan' => $request->nama_pemesan,
                'email_pelanggan' => $request->email_pemesan,
                'telepon_pelanggan' => $request->telepon_pemesan,
                'tanggal_acara' => Carbon::parse($request->tanggal_acara)->format('Y-m-d'),
                'lokasi_acara' => $request->lokasi_acara,
                'catatan_tambahan' => $request->catatan,
                'status_pemesanan' => 'menunggu', // Status awal selalu 'menunggu' untuk konfirmasi admin
                'bukti_pembayaran' => $buktiPembayaranPath,
                'quantity' => $quantity, // Simpan kuantitas
                'subtotal' => $subtotal, // Simpan subtotal
                'total_harga' => $totalHarga, // Simpan total harga
                'dp_amount' => $dpAmount, // Simpan jumlah DP
                'remaining_payment' => $remainingPayment, // Simpan sisa pembayaran
                'payment_type' => $paymentType, // Simpan jenis pembayaran awal
            ]);

            // Redirect ke halaman sukses dengan data pemesanan yang baru dibuat
            return redirect()->route('pemesanan.success', [
                'pemesanan_id' => $pemesanan->id,
                'total_harga' => $totalHarga,
                'dp_amount' => $dpAmount,
                'remaining_payment' => $remainingPayment,
                'kategori' => $kategoriPaket // Tambahkan kategori juga
            ])->with('success', "Pemesanan berhasil dikirim!"); // Pesan sukses yang lebih umum

        } catch (QueryException $e) {
            Log::error('Error saat menyimpan pemesanan: ' . $e->getMessage());

            if ($buktiPembayaranPath) {
                Storage::disk('public')->delete($buktiPembayaranPath);
            }

            return redirect()->back()->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    // Metode untuk mengunggah bukti pelunasan
    public function uploadPelunasan(Request $request, Pemesanan $pemesanan)
    {
        // Pastikan pengguna yang login adalah pemilik pemesanan ini
        if (Auth::id() !== $pemesanan->pengguna_id) { // Menggunakan 'pengguna_id'
            abort(403, 'Anda tidak diizinkan untuk melakukan aksi ini.');
        }

        // Pastikan status pemesanan adalah 'dp'
        if ($pemesanan->payment_type !== 'dp') {
            return redirect()->back()->with('error', 'Pemesanan ini tidak dalam status DP atau sudah lunas.');
        }

        // Validasi file yang diunggah
        $request->validate([
            'bukti_pelunasan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ], [
            'bukti_pelunasan.required' => 'File bukti pelunasan wajib diunggah.',
            'bukti_pelunasan.image' => 'File harus berupa gambar.',
            'bukti_pelunasan.mimes' => 'Format gambar yang diizinkan adalah JPG, PNG, atau GIF.',
            'bukti_pelunasan.max' => 'Ukuran file bukti pelunasan tidak boleh lebih dari 2MB.',
        ]);

        try {
            // Hapus bukti pelunasan lama jika ada
            if ($pemesanan->bukti_pelunasan_path && Storage::disk('public')->exists($pemesanan->bukti_pelunasan_path)) {
                Storage::disk('public')->delete($pemesanan->bukti_pelunasan_path);
            }

            // Simpan file bukti pelunasan baru
            $path = $request->file('bukti_pelunasan')->store('bukti_pelunasan', 'public');

            // Perbarui kolom di database
            $pemesanan->update([
                'bukti_pelunasan_path' => $path,
                'is_pelunasan_confirmed' => false, // Set false, menunggu konfirmasi admin
                'tanggal_pelunasan' => now(), // Menyimpan tanggal dan waktu saat ini
            ]);

            return redirect()->back()->with('success', 'Bukti pelunasan berhasil diunggah! Menunggu konfirmasi admin.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunggah bukti pelunasan: ' . $e->getMessage());
        }
    }

    // Metode untuk menampilkan invoice
    public function showInvoice(Pemesanan $pemesanan)
    {
        // Izinkan jika pengguna yang login adalah admin ATAU pemilik pemesanan
        if (Auth::user()->isAdmin() || Auth::id() === $pemesanan->pengguna_id) {
            // Muat relasi yang diperlukan untuk invoice
            $pemesanan->load(['pengguna', 'jasa', 'paket']);

            return view('order.invoice', compact('pemesanan'));
        }

        // Jika tidak diizinkan, kembalikan error 403
        abort(403, 'Anda tidak diizinkan untuk melihat invoice ini.');
    }

    public function downloadInvoice(Pemesanan $record)
    {
        // Tambahkan juga pemeriksaan untuk admin di sini
        if (Auth::user()->isAdmin() || Auth::id() === $record->pengguna_id) {
            if (!view()->exists('invoice', ['record' => $record])) {
                abort(404, 'Invoice view not found.');
            }

            $pdf = Pdf::loadView('invoice', ['record' => $record]);

            return $pdf->download('invoice-' . $record->id . '.pdf');
        }

        // Jika tidak diizinkan, kembalikan error 403
        abort(403, 'Anda tidak diizinkan untuk mengunduh invoice ini.');
    }
}
