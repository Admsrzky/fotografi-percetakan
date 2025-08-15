<header class="sticky top-0 z-50 py-4 bg-white shadow-md">
    <nav class="container flex items-center justify-between px-4 mx-auto">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-accent">
            <img src="{{ asset('assets/images/logo1.png') }}" width="80" height="40" alt="Logo Studio">
        </a>

        {{-- Navigasi Desktop --}}
        <ul class="hidden space-x-6 md:flex">
            <li><a href="{{ route('home') }}"
                    class="font-semibold text-gray-700 transition duration-300 hover:text-accent">Beranda</a></li>
            <li class="relative" x-data="{ open: false }"> {{-- Add x-data for Alpine.js state --}}
                <a href="#" @click.prevent="open = !open" {{-- Toggle 'open' state on click --}}
                    :class="{ 'text-accent': open, 'text-gray-700': !open }" {{-- Dynamically apply text color --}}
                    class="flex items-center font-semibold transition duration-300 hover:text-accent">
                    Fotografi
                    <svg class="w-4 h-4 ml-1 transition-transform duration-300 transform"
                        :class="{ 'rotate-180': open, 'rotate-0': !open }" {{-- Rotate SVG icon --}} fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
                <ul x-show="open" {{-- Show/hide based on 'open' state --}} @click.outside="open = false" {{-- Close when clicking outside --}}
                    x-transition:enter="transition ease-out duration-200" {{-- Optional: Add transition effects --}}
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute z-50 w-48 py-2 mt-2 bg-white rounded-md shadow-lg"> {{-- Remove group-hover:block --}}
                    <li><a href="{{ url('/pakets-wedding') }}"
                        class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Photo Wedding</a>
                    </li>
                    <li><a href="{{ url('/pakets-prewedding') }}"
                            class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Photo Pre-wedding</a>
                    </li>
                    <li><a href="{{ url('/pakets-sekolah') }}"
                            class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Photo Sekolah</a>
                    </li>
                    <li><a href="{{ url('/pakets-all-event') }}"
                            class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Photo All Event</a>
                    </li>
                    <li><a href="{{ url('/pakets-vidioCinematic') }}"
                            class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Vidio Cinematic</a>
                    </li>
                    <li><a href="{{ url('/pakets-vidioLiputan') }}"
                            class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Vidio Liputan All Event</a>
                    </li>
                    {{-- <li><a href="{{ url('') }}"
                            class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Bingkai Foto All Size</a>
                    </li> --}}
                </ul>
            </li>
            <li class="relative" x-data="{ open: false }"> {{-- Add x-data for Alpine.js state --}}
                <a href="#" @click.prevent="open = !open" {{-- Toggle 'open' state on click --}}
                    :class="{ 'text-accent': open, 'text-gray-700': !open }" {{-- Dynamically apply text color --}}
                    class="flex items-center font-semibold transition duration-300 hover:text-accent">
                    Percetakan
                    <svg class="w-4 h-4 ml-1 transition-transform duration-300 transform"
                        :class="{ 'rotate-180': open, 'rotate-0': !open }" {{-- Rotate SVG icon --}} fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
                <ul x-show="open" {{-- Show/hide based on 'open' state --}} @click.outside="open = false" {{-- Close when clicking outside --}}
                    x-transition:enter="transition ease-out duration-200" {{-- Optional: Add transition effects --}}
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute z-50 w-48 py-2 mt-2 bg-white rounded-md shadow-lg"> {{-- Remove group-hover:block --}}
                    <li><a href="{{ url('/pakets-cetakIdCard') }}"
                        class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Cetak ID Card</a>
                    </li>
                    <li><a href="{{ url('/pakets-cetakFoto') }}"
                            class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Cetak Foto All Size</a>
                    </li>
                    <li><a href="{{ url('/pakets-cetakMIR') }}"
                            class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Map Ijazah dan Raport</a>
                    </li>
                    <li><a href="{{ url('/pakets-medaliSekolah') }}"
                            class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Medali Sekolah</a>
                    </li>
                    <li><a href="{{ url('/pakets-cetakJenisBuku') }}"
                            class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Cetak Jenis Buku</a>
                    </li>
                    <li><a href="{{ url('/pakets-cetakStikerLabel') }}"
                            class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Cetak Stiker Label Kemasan</a>
                    </li>
                    <li><a href="{{ url('/pakets-cetakKalender') }}"
                            class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Cetak Kalender</a>
                    </li>
                    <li><a href="{{ url('/pakets-bingkaiFoto') }}"
                            class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Bingkai Foto</a>
                    </li>
                </ul>
            </li>

            <li><a href="{{ url('/portofolio') }}"
                    class="font-semibold text-gray-700 transition duration-300 hover:text-accent">Portofolio</a>
            </li>
            <li><a href="{{ url('/tentang-kami') }}"
                    class="font-semibold text-gray-700 transition duration-300 hover:text-accent">Tentang Kami</a>
            </li>
            <li><a href="{{ url('/kontak') }}"
                    class="font-semibold text-gray-700 transition duration-300 hover:text-accent">Kontak</a></li>
        </ul>

        <div class="flex items-center space-x-4">
            @auth {{-- Tampilkan ini jika pengguna sudah login --}}
                {{-- Tombol Pesan Sekarang di samping kiri avatar --}}
                <a href="{{ route('pemesanan.form') }}"
                    class="hidden px-6 py-2 font-semibold text-white transition duration-300 rounded-full shadow-md md:block bg-accent hover:bg-accent-dark">
                    Pesan Sekarang
                </a>

                {{-- Dropdown Avatar Pengguna --}}
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = ! open" class="flex items-center focus:outline-none">
                        <img src="{{ Auth::user()->profile_photo_url ?? asset('assets/images/default-avatar.png') }}"
                            alt="{{ Auth::user()->name }}"
                            class="object-cover w-10 h-10 border-2 rounded-full border-accent">
                        {{-- Nama pengguna di sini sudah dihapus dari samping avatar --}}
                    </button>
                    <ul x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 z-20 w-48 py-2 mt-2 origin-top-right bg-white rounded-md shadow-lg">

                        {{-- Tampilkan Nama dan Email di Dropdown --}}
                        <li class="px-4 py-2 font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</li>
                        <li class="px-4 py-1 text-sm text-gray-600 truncate">{{ Auth::user()->email }}</li>
                        <li class="my-2 border-t border-gray-200"></li> {{-- Garis pemisah --}}

                        <li>
                            <a href="{{ route('profile.show') }}"
                                class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Edit
                                Profile</a>
                        </li>
                        <li>
                            <a href="{{ route('pemesanan.history') }}" {{-- Pastikan route ini ada dan benar --}}
                                class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Riwayat
                                Pesanan</a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="hidden px-6 py-2 font-semibold text-gray-700 transition duration-300 rounded-full bg-slate-100 md:block hover:text-accent">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="hidden px-6 py-2 font-semibold text-white transition duration-300 rounded-full shadow-md md:block bg-accent hover:bg-accent-dark">
                    Daftar
                </a>
            @endauth

            {{-- Hamburger Menu untuk Mobile --}}
            <div class="md:hidden" x-data="{ open: false }">
                <button @click="open = ! open" class="text-gray-700 focus:outline-none">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7">
                        </path>
                    </svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
                {{-- Overlay untuk menutup menu saat klik di luar --}}
                <div x-show="open" @click="open = false" class="fixed inset-0 z-10 bg-black opacity-50"></div>

                {{-- Menu Navigasi Mobile --}}
                <div x-show="open" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-x-full"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-full"
                    class="fixed inset-y-0 left-0 z-20 flex flex-col w-64 p-6 space-y-4 bg-white shadow-xl">
                    <button @click="open = false" class="self-end text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                    <a href="{{ route('home') }}"
                        class="block font-semibold text-gray-700 hover:text-accent">Beranda</a>

                    {{-- Fotografi Dropdown for Mobile --}}
                    <div class="relative" x-data="{ open: false }">
                        <a href="#" @click.prevent="open = !open"
                            :class="{ 'text-accent': open, 'text-gray-700': !open }"
                            class="flex items-center font-semibold text-gray-700 hover:text-accent">
                            Fotografi
                            <svg class="w-4 h-4 ml-1 transition-transform duration-300 transform"
                                :class="{ 'rotate-180': open, 'rotate-0': !open }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                        <ul x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="py-2 mt-2 space-y-1 bg-white rounded-md">
                            <li><a href="{{ url('/pakets-wedding') }}"
                                class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Photo Wedding</a>
                            </li>
                            <li><a href="{{ route('prewedding.show') }}"
                                    class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Photo Pre-wedding</a>
                            </li>
                            <li><a href="{{ route('photosekolah.show') }}"
                                    class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Photo Sekolah</a>
                            </li>
                            <li><a href="{{ url('/pakets-all-event') }}"
                                    class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Photo All Event</a>
                            </li>
                            <li><a href="{{ url('/pakets-vidioCinematic') }}"
                                    class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Vidio Cinematic</a>
                            </li>
                            <li><a href="{{ url('/pakets-vidioLiputan') }}"
                                    class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Vidio Liputan All Event</a>
                            </li>
                            {{-- <li><a href="{{ url('') }}"
                                    class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Bingkai Foto All Size</a>
                            </li> --}}
                        </ul>
                    </div>

                    {{-- Percetakan Dropdown for Mobile --}}
                    <div class="relative" x-data="{ open: false }">
                        <a href="#" @click.prevent="open = !open"
                            :class="{ 'text-accent': open, 'text-gray-700': !open }"
                            class="flex items-center font-semibold text-gray-700 hover:text-accent">
                            Percetakan
                            <svg class="w-4 h-4 ml-1 transition-transform duration-300 transform"
                                :class="{ 'rotate-180': open, 'rotate-0': !open }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                        <ul x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="py-2 mt-2 space-y-1 bg-white rounded-md">
                            <li><a href="{{ url('/pakets-cetakIdCard') }}"
                                class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Cetak ID Card</a>
                            </li>
                            <li><a href="{{ url('/pakets-cetakFoto') }}"
                                    class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Cetak Foto All Size</a>
                            </li>
                            <li><a href="{{ url('/pakets-cetakMIR') }}"
                                    class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Map Ijazah dan Raport</a>
                            </li>
                            <li><a href="{{ url('/pakets-medaliSekolah') }}"
                                    class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Medali Sekolah</a>
                            </li>
                            <li><a href="{{ url('/pakets-cetakJenisBuku') }}"
                                    class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Cetak Jenis Buku</a>
                            </li>
                            <li><a href="{{ url('/pakets-cetakStikerLabel') }}"
                                    class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Cetak Stiker Label Kemasan</a>
                            </li>
                            <li><a href="{{ url('/pakets-cetakKalender') }}"
                                    class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Cetak Kalender</a>
                            </li>
                            <li><a href="{{ url('/pakets-bingkaiFoto') }}"
                                    class="block px-4 py-2 text-gray-700 transition duration-300 hover:bg-gray-100">Bingkai Foto All Size</a>
                            </li>
                        </ul>
                    </div>

                    <a href="{{ url('/portofolio') }}"
                        class="block font-semibold text-gray-700 hover:text-accent">Portofolio</a>
                    <a href="{{ url('/tentang-kami') }}"
                        class="block font-semibold text-gray-700 hover:text-accent">Tentang Kami</a>
                    <a href="{{ url('/kontak') }}"
                        class="block font-semibold text-gray-700 hover:text-accent">Kontak</a>

                    @auth
                        <div class="pt-4 mt-4 border-t border-gray-200">
                            <h4 class="mb-2 font-semibold text-gray-500">Akun Saya</h4>
                            <a href="{{ route('profile.show') }}"
                                class="block px-2 py-1 text-gray-700 hover:bg-gray-100">Edit Profile</a>
                            <a href="" class="block px-2 py-1 text-gray-700 hover:bg-gray-100">Riwayat Pesanan</a>
                            {{-- Pastikan route ini ada dan benar --}}
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                                class="block px-2 py-1 text-gray-700 hover:bg-gray-100">Logout</a>
                            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    @else
                        <div class="pt-4 mt-4 border-t border-gray-200">
                            <a href="{{ route('login') }}"
                                class="block px-6 py-2 font-semibold text-center text-gray-700 transition duration-300 rounded-full bg-slate-100">Login</a>
                            <a href="{{ route('register') }}"
                                class="block px-6 py-2 mt-2 font-semibold text-center text-white transition duration-300 rounded-full shadow-md bg-accent hover:bg-accent-dark">Daftar</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>
