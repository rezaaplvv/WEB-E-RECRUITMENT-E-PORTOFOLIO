@extends('layouts.dashboard')

@section('title', 'Biodata & Berkas CV')
@section('page_title', 'Kelola Biodata & Berkas CV')
@section('page_subtitle', 'Pastikan data akademik Anda akurat dan berkas CV selalu terbarui')

@section('content')
<div class="max-w-4xl space-y-6">
    <form action="{{ route('pelamar.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Academic & Personal Information -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-base font-bold text-slate-900">Biodata Akademik Mahasiswa</h2>
                <p class="text-xs text-slate-500">Informasi identitas resmi dan capaian akademik Program Studi D3 Teknik Informatika USU.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required value="{{ old('name', $pelamar->user->name) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email (Login)</label>
                    <input type="email" id="email" value="{{ $pelamar->user->email }}" disabled
                           class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-500 cursor-not-allowed">
                    <span class="text-[10px] text-slate-400">Email akun terikat dan tidak dapat diubah sembarangan.</span>
                </div>

                <div>
                    <label for="nim" class="block text-xs font-semibold text-slate-700 mb-1">Nomor Induk Mahasiswa (NIM)</label>
                    <input type="text" id="nim" name="nim" required value="{{ old('nim', $pelamar->nim) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('nim') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="angkatan" class="block text-xs font-semibold text-slate-700 mb-1">Angkatan</label>
                        <input type="text" id="angkatan" name="angkatan" required value="{{ old('angkatan', $pelamar->angkatan) }}"
                               class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        @error('angkatan') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="ipk" class="block text-xs font-semibold text-slate-700 mb-1">IPK Terakhir</label>
                        <input type="number" step="0.01" min="0" max="4.00" id="ipk" name="ipk" required value="{{ old('ipk', $pelamar->ipk) }}"
                               class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        @error('ipk') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="no_telp" class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp / Telepon</label>
                    <input type="text" id="no_telp" name="no_telp" required value="{{ old('no_telp', $pelamar->no_telp) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('no_telp') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="headline" class="block text-xs font-semibold text-slate-700 mb-1">Headline Profesional</label>
                    <input type="text" id="headline" name="headline" required value="{{ old('headline', $pelamar->headline) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Contoh: Full-Stack Web & Mobile Developer">
                    @error('headline') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="keahlian" class="block text-xs font-semibold text-slate-700 mb-1">Keahlian & Kemampuan Teknis (Pisahkan dengan koma)</label>
                <input type="text" id="keahlian" name="keahlian" required value="{{ old('keahlian', $pelamar->keahlian) }}"
                       class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       placeholder="Laravel, Flutter, MySQL, Tailwind CSS, Docker, RESTful API">
                @error('keahlian') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="ringkasan_profil" class="block text-xs font-semibold text-slate-700 mb-1">Ringkasan Profil Diri</label>
                <textarea id="ringkasan_profil" name="ringkasan_profil" rows="3" required
                          class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('ringkasan_profil', $pelamar->ringkasan_profil) }}</textarea>
                @error('ringkasan_profil') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="alamat" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Domisili</label>
                <textarea id="alamat" name="alamat" rows="2" required
                          class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('alamat', $pelamar->alamat) }}</textarea>
                @error('alamat') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Links & Online Presence -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-base font-bold text-slate-900">Tautan Portofolio & Repositori</h2>
                <p class="text-xs text-slate-500">Tautan repositori kode dan jejaring profesional yang akan dilihat oleh HRD mitra.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="link_github" class="block text-xs font-semibold text-slate-700 mb-1">Tautan GitHub (Wajib)</label>
                    <input type="url" id="link_github" name="link_github" required value="{{ old('link_github', $pelamar->link_github) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="https://github.com/username">
                    @error('link_github') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="link_linkedin" class="block text-xs font-semibold text-slate-700 mb-1">Tautan LinkedIn (Opsional)</label>
                    <input type="url" id="link_linkedin" name="link_linkedin" value="{{ old('link_linkedin', $pelamar->link_linkedin) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="https://linkedin.com/in/username">
                    @error('link_linkedin') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="link_portofolio_web" class="block text-xs font-semibold text-slate-700 mb-1">Website Portofolio (Opsional)</label>
                    <input type="url" id="link_portofolio_web" name="link_portofolio_web" value="{{ old('link_portofolio_web', $pelamar->link_portofolio_web) }}"
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="https://portofolio-saya.dev">
                    @error('link_portofolio_web') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Curriculum Vitae (CV) PDF Upload -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-base font-bold text-slate-900">Berkas Curriculum Vitae (CV)</h2>
                <p class="text-xs text-slate-500">Unggah berkas CV terbaru berformat PDF (maksimal 2MB).</p>
            </div>

            @if($pelamar->file_cv)
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs shrink-0">
                            PDF
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900 truncate max-w-xs sm:max-w-md">
                                Berkas CV Aktif: {{ basename($pelamar->file_cv) }}
                            </p>
                            <p class="text-[11px] text-slate-500">Tersimpan di sistem & siap digunakan saat melamar lowongan</p>
                        </div>
                    </div>
                    <a href="{{ asset('storage/' . $pelamar->file_cv) }}" target="_blank"
                       class="px-3 py-1.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg shadow-2xs transition-colors flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Buka CV
                    </a>
                </div>
            @endif

            <div>
                <label for="file_cv" class="block text-xs font-semibold text-slate-700 mb-1">
                    {{ $pelamar->file_cv ? 'Unggah Berkas CV Baru (Opsional, mengganti CV lama)' : 'Pilih Berkas CV (Wajib format PDF)' }}
                </label>
                <input type="file" id="file_cv" name="file_cv" accept=".pdf"
                       class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-300 rounded-lg bg-white">
                @error('file_cv') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl shadow-sm transition-colors">
                Simpan Perubahan Biodata & CV
            </button>
        </div>
    </form>
</div>
@endsection
