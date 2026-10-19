@extends('layouts.dashboard')

@section('title', 'Profil Instansi Perusahaan')
@section('page_title', 'Kelola Profil Instansi')
@section('page_subtitle', 'Identitas perusahaan yang ditampilkan pada katalog lowongan kerja dan laporan resmi')

@section('content')
<div class="max-w-4xl space-y-6">
    <form action="{{ route('perusahaan.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-2">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Informasi Perusahaan & Legalitas</h2>
                    <p class="text-xs text-slate-500">Data identitas mitra rekrutmen Program Studi D3 Teknik Informatika USU.</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $perusahaan->status_verifikasi === 'terverifikasi' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                    Status: {{ ucfirst($perusahaan->status_verifikasi) }}
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama_perusahaan" class="block text-xs font-semibold text-slate-700 mb-1">Nama Resmi Perusahaan</label>
                    <input type="text" id="nama_perusahaan" name="nama_perusahaan" required value="{{ old('nama_perusahaan', $perusahaan->nama_perusahaan) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('nama_perusahaan') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="bidang_industri" class="block text-xs font-semibold text-slate-700 mb-1">Bidang Industri / Sektor</label>
                    <input type="text" id="bidang_industri" name="bidang_industri" required value="{{ old('bidang_industri', $perusahaan->bidang_industri) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Information Technology, Software House">
                    @error('bidang_industri') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email_hrd" class="block text-xs font-semibold text-slate-700 mb-1">Email Resmi HRD / Rekrutmen</label>
                    <input type="email" id="email_hrd" name="email_hrd" required value="{{ old('email_hrd', $perusahaan->email_hrd) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('email_hrd') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="no_telp" class="block text-xs font-semibold text-slate-700 mb-1">Nomor Telepon Kantor / HRD</label>
                    <input type="text" id="no_telp" name="no_telp" required value="{{ old('no_telp', $perusahaan->no_telp) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('no_telp') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="kota" class="block text-xs font-semibold text-slate-700 mb-1">Kota Domisili Kantor</label>
                    <input type="text" id="kota" name="kota" required value="{{ old('kota', $perusahaan->kota) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('kota') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="website" class="block text-xs font-semibold text-slate-700 mb-1">Website Perusahaan (Opsional)</label>
                    <input type="url" id="website" name="website" value="{{ old('website', $perusahaan->website) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="https://perusahaan.co.id">
                    @error('website') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="alamat" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Kantor Lengkap</label>
                <textarea id="alamat" name="alamat" rows="2" required
                          class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('alamat', $perusahaan->alamat) }}</textarea>
                @error('alamat') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi & Profil Perusahaan</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" required
                          class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('deskripsi', $perusahaan->deskripsi) }}</textarea>
                @error('deskripsi') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Logo Upload -->
            <div class="pt-4 border-t border-slate-100 space-y-3">
                <label for="logo" class="block text-xs font-semibold text-slate-700">Logo Instansi Perusahaan (Opsional, format JPG/PNG, maks 2MB)</label>
                
                @if($perusahaan->logo)
                    <div class="flex items-center space-x-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                        <img src="{{ asset('storage/' . $perusahaan->logo) }}" alt="Logo {{ $perusahaan->nama_perusahaan }}" class="w-12 h-12 object-contain rounded-lg border border-slate-200 bg-white">
                        <span class="text-xs text-slate-600">Logo aktif digunakan pada profil lowongan dan laporan rekrutmen.</span>
                    </div>
                @endif

                <input type="file" id="logo" name="logo" accept="image/*"
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-300 rounded-lg bg-white">
                @error('logo') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-sm transition-colors">
                Simpan Perubahan Profil Perusahaan
            </button>
        </div>
    </form>
</div>
@endsection
