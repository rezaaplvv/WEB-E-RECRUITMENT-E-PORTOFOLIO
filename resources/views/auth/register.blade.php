@extends('layouts.app')

@section('title', 'Pendaftaran Akun - E-Recruitment D3 TI USU')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8" x-data="{ tab: 'pelamar' }">
    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
        
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Registrasi Akun Baru</h1>
            <p class="mt-2 text-sm text-slate-600">Pilih jenis akun sesuai dengan peran Anda di portal E-Recruitment & E-Portofolio</p>
            
            <!-- Dual-Role Tab Selector -->
            <div class="inline-flex p-1 bg-slate-100 rounded-xl mt-6 border border-slate-200">
                <button type="button" @click="tab = 'pelamar'"
                        :class="tab === 'pelamar' ? 'bg-white text-blue-600 shadow-xs font-semibold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                        class="px-5 py-2 text-sm rounded-lg transition-all flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Pelamar (Mahasiswa/Alumni)</span>
                </button>
                <button type="button" @click="tab = 'perusahaan'"
                        :class="tab === 'perusahaan' ? 'bg-white text-blue-600 shadow-xs font-semibold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                        class="px-5 py-2 text-sm rounded-lg transition-all flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Perusahaan Mitra</span>
                </button>
            </div>
        </div>

        {{-- FORM 1: PELAMAR (MAHASISWA/ALUMNI) --}}
        <div x-show="tab === 'pelamar'" x-transition>
            <form action="{{ route('register.pelamar') }}" method="POST" class="space-y-6">
                @csrf
                <div class="border-b border-slate-200 pb-4">
                    <h2 class="text-base font-semibold text-slate-900">Informasi Pribadi & Kontak</h2>
                    <p class="text-xs text-slate-500">Data akun login dan profil dasar lulusan D3 Teknik Informatika.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name_pelamar" class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <input id="name_pelamar" name="name" type="text" required value="{{ old('name') }}"
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="Nama Lengkap Beserta Gelar">
                        @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email_pelamar" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email Aktif</label>
                        <input id="email_pelamar" name="email" type="email" required value="{{ old('email') }}"
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="nama@mahasiswa.usu.ac.id">
                        @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="nim" class="block text-xs font-semibold text-slate-700 mb-1">Nomor Induk Mahasiswa (NIM)</label>
                        <input id="nim" name="nim" type="text" required value="{{ old('nim') }}"
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="Contoh: 230501001">
                        @error('nim') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="angkatan" class="block text-xs font-semibold text-slate-700 mb-1">Angkatan</label>
                            <input id="angkatan" name="angkatan" type="text" required value="{{ old('angkatan', '2023') }}"
                                   class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                   placeholder="2023">
                            @error('angkatan') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="ipk" class="block text-xs font-semibold text-slate-700 mb-1">IPK Terakhir</label>
                            <input id="ipk" name="ipk" type="number" step="0.01" min="0" max="4.00" required value="{{ old('ipk') }}"
                                   class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                   placeholder="3.80">
                            @error('ipk') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="no_telp_pelamar" class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp / Telp</label>
                        <input id="no_telp_pelamar" name="no_telp" type="text" required value="{{ old('no_telp') }}"
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="08xxxxxxxxxx">
                        @error('no_telp') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="link_github" class="block text-xs font-semibold text-slate-700 mb-1">Link Repository GitHub</label>
                        <input id="link_github" name="link_github" type="url" required value="{{ old('link_github') }}"
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="https://github.com/username">
                        @error('link_github') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="headline" class="block text-xs font-semibold text-slate-700 mb-1">Headline Profesional</label>
                    <input id="headline" name="headline" type="text" required value="{{ old('headline') }}"
                           class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Contoh: Junior Full-Stack Web Developer | Laravel & Tailwind Enthusiast">
                    @error('headline') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="keahlian" class="block text-xs font-semibold text-slate-700 mb-1">Keahlian Utama (Pisahkan dengan koma)</label>
                    <input id="keahlian" name="keahlian" type="text" required value="{{ old('keahlian') }}"
                           class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Laravel, MySQL, Flutter, Tailwind CSS, RESTful API">
                    @error('keahlian') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="alamat_pelamar" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Domisili</label>
                    <textarea id="alamat_pelamar" name="alamat" rows="2" required
                              class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                              placeholder="Alamat lengkap tempat tinggal saat ini di Kota Medan atau sekitarnya">{{ old('alamat') }}</textarea>
                    @error('alamat') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-200">
                    <div>
                        <label for="password_pelamar" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi (Min. 8 karakter)</label>
                        <input id="password_pelamar" name="password" type="password" required
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="••••••••">
                        @error('password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation_pelamar" class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation_pelamar" name="password_confirmation" type="password" required
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-lg shadow-sm transition-colors">
                    Daftar Sebagai Pelamar
                </button>
            </form>
        </div>

        {{-- FORM 2: PERUSAHAAN (MITRA INDUSTRI) --}}
        <div x-show="tab === 'perusahaan'" x-transition style="display: none;">
            <form action="{{ route('register.perusahaan') }}" method="POST" class="space-y-6">
                @csrf
                <div class="border-b border-slate-200 pb-4">
                    <h2 class="text-base font-semibold text-slate-900">Profil Instansi Perusahaan</h2>
                    <p class="text-xs text-slate-500">Akun perusahaan akan diverifikasi oleh Admin Prodi D3 Teknik Informatika sebelum dapat mempublikasikan lowongan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_perusahaan" class="block text-xs font-semibold text-slate-700 mb-1">Nama Resmi Perusahaan / PT / CV</label>
                        <input id="nama_perusahaan" name="nama_perusahaan" type="text" required value="{{ old('nama_perusahaan') }}"
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="PT Medan Teknologi Nusantara">
                        @error('nama_perusahaan') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email_perusahaan" class="block text-xs font-semibold text-slate-700 mb-1">Email Resmi HRD / Rekrutmen</label>
                        <input id="email_perusahaan" name="email" type="email" required value="{{ old('email') }}"
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="recruitment@perusahaan.co.id">
                        @error('email') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="bidang_industri" class="block text-xs font-semibold text-slate-700 mb-1">Bidang Industri</label>
                        <input id="bidang_industri" name="bidang_industri" type="text" required value="{{ old('bidang_industri') }}"
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="Software House, Fintech, Telekomunikasi">
                        @error('bidang_industri') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="kota" class="block text-xs font-semibold text-slate-700 mb-1">Kota Domisili Kantor</label>
                        <input id="kota" name="kota" type="text" required value="{{ old('kota', 'Kota Medan') }}"
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="Kota Medan">
                        @error('kota') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="no_telp_perusahaan" class="block text-xs font-semibold text-slate-700 mb-1">Nomor Telepon Kantor / HRD</label>
                        <input id="no_telp_perusahaan" name="no_telp" type="text" required value="{{ old('no_telp') }}"
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="061-xxxxxxx / 0812xxxxxxxx">
                        @error('no_telp') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="website" class="block text-xs font-semibold text-slate-700 mb-1">Website Perusahaan (Opsional)</label>
                        <input id="website" name="website" type="url" value="{{ old('website') }}"
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="https://perusahaan.co.id">
                        @error('website') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="alamat_perusahaan" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Kantor Lengkap</label>
                    <textarea id="alamat_perusahaan" name="alamat" rows="2" required
                              class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                              placeholder="Alamat kantor / gedung operasional">{{ old('alamat') }}</textarea>
                    @error('alamat') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="deskripsi_perusahaan" class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Singkat Profil Perusahaan</label>
                    <textarea id="deskripsi_perusahaan" name="deskripsi" rows="3" required
                              class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                              placeholder="Jelaskan bidang usaha utama, visi, dan budaya kerja perusahaan">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-200">
                    <div>
                        <label for="password_perusahaan" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi (Min. 8 karakter)</label>
                        <input id="password_perusahaan" name="password" type="password" required
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="••••••••">
                        @error('password') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation_perusahaan" class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation_perusahaan" name="password_confirmation" type="password" required
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-lg shadow-sm transition-colors">
                    Daftar Sebagai Perusahaan Mitra
                </button>
            </form>
        </div>

        <div class="text-center text-xs text-slate-500 pt-6 mt-6 border-t border-slate-100">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection
