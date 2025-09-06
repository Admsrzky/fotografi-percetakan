@extends('layouts.master')

@section('title', 'Pemesanan Jasa - Studio Foto & Cetak')

@section('content')
    <section class="py-16 bg-gray-50">
        <div class="container max-w-4xl px-4 mx-auto">
            <h2 class="mb-6 text-4xl font-bold text-center">Mulai Pemesanan Anda</h2>
            <p class="mb-10 text-lg text-center text-gray-700">Kami akan menghubungi Anda untuk diskusi lebih lanjut dan
                konfirmasi setelah Anda mengisi formulir ini.</p>

            {{-- Pesan Sukses (from redirect with 'success' session) --}}
            @if (session('success'))
                <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded-xl"
                    role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                        onclick="this.parentElement.style.display='none';">
                        <svg class="w-6 h-6 text-green-500 fill-current" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.304l-2.651 3.545a1.2 1.2 0 1 1-1.697-1.697l3.545-2.651-3.545-2.651a1.2 1.2 0 1 1 1.697-1.697L10 8.696l2.651-3.545a1.2 1.2 0 1 1 1.697 1.697L11.304 10l3.545 2.651a1.2 1.2 0 0 1 0 1.697z" />
                        </svg>
                    </span>
                </div>
            @endif

            {{-- Pesan Error Validasi (from $errors->any()) --}}
            @if ($errors->any())
                <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded-xl"
                    role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                    <ul class="mt-3 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                        onclick="this.parentElement.style.display='none';">
                        <svg class="w-6 h-6 text-red-500 fill-current" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.304l-2.651 3.545a1.2 1.2 0 1 1-1.697-1.697l3.545-2.651-3.545-2.651a1.2 1.2 0 1 1 1.697-1.697L10 8.696l2.651-3.545a1.2 1.2 0 1 1 1.697 1.697L11.304 10l3.545 2.651a1.2 1.2 0 0 1 0 1.697z" />
                        </svg>
                    </span>
                </div>
            @endif

            {{-- Menambahkan enctype untuk upload file --}}
            <form action="{{ route('pemesanan.store') }}" method="POST" enctype="multipart/form-data"
                class="p-10 bg-white border border-gray-100 shadow-2xl rounded-xl">
                @csrf {{-- CSRF Token untuk keamanan Laravel --}}

                <div class="pb-8 mb-10 border-b border-gray-200">
                    <h3 id="tanggal_section_title" class="flex items-center mb-6 text-2xl font-semibold text-accent">
                        <span
                            class="flex items-center justify-center w-8 h-8 mr-3 text-lg font-bold text-white rounded-full bg-accent">1</span>
                        Pilih Tanggal Acara
                    </h3>
                    <p class="mb-6 text-gray-700">Pilih tanggal yang Anda inginkan untuk acara Anda. Tanggal yang sudah
                        terisi penuh akan ditandai.</p>

                    <div id="calendar-container"
                        class="flex justify-center w-full p-6 border border-gray-200 rounded-lg shadow-inner bg-gray-50">
                        <input type="text" id="tanggal_acara_calendar" class="hidden">
                        <div id="flatpickr-calendar-display"></div>
                    </div>
                    <div class="mt-4 text-sm font-semibold text-center">
                        <span class="inline-block w-4 h-4 mr-2 bg-green-200 rounded-full"></span> Tanggal Tersedia &nbsp;
                        <span class="inline-block w-4 h-4 mr-2 bg-red-200 rounded-full"></span> Tanggal Terisi Penuh &nbsp;
                        <span class="inline-block w-4 h-4 mr-2 rounded-full bg-accent"></span> Tanggal Pilihan Anda
                    </div>

                    <div class="mt-6">
                        <label for="tanggal_acara" class="block mb-2 text-sm font-semibold text-gray-800">Tanggal
                            Acara Pilihan Anda <span class="text-red-500">*</span></label>
                        <input type="text" id="tanggal_acara" name="tanggal_acara" class="bg-gray-200 form-input-elegent"
                            placeholder="Tanggal akan otomatis terisi dari kalender" readonly required
                            value="{{ old('tanggal_acara') }}">
                        @error('tanggal_acara')
                            <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Pilih tanggal dari kalender di atas.</p>
                    </div>
                </div>

                <div class="pb-8 mb-10 border-b border-gray-200">
                    <h3 class="flex items-center mb-6 text-2xl font-semibold text-accent">
                        <span
                            class="flex items-center justify-center w-8 h-8 mr-3 text-lg font-bold text-white rounded-full bg-accent">2</span>
                        Detail Jasa yang Anda Inginkan
                    </h3>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="jenis_jasa" class="block mb-2 text-sm font-semibold text-gray-800">Pilih Jenis Jasa
                                <span class="text-red-500">*</span></label>
                            <select id="jenis_jasa" name="jenis_jasa" class="form-input-elegent" required>
                                <option value="" disabled {{ old('jenis_jasa') == '' ? 'selected' : '' }}>-- Pilih
                                    Jenis Jasa --</option>
                                @foreach ($jasaTipes as $tipe => $label)
                                    <option value="{{ $tipe }}" {{ old('jenis_jasa') == $tipe ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                            @error('jenis_jasa')
                                <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="paket_pilihan" class="block mb-2 text-sm font-semibold text-gray-800">Pilih Paket /
                                Layanan <span class="text-red-500">*</span></label>
                            <select id="paket_pilihan" name="paket_pilihan" class="form-input-elegent" required>
                                <option value="" disabled {{ old('paket_pilihan') == '' ? 'selected' : '' }}>-- Pilih
                                    Paket/Layanan --</option>
                                @if (old('jenis_jasa') && old('paket_pilihan'))
                                    @php
                                        $oldJasaIds = \App\Models\Jasa::where('tipe_jasa', old('jenis_jasa'))->pluck(
                                            'id',
                                        );
                                        $oldPaket = \App\Models\Paket::whereIn('jasa_id', $oldJasaIds)
                                            ->where('id', old('paket_pilihan'))
                                            ->first();
                                    @endphp
                                    @if ($oldPaket)
                                        <option value="{{ $oldPaket->id }}" selected>
                                            {{ $oldPaket->nama_paket }}
                                            @if ($oldPaket->harga_paket && is_numeric($oldPaket->harga_paket))
                                                (Rp {{ number_format($oldPaket->harga_paket, 0, ',', '.') }})
                                            @endif
                                        </option>
                                    @else
                                        <option value="{{ old('paket_pilihan') }}" selected>
                                            Pilihan sebelumnya (invalid/tidak ditemukan)
                                        </option>
                                    @endif
                                @endif
                            </select>
                            @error('paket_pilihan')
                                <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Pilihan akan muncul setelah Anda memilih Jenis Jasa.</p>
                        </div>
                    </div>

                    {{-- Display Kategori --}}
                    <div class="mt-6">
                        <label for="kategori_paket" class="block mb-2 text-sm font-semibold text-gray-800">Kategori Paket</label>
                        <input type="text" id="kategori_paket_display" class="bg-gray-200 form-input-elegent" readonly
                            placeholder="Kategori paket akan tampil di sini"
                            value="{{ old('kategori_paket', $initialKategori) }}">
                        {{-- Hidden input to send the category with the form --}}
                        <input type="hidden" id="kategori_paket" name="kategori_paket" value="{{ old('kategori_paket', $initialKategori) }}">
                        <p class="mt-1 text-xs text-gray-500">Kategori akan otomatis terisi setelah memilih paket.</p>
                    </div>

                    {{-- Kuantitas: Hanya tampil untuk percetakan --}}
                    <div class="mt-6" id="quantity_wrapper" class="hidden">
                        <label for="quantity" class="block mb-2 text-sm font-semibold text-gray-800">Kuantitas <span class="text-red-500">*</span></label>
                        <input type="number" id="quantity" name="quantity" class="form-input-elegent"
                            placeholder="Masukkan jumlah pesanan" min="1" value="{{ old('quantity', 1) }}">
                        @error('quantity')
                            <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Jumlah item yang akan dicetak.</p>
                    </div>

                    {{-- Display Harga Paket, Subtotal, Total Harga, DP, Sisa Pembayaran --}}
                    <div class="p-6 mt-8 bg-gray-100 rounded-lg shadow-inner">
                        <h4 class="mb-4 text-xl font-semibold text-accent">Rincian Pembayaran</h4>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700">Harga Paket:</span>
                                <span class="font-bold text-gray-900" id="display_harga_paket">Rp 0</span>
                                <input type="hidden" id="hidden_harga_paket" value="0">
                            </div>
                            <div class="flex items-center justify-between" id="subtotal_row" class="hidden">
                                <span class="text-gray-700">Subtotal:</span>
                                <span class="font-bold text-gray-900" id="display_subtotal">Rp 0</span>
                                {{-- Hidden input for subtotal_harga to be sent to backend --}}
                                <input type="hidden" name="subtotal_harga" id="hidden_subtotal_harga" value="{{ old('subtotal_harga', 0) }}">
                            </div>
                            <div class="flex items-center justify-between pt-2 mt-2 border-t">
                                <span class="text-lg font-semibold text-gray-800">Total Harga:</span>
                                <span class="text-lg font-bold text-accent" id="display_total_harga">Rp 0</span>
                                {{-- Hidden input for total_harga to be sent to backend --}}
                                <input type="hidden" name="total_harga" id="hidden_total_harga" value="{{ old('total_harga', 0) }}">
                            </div>

                            {{-- Pilihan Tipe Pembayaran --}}
                            <div class="mt-6">
                                <label class="block mb-2 text-sm font-semibold text-gray-800">Pilih Tipe Pembayaran <span class="text-red-500">*</span></label>
                                <div class="flex items-center space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="payment_option" value="dp" class="form-radio text-accent"
                                            id="payment_option_dp" {{ old('payment_option', 'dp') == 'dp' ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Uang Muka (DP)</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="payment_option" value="full_payment" class="form-radio text-accent"
                                            id="payment_option_full" {{ old('payment_option') == 'full_payment' ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Bayar Penuh</span>
                                    </label>
                                </div>
                                @error('payment_option')
                                    <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Wrapper for DP Amount input, hidden by default for full payment --}}
                            <div class="mt-4" id="dp_amount_wrapper">
                                <label for="dp_amount" class="block mb-2 text-sm font-semibold text-gray-800">Uang Muka (DP)</label>
                                <input type="number" id="dp_amount" name="dp_amount" class="form-input-elegent"
                                    placeholder="Masukkan jumlah DP" min="0" value="{{ old('dp_amount', 0) }}">
                                @error('dp_amount')
                                    <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Anda bisa membayar sebagian di awal.</p>
                            </div>

                            <div class="flex items-center justify-between pt-2 mt-2 border-t">
                                <span class="text-lg font-semibold text-gray-800">Sisa Pembayaran:</span>
                                <span class="text-lg font-bold text-red-600" id="display_remaining_payment">Rp 0</span>
                                {{-- Hidden input for remaining_payment to be sent to backend --}}
                                <input type="hidden" name="remaining_payment" id="hidden_remaining_payment" value="{{ old('remaining_payment', 0) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bagian 3: Detail Kontak Anda --}}
                <div class="pb-8 mb-10 border-b border-gray-200">
                    <h3 class="flex items-center mb-6 text-2xl font-semibold text-accent">
                        <span
                            class="flex items-center justify-center w-8 h-8 mr-3 text-lg font-bold text-white rounded-full bg-accent">3</span>
                        Informasi Kontak Anda
                    </h3>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="nama_pemesan" class="block mb-2 text-sm font-semibold text-gray-800">Nama Lengkap
                                <span class="text-red-500">*</span></label>
                            {{-- Auto-fill nama_pemesan jika user login --}}
                            <input type="text" id="nama_pemesan" name="nama_pemesan" class="form-input-elegent"
                                placeholder="Nama Lengkap Anda"
                                value="{{ old('nama_pemesan', Auth::user()->name ?? '') }}" required>
                            @error('nama_pemesan')
                                <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email_pemesan" class="block mb-2 text-sm font-semibold text-gray-800">Email
                                <span class="text-red-500">*</span></label>
                            {{-- Auto-fill email_pemesan jika user login --}}
                            <input type="email" id="email_pemesan" name="email_pemesan" class="form-input-elegent"
                                placeholder="Email Anda"
                                value="{{ old('email_pemesan', Auth::user()->email ?? '') }}" required>
                            @error('email_pemesan')
                                <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="telepon_pemesan" class="block mb-2 text-sm font-semibold text-gray-800">Nomor Telepon
                                <span class="text-red-500">*</span></label>
                            <input type="tel" id="telepon_pemesan" name="telepon_pemesan" class="form-input-elegent"
                                placeholder="Contoh: 081234567890" value="{{ old('telepon_pemesan') }}" required>
                            @error('telepon_pemesan')
                                <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="pb-8 mb-10 border-b border-gray-200">
                    <h3 class="flex items-center mb-6 text-2xl font-semibold text-accent">
                        <span
                            class="flex items-center justify-center w-8 h-8 mr-3 text-lg font-bold text-white rounded-full bg-accent">4</span>
                        Catatan dan Permintaan Khusus
                    </h3>
                    <div class="mb-5">
                        <label for="catatan" class="block mb-2 text-sm font-semibold text-gray-800">Detail Lebih Lanjut
                            (Opsional)</label>
                        <textarea id="catatan" name="catatan" rows="6" class="resize-y form-input-elegent"
                            placeholder="Ceritakan detail tambahan, tema yang diinginkan, jumlah orang, preferensi khusus, atau pertanyaan lainnya.">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Berikan detail tambahan yang mungkin relevan dengan pesanan
                            Anda.</p>
                    </div>

                    {{-- Lokasi Acara: Dipindahkan ke sini dan selalu tampil --}}
                    <div class="mt-6" id="lokasi_acara_wrapper">
                        <label for="lokasi_acara" class="block mb-2 text-sm font-semibold text-gray-800" id="lokasi_label">
                            Lokasi Acara <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="lokasi_acara" name="lokasi_acara" class="form-input-elegent"
                            placeholder="Contoh: Gedung Pernikahan Harmoni, Jakarta"
                            value="{{ old('lokasi_acara') }}" required>
                        @error('lokasi_acara')
                            <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500" id="lokasi_help_text">
                            Isi lokasi acara untuk fotografi/videografi.
                        </p>
                    </div>
                </div>

                {{-- Menambahkan input untuk Bukti Pembayaran --}}
                <div class="mb-10">
                    <h3 class="flex items-center mb-6 text-2xl font-semibold text-accent">
                        <span
                            class="flex items-center justify-center w-8 h-8 mr-3 text-lg font-bold text-white rounded-full bg-accent">5</span>
                        Unggah Bukti Pembayaran <span class="text-red-500">*</span>
                    </h3>
                    <div class="mb-5">
                        <label for="bukti_pembayaran" class="block mb-2 text-sm font-semibold text-gray-800">Pilih File
                            Bukti Pembayaran</label>
                        <input type="file" id="bukti_pembayaran" name="bukti_pembayaran"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-accent hover:file:bg-violet-100"
                            required>
                        @error('bukti_pembayaran')
                            <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Unggah gambar bukti transfer atau pembayaran. (Max: 2MB,
                            Format: JPG, PNG, GIF)</p>
                    </div>
                </div>


                <button type="submit"
                    class="w-full px-8 py-4 text-lg font-bold text-white transition duration-300 transform rounded-full shadow-xl bg-accent hover:bg-accent-dark">
                    Kirim Permintaan Pemesanan
                </button>
            </form>

            <p class="mt-8 text-sm leading-relaxed text-center text-gray-600">
                <span class="font-bold text-red-600">Penting:</span> Semua kolom bertanda (<span
                    class="text-red-500">*</span>) wajib diisi.
            </p>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data tanggal terisi dari PHP (from PemesananController)
            const bookedDates = @json($disabledDates);
            const disabledDateReasons = @json($disabledDateReasons);

            const today = new Date();
            const minDateForCalendar = new Date(today);
            minDateForCalendar.setDate(today.getDate());

            const flatpickrInstance = flatpickr("#tanggal_acara_calendar", {
                inline: true,
                minDate: minDateForCalendar,
                dateFormat: "Y-m-d",
                disable: bookedDates,
                appendTo: document.getElementById('flatpickr-calendar-display'),
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        document.getElementById('tanggal_acara').value = dateStr;
                    } else {
                        document.getElementById('tanggal_acara').value = '';
                    }
                },
                onReady: function(selectedDates, dateStr, instance) {
                    const oldDate = "{{ old('tanggal_acara') }}";
                    if (oldDate) {
                        instance.setDate(oldDate);
                        document.getElementById('tanggal_acara').value = oldDate;
                    } else {
                        document.getElementById('tanggal_acara').value = '';
                    }

                    const calendarContainer = instance.calendarContainer;
                    calendarContainer.querySelectorAll(
                        '.flatpickr-day:not(.flatpickr-disabled):not(.flatpickr-day.selected):not(.nextMonthDay):not(.prevMonthDay)'
                    ).forEach(dayElem => {
                        dayElem.style.backgroundColor = '#D1FAE5'; /* Green-100 */
                        dayElem.style.borderRadius = '8px';
                    });
                    calendarContainer.querySelectorAll('.flatpickr-day.flatpickr-disabled').forEach(
                        dayElem => {
                            dayElem.style.backgroundColor = '#FEE2E2'; /* Red-200 */
                            dayElem.style.borderRadius = '8px';
                        });
                },
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    const date = dayElem.dateObj;
                    const dateFormatted = fp.formatDate(date, "Y-m-d");

                    if (disabledDateReasons[dateFormatted]) {
                        dayElem.title = disabledDateReasons[dateFormatted];
                    }
                }
            });


            const jenisJasaSelect = document.getElementById('jenis_jasa');
            const tanggalSectionTitle = document.getElementById('tanggal_section_title');
            const paketPilihanSelect = document.getElementById('paket_pilihan');
            const kategoriPaketDisplay = document.getElementById('kategori_paket_display');
            const kategoriPaketInput = document.getElementById('kategori_paket');

            // Elements for conditional input (lokasi vs quantity)
            const lokasiAcaraWrapper = document.getElementById('lokasi_acara_wrapper');
            const quantityWrapper = document.getElementById('quantity_wrapper');
            const lokasiAcaraInput = document.getElementById('lokasi_acara');
            const lokasiLabel = document.getElementById('lokasi_label'); // New: Get label element
            const lokasiHelpText = document.getElementById('lokasi_help_text'); // New: Get help text element
            const quantityInput = document.getElementById('quantity');

            // Elements for price display
            const displayHargaPaket = document.getElementById('display_harga_paket');
            const hiddenHargaPaket = document.getElementById('hidden_harga_paket');
            const displaySubtotal = document.getElementById('display_subtotal');
            const hiddenSubtotalHarga = document.getElementById('hidden_subtotal_harga');
            const displayTotalHarga = document.getElementById('display_total_harga');
            const hiddenTotalHarga = document.getElementById('hidden_total_harga');
            const dpAmountInput = document.getElementById('dp_amount');
            const displayRemainingPayment = document.getElementById('display_remaining_payment');
            const hiddenRemainingPayment = document.getElementById('hidden_remaining_payment');
            const subtotalRow = document.getElementById('subtotal_row');

            // Payment type radio buttons and DP amount wrapper
            const paymentOptionDp = document.getElementById('payment_option_dp');
            const paymentOptionFull = document.getElementById('payment_option_full');
            const dpAmountWrapper = document.getElementById('dp_amount_wrapper');
            const buktiPembayaranInput = document.getElementById('bukti_pembayaran'); // Get the file input

            let allPaketsData = []; // Store all fetched package data

            // Function to format number to IDR currency
            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            }

            // Function to update label and placeholder for lokasi_acara
            function updateLokasiField(selectedJasaTipe) {
                if (selectedJasaTipe === 'percetakan') {
                    lokasiLabel.innerHTML = 'Alamat Pengiriman <span class="text-red-500">*</span>';
                    lokasiAcaraInput.placeholder = 'Contoh: Alamat Lengkap Pengiriman Anda';
                    lokasiHelpText.textContent = 'Isi alamat lengkap untuk pengiriman hasil percetakan.';
                } else {
                    lokasiLabel.innerHTML = 'Lokasi Acara <span class="text-red-500">*</span>';
                    lokasiAcaraInput.placeholder = 'Contoh: Gedung Pernikahan Harmoni, Jakarta';
                    lokasiHelpText.textContent = 'Isi lokasi acara untuk fotografi/videografi.';
                }
            }

            // New function to update the date section title
            function updateTanggalSectionTitle(selectedJasaTipe) {
                if (selectedJasaTipe === 'percetakan') {
                    tanggalSectionTitle.innerHTML = `<span class="flex items-center justify-center w-8 h-8 mr-3 text-lg font-bold text-white rounded-full bg-accent">1</span> Pilih Tanggal Jadi`;
                } else {
                    tanggalSectionTitle.innerHTML = `<span class="flex items-center justify-center w-8 h-8 mr-3 text-lg font-bold text-white rounded-full bg-accent">1</span> Pilih Tanggal Acara`;
                }
            }


            // Function to calculate and update prices
            function updatePrices() {
                const hargaPaket = parseFloat(hiddenHargaPaket.value);
                const currentJenisJasa = jenisJasaSelect.value;
                let quantity = 1;

                if (currentJenisJasa === 'percetakan') {
                    quantity = parseInt(quantityInput.value) || 0;
                    subtotalRow.classList.remove('hidden'); // Show subtotal row for percetakan
                } else {
                    subtotalRow.classList.add('hidden'); // Hide subtotal row for non-percetakan
                }

                const subtotal = hargaPaket * quantity;
                const totalHarga = subtotal; // For now, total is same as subtotal

                let dpAmount = parseFloat(dpAmountInput.value) || 0;
                const selectedPaymentOption = document.querySelector('input[name="payment_option"]:checked').value;

                if (selectedPaymentOption === 'full_payment') {
                    dpAmount = totalHarga; // If full payment, DP is equal to total price
                    dpAmountInput.value = totalHarga;
                    dpAmountWrapper.classList.add('hidden'); // Hide DP input
                    // Ganti disabled dengan readonly agar nilai tetap terkirim
                    dpAmountInput.setAttribute('readonly', 'readonly');
                } else { // 'dp' option
                    dpAmountWrapper.classList.remove('hidden'); // Show DP input
                    // Hapus readonly agar input bisa diisi
                    dpAmountInput.removeAttribute('readonly');
                    // Cap DP at total price if user inputs more than total
                    if (dpAmount > totalHarga) {
                        dpAmount = totalHarga;
                        dpAmountInput.value = totalHarga;
                    }
                }

                const remainingPayment = totalHarga - dpAmount;

                displayHargaPaket.textContent = formatRupiah(hargaPaket);
                displaySubtotal.textContent = formatRupiah(subtotal);
                hiddenSubtotalHarga.value = subtotal;
                displayTotalHarga.textContent = formatRupiah(totalHarga);
                hiddenTotalHarga.value = totalHarga;
                displayRemainingPayment.textContent = formatRupiah(remainingPayment);
                hiddenRemainingPayment.value = remainingPayment;
            }

            // Function to fetch and populate packages
            async function fetchAndPopulatePackages(selectedJasaTipe, oldPaketId = null) {
                console.log('fetchAndPopulatePackages dipanggil dengan jasa_tipe:', selectedJasaTipe,
                    'dan oldPaketId:', oldPaketId);

                paketPilihanSelect.innerHTML =
                    '<option value="" disabled selected>Memuat...</option>';
                kategoriPaketDisplay.value = '';
                kategoriPaketInput.value = '';
                hiddenHargaPaket.value = 0; // Reset harga paket
                updatePrices(); // Update prices after resetting
                updateLokasiField(selectedJasaTipe); // Update the lokasi field label/placeholder
                updateTanggalSectionTitle(selectedJasaTipe); // Update the date section title

                // Kuantitas: Hanya tampil untuk percetakan
                if (selectedJasaTipe === 'percetakan') {
                    quantityWrapper.classList.remove('hidden');
                    quantityInput.setAttribute('required', 'required'); // Kuantitas wajib untuk percetakan
                } else {
                    quantityWrapper.classList.add('hidden');
                    quantityInput.removeAttribute('required'); // Kuantitas tidak wajib untuk non-percetakan
                }

                if (selectedJasaTipe) {
                    const apiUrl = `{{ route('api.pakets.by.jasa.tipe') }}?jasa_tipe=${selectedJasaTipe}`;
                    console.log('Memanggil API:', apiUrl);
                    try {
                        const response = await fetch(apiUrl);
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        allPaketsData = await response.json(); // Store all fetched data
                        console.log('Data yang diterima dari API:', allPaketsData);

                        paketPilihanSelect.innerHTML =
                            '<option value="" disabled selected>-- Pilih Paket/Layanan --</option>';
                        if (allPaketsData.length === 0) {
                            paketPilihanSelect.innerHTML =
                                '<option value="" disabled>Tidak ada paket untuk jenis ini</option>';
                            paketPilihanSelect.value = "";
                            console.log('Tidak ada paket ditemukan untuk jenis jasa ini.');
                        } else {
                            allPaketsData.forEach(paket => {
                                const option = document.createElement('option');
                                option.value = paket.id;
                                option.textContent = paket.name;
                                paketPilihanSelect.appendChild(option);
                            });
                            console.log('Paket berhasil dimuat.');

                            let selectedValue = null;
                            if (oldPaketId) {
                                selectedValue = oldPaketId;
                                console.log('Paket lama dipilih:', oldPaketId);
                            } else if (urlParams.has('paket_id')) {
                                selectedValue = urlParams.get('paket_id');
                                console.log('Paket dari URL dipilih:', urlParams.get('paket_id'));
                            }

                            if (selectedValue) {
                                paketPilihanSelect.value = selectedValue;
                                // Manually trigger change to update category and prices
                                const event = new Event('change');
                                paketPilihanSelect.dispatchEvent(event);
                            } else if (paketPilihanSelect.options.length > 1 && paketPilihanSelect.value ===
                                "") {
                                // Optionally select the first actual option if nothing is selected yet
                                // paketPilihanSelect.selectedIndex = 1;
                                console.log(
                                    'Tidak ada paket yang dipilih, memilih opsi pertama (jika ada).'
                                );
                            }
                        }
                    } catch (error) {
                        console.error('Error fetching packages:', error);
                        paketPilihanSelect.innerHTML =
                            '<option value="" disabled selected>Gagal memuat paket</option>';
                        paketPilihanSelect.value = "";
                    }
                } else {
                    console.log('Jenis jasa tidak dipilih, mereset dropdown paket.');
                    paketPilihanSelect.innerHTML =
                        '<option value="" disabled selected>-- Pilih Paket/Layanan --</option>';
                    paketPilihanSelect.value = "";
                }
            }

            // Event listener for when jenis_jasa changes
            jenisJasaSelect.addEventListener('change', function() {
                fetchAndPopulatePackages(this.value);
            });

            // Event listener for when paket_pilihan changes
            paketPilihanSelect.addEventListener('change', function() {
                const selectedPaketId = this.value;
                const selectedPaket = allPaketsData.find(paket => paket.id == selectedPaketId);

                if (selectedPaket) {
                    kategoriPaketDisplay.value = selectedPaket.kategori;
                    kategoriPaketInput.value = selectedPaket.kategori;
                    hiddenHargaPaket.value = selectedPaket.harga_paket; // Set hidden harga paket
                    console.log('Kategori paket diatur:', selectedPaket.kategori);
                    console.log('Harga paket diatur:', selectedPaket.harga_paket);
                } else {
                    kategoriPaketDisplay.value = 'Tidak ada kategori';
                    kategoriPaketInput.value = '';
                    hiddenHargaPaket.value = 0;
                    console.log('Kategori tidak ditemukan untuk paket ini.');
                }
                updatePrices(); // Update prices whenever package changes
            });

            // Event listener for quantity input changes
            quantityInput.addEventListener('input', updatePrices);

            // Event listener for DP amount input changes
            dpAmountInput.addEventListener('input', updatePrices);

            // Event listeners for payment option radio buttons
            paymentOptionDp.addEventListener('change', updatePrices);
            paymentOptionFull.addEventListener('change', updatePrices);


            // Handle old input (if validation failed and form reloaded)
            const oldJenisJasa = "{{ old('jenis_jasa') }}";
            const oldPaketPilihan = "{{ old('paket_pilihan') }}";
            const oldKategoriPaket = "{{ old('kategori_paket') }}";
            const oldQuantity = "{{ old('quantity', 1) }}"; // Default to 1 if not set
            const oldDpAmount = "{{ old('dp_amount', 0) }}"; // Default to 0 if not set
            const oldPaymentOption = "{{ old('payment_option', 'dp') }}"; // Default to 'dp'

            quantityInput.value = oldQuantity; // Set old quantity
            dpAmountInput.value = oldDpAmount; // Set old DP amount

            // Set old payment option and trigger updatePrices
            if (oldPaymentOption === 'full_payment') {
                paymentOptionFull.checked = true;
            } else {
                paymentOptionDp.checked = true;
            }


            const urlParams = new URLSearchParams(window.location.search);
            const initialJasaTipe = urlParams.get('jasa_tipe');
            const initialPaketId = urlParams.get('paket_id');
            const initialKategoriFromUrl = urlParams.get('kategori'); // Get category from URL

            let initialSelectedJasaTipe = null;
            let initialSelectedPaketId = null;

            if (oldJenisJasa) {
                initialSelectedJasaTipe = oldJenisJasa;
                initialSelectedPaketId = oldPaketPilihan;
            } else if (initialJasaTipe) {
                initialSelectedJasaTipe = initialJasaTipe;
                initialSelectedPaketId = initialPaketId;
            }

            if (initialSelectedJasaTipe) {
                jenisJasaSelect.value = initialSelectedJasaTipe;
                setTimeout(() => {
                    fetchAndPopulatePackages(initialSelectedJasaTipe, initialSelectedPaketId);
                }, 100);
            } else {
                // If no initial jasa type, ensure prices are updated with default values
                updatePrices();
                // Also update the lokasi field and title in case no initial jasa type is set (e.g., fresh load)
                updateLokasiField('');
                updateTanggalSectionTitle('');
            }

            // Set initial category display if available (from old input or controller or URL)
            if (oldKategoriPaket) {
                kategoriPaketDisplay.value = oldKategoriPaket;
            } else if (initialKategoriFromUrl) {
                kategoriPaketDisplay.value = initialKategoriFromUrl;
                kategoriPaketInput.value = initialKategoriFromUrl; // Also set hidden input
            } else if ("{{ $initialKategori }}") {
                kategoriPaketDisplay.value = "{{ $initialKategori }}";
                kategoriPaketInput.value = "{{ $initialKategori }}";
            }

            // Initial call to updatePrices to set correct state on page load
            updatePrices();
            // Ensure location field and title are updated on initial load based on current selected value (if any)
            updateLokasiField(jenisJasaSelect.value);
            updateTanggalSectionTitle(jenisJasaSelect.value);
        });
    </script>
@endpush
