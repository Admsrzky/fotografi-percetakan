@extends('layouts.master')

@section('title', 'Tentang Kami - Studio Foto & Cetak')

@section('content')
    <section class="relative py-20 overflow-hidden bg-gradient-to-br from-gray-50 to-white">
        {{-- Background wave/pattern - optional, can be a simple gradient --}}
        <div class="absolute inset-0 z-0 opacity-20">
            <svg class="w-full h-full" fill="none" viewBox="0 0 100 100">
                <defs>
                    <pattern id="pattern-circles" x="0" y="0" width="10" height="10" patternUnits="userSpaceOnUse">
                        <circle cx="5" cy="5" r="1" fill="#cbd5e1" />
                    </pattern>
                </defs>
                <rect x="0" y="0" width="100%" height="100%" fill="url(#pattern-circles)" />
            </svg>
        </div>

        <div class="container relative z-10 px-4 mx-auto">
            <h1 class="mb-12 text-5xl font-extrabold leading-tight text-center text-gray-900">
                Tentang <span class="text-amber-600">Kami</span>
            </h1>

            <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-2xl p-10 md:p-16 border border-gray-100 transform hover:scale-[1.005] transition-transform duration-300 ease-in-out">
                <div class="space-y-8 text-lg leading-relaxed text-gray-700">
                    <p>
                        Selamat datang di RE PROJECT, destinasi utama Anda untuk mengabadikan momen berharga dan mencetak kenangan indah. Kami adalah tim fotografer dan desainer profesional yang berdedikasi untuk memberikan hasil terbaik dengan sentuhan personal.
                    </p>
                    <p>
                        Berdiri sejak 2021, RE PROJECT telah melayani ribuan klien dengan berbagai kebutuhan fotografi, mulai dari potret pribadi, acara keluarga, hingga proyek komersial. Kami percaya bahwa setiap momen memiliki cerita uniknya sendiri, dan tugas kami adalah menceritakan kisah tersebut melalui gambar yang berkualitas tinggi dan penuh emosi.
                    </p>
                    <p>
                        Didukung oleh peralatan fotografi dan percetakan canggih, serta didampingi oleh tim yang berpengalaman, kami berkomitmen untuk menghasilkan karya yang tidak hanya indah secara visual, tetapi juga tahan lama sebagai warisan kenangan Anda. Kami bangga menjadi bagian dari setiap momen spesial Anda, baik itu kelulusan, pernikahan, ulang tahun, atau sekadar potret keluarga.
                    </p>
                </div>

                {{-- Visi Kami --}}
                <div class="p-8 mt-16 border rounded-lg shadow-inner bg-amber-50 border-amber-100">
                    <h2 class="mb-6 text-4xl font-bold text-center text-amber-800">Visi Kami</h2>
                    <p class="text-xl leading-relaxed text-center text-amber-700">
                        Menjadi studio foto dan cetak terkemuka yang diakui atas kreativitas, kualitas, dan pelayanan prima dalam mengabadikan setiap kenangan berharga, menciptakan warisan visual yang tak lekang oleh waktu.
                    </p>
                </div>

                {{-- Misi Kami --}}
                <div class="p-8 mt-16 border border-blue-100 rounded-lg shadow-inner bg-blue-50">
                    <h2 class="mb-6 text-4xl font-bold text-center text-blue-800">Misi Kami</h2>
                    <ul class="space-y-4 text-xl text-blue-700 list-disc list-inside">
                        <li>Menyediakan layanan fotografi profesional dengan kualitas gambar yang tajam, artistik, dan relevan dengan kebutuhan klien.</li>
                        <li>Menawarkan solusi percetakan berkualitas tinggi menggunakan teknologi mutakhir untuk mengabadikan foto dalam bentuk fisik yang indah dan awet.</li>
                        <li>Membangun hubungan yang kuat dan personal dengan setiap klien melalui komunikasi yang transparan, responsif, dan layanan yang berpusat pada kepuasan pelanggan.</li>
                        <li>Terus berinovasi dalam teknik, teknologi, dan gaya fotografi untuk selalu memberikan hasil yang orisinal dan sesuai dengan tren terkini.</li>
                        <li>Menjaga harga yang kompetitif dan transparan, memastikan nilai terbaik bagi setiap investasi yang dipercayakan klien kepada kami.</li>
                    </ul>
                </div>

                <p class="mt-16 font-serif text-2xl italic text-center text-gray-600">
                    "Setiap gambar yang kami abadikan adalah sebuah cerita, dan setiap cetakan adalah kenangan yang terukir abadi."
                </p>

                {{-- Optional: CTA atau Quote tambahan --}}
                <div class="mt-16 text-center">
                    <p class="mb-6 text-xl text-gray-800">Siap mengabadikan momen spesial Anda bersama kami?</p>
                    <a href="{{ route('kontak') }}" class="inline-block px-10 py-4 font-semibold text-white transition-all duration-300 ease-in-out transform rounded-full shadow-lg bg-amber-600 hover:bg-amber-700 hover:scale-105">
                        Hubungi Kami Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
