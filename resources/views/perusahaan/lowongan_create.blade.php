@extends('layouts.dashboard')

@section('title', 'Pasang Lowongan Baru')
@section('page_title', 'Publikasi Lowongan Pekerjaan Baru')
@section('page_subtitle', 'Buka kesempatan karir dan jangkau talenta lulusan D3 Teknik Informatika USU')

@section('content')
<div class="max-w-4xl space-y-6">
    <form action="{{ route('perusahaan.lowongan.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-base font-bold text-slate-900">Detail Posisi Pekerjaan</h2>
                <p class="text-xs text-slate-500">Informasi spesifik terkait posisi yang dibutuhkan di instansi Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="judul_lowongan" class="block text-xs font-semibold text-slate-700 mb-1">Judul Posisi Pekerjaan (Job Title)</label>
                    <input type="text" id="judul_lowongan" name="judul_lowongan" required value="{{ old('judul_lowongan') }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Contoh: Junior Full-Stack Web Developer (Laravel)">
                    @error('judul_lowongan') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="kategori_bidang" class="block text-xs font-semibold text-slate-700 mb-1">Kategori Bidang</label>
                    <input type="text" id="kategori_bidang" name="kategori_bidang" required value="{{ old('kategori_bidang') }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Web Development, Mobile Apps, UI/UX, Network, AI">
                    @error('kategori_bidang') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tipe_pekerjaan" class="block text-xs font-semibold text-slate-700 mb-1">Tipe Pekerjaan</label>
                    <select id="tipe_pekerjaan" name="tipe_pekerjaan" required class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="Full-time" {{ old('tipe_pekerjaan') == 'Full-time' ? 'selected' : '' }}>Full-time (Penuh Waktu)</option>
                        <option value="Internship" {{ old('tipe_pekerjaan') == 'Internship' ? 'selected' : '' }}>Internship (Magang Industri)</option>
                        <option value="Part-time" {{ old('tipe_pekerjaan') == 'Part-time' ? 'selected' : '' }}>Part-time (Paruh Waktu)</option>
                        <option value="Contract" {{ old('tipe_pekerjaan') == 'Contract' ? 'selected' : '' }}>Contract (Kontrak)</option>
                    </select>
                    @error('tipe_pekerjaan') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="sistem_kerja" class="block text-xs font-semibold text-slate-700 mb-1">Sistem Kerja</label>
                    <select id="sistem_kerja" name="sistem_kerja" required class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="On-site" {{ old('sistem_kerja') == 'On-site' ? 'selected' : '' }}>On-site (Di Kantor)</option>
                        <option value="Remote" {{ old('sistem_kerja') == 'Remote' ? 'selected' : '' }}>Remote (Jarak Jauh / WFH)</option>
                        <option value="Hybrid" {{ old('sistem_kerja') == 'Hybrid' ? 'selected' : '' }}>Hybrid (Kombinasi)</option>
                    </select>
                    @error('sistem_kerja') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="lokasi" class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Kerja</label>
                    <input type="text" id="lokasi" name="lokasi" required value="{{ old('lokasi', 'Medan, Sumatera Utara') }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Contoh: Medan Baru, Kota Medan">
                    @error('lokasi') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="rentang_gaji" class="block text-xs font-semibold text-slate-700 mb-1">Rentang Gaji / Kompensasi</label>
                    <input type="text" id="rentang_gaji" name="rentang_gaji" required value="{{ old('rentang_gaji') }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Contoh: Rp 4.500.000 - Rp 6.500.000">
                    @error('rentang_gaji') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="batas_lamaran" class="block text-xs font-semibold text-slate-700 mb-1">Batas Waktu Pengajuan Lamaran</label>
                    <input type="date" id="batas_lamaran" name="batas_lamaran" required value="{{ old('batas_lamaran', now()->addDays(30)->toDateString()) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('batas_lamaran') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="deskripsi_pekerjaan" class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Tugas & Tanggung Jawab</label>
                <textarea id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" rows="4" required
                          class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                          placeholder="Jelaskan peran pekerjaan harian, proyek yang akan ditangani, dan ekosistem tim">{{ old('deskripsi_pekerjaan') }}</textarea>
                @error('deskripsi_pekerjaan') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="kualifikasi" class="block text-xs font-semibold text-slate-700 mb-1">Kualifikasi & Persyaratan Khusus</label>
                <textarea id="kualifikasi" name="kualifikasi" rows="4" required
                          class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                          placeholder="Cantumkan standar penguasaan bahasa pemrograman (PHP/Laravel/Flutter), basis data, soft skills, dan berkas portofolio">{{ old('kualifikasi') }}</textarea>
                @error('kualifikasi') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('perusahaan.lowongan.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-sm transition-colors">
                Terbitkan Lowongan Kerja
            </button>
        </div>
    </form>
</div>
@endsection
