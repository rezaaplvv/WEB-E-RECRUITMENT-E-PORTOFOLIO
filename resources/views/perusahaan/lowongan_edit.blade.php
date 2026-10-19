@extends('layouts.dashboard')

@section('title', 'Edit Lowongan ' . $lowongan->judul_lowongan)
@section('page_title', 'Perbarui Lowongan Pekerjaan')
@section('page_subtitle', 'Ubah rincian posisi, batas waktu, dan status aktif publikasi lowongan')

@section('content')
<div class="max-w-4xl space-y-6">
    <form action="{{ route('perusahaan.lowongan.update', $lowongan->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Perubahan Rincian Lowongan</h2>
                    <p class="text-xs text-slate-500">Slug tautan lowongan dipertahankan untuk menjaga keaslian tautan publik.</p>
                </div>
                <div class="flex items-center space-x-2">
                    <label for="status_aktif" class="text-xs font-semibold text-slate-700">Status Publikasi:</label>
                    <select id="status_aktif" name="status_aktif" class="px-2.5 py-1 text-xs bg-white border border-slate-300 rounded-lg text-slate-800 font-semibold focus:outline-none">
                        <option value="1" {{ old('status_aktif', $lowongan->status_aktif) ? 'selected' : '' }}>Dibuka (Aktif)</option>
                        <option value="0" {{ !old('status_aktif', $lowongan->status_aktif) ? 'selected' : '' }}>Ditutup</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="judul_lowongan" class="block text-xs font-semibold text-slate-700 mb-1">Judul Posisi Pekerjaan</label>
                    <input type="text" id="judul_lowongan" name="judul_lowongan" required value="{{ old('judul_lowongan', $lowongan->judul_lowongan) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('judul_lowongan') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="kategori_bidang" class="block text-xs font-semibold text-slate-700 mb-1">Kategori Bidang</label>
                    <input type="text" id="kategori_bidang" name="kategori_bidang" required value="{{ old('kategori_bidang', $lowongan->kategori_bidang) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('kategori_bidang') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tipe_pekerjaan" class="block text-xs font-semibold text-slate-700 mb-1">Tipe Pekerjaan</label>
                    <select id="tipe_pekerjaan" name="tipe_pekerjaan" required class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="Full-time" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="Internship" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Internship' ? 'selected' : '' }}>Internship</option>
                        <option value="Part-time" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="Contract" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Contract' ? 'selected' : '' }}>Contract</option>
                    </select>
                </div>

                <div>
                    <label for="sistem_kerja" class="block text-xs font-semibold text-slate-700 mb-1">Sistem Kerja</label>
                    <select id="sistem_kerja" name="sistem_kerja" required class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="On-site" {{ old('sistem_kerja', $lowongan->sistem_kerja) == 'On-site' ? 'selected' : '' }}>On-site</option>
                        <option value="Remote" {{ old('sistem_kerja', $lowongan->sistem_kerja) == 'Remote' ? 'selected' : '' }}>Remote</option>
                        <option value="Hybrid" {{ old('sistem_kerja', $lowongan->sistem_kerja) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>

                <div>
                    <label for="lokasi" class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Kerja</label>
                    <input type="text" id="lokasi" name="lokasi" required value="{{ old('lokasi', $lowongan->lokasi) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label for="rentang_gaji" class="block text-xs font-semibold text-slate-700 mb-1">Rentang Gaji / Kompensasi</label>
                    <input type="text" id="rentang_gaji" name="rentang_gaji" required value="{{ old('rentang_gaji', $lowongan->rentang_gaji) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label for="batas_lamaran" class="block text-xs font-semibold text-slate-700 mb-1">Batas Waktu Pengajuan</label>
                    <input type="date" id="batas_lamaran" name="batas_lamaran" required value="{{ old('batas_lamaran', $lowongan->batas_lamaran->toDateString()) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label for="deskripsi_pekerjaan" class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Pekerjaan</label>
                <textarea id="deskripsi_pekerjaan" name="deskripsi_pekerjaan" rows="4" required
                          class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('deskripsi_pekerjaan', $lowongan->deskripsi_pekerjaan) }}</textarea>
            </div>

            <div>
                <label for="kualifikasi" class="block text-xs font-semibold text-slate-700 mb-1">Kualifikasi Persyaratan</label>
                <textarea id="kualifikasi" name="kualifikasi" rows="4" required
                          class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('kualifikasi', $lowongan->kualifikasi) }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('perusahaan.lowongan.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-sm transition-colors">
                Simpan Perubahan Lowongan
            </button>
        </div>
    </form>
</div>
@endsection
