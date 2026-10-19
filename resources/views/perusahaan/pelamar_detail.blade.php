@extends('layouts.dashboard')

@section('title', 'Review Kandidat - ' . $lamaran->pelamar->user->name)
@section('page_title', 'Penilaian Kandidat & Penjadwalan Interview')
@section('page_subtitle', 'Kode Registrasi: ' . $lamaran->kode_lamaran . ' &bull; Posisi: ' . $lamaran->lowongan->judul_lowongan)

@section('content')
<div class="max-w-5xl space-y-8" x-data="{
    status: '{{ old('status_lamaran', $lamaran->status_lamaran) }}'
}">

    <!-- Top Candidate Overview Header -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-start sm:items-center space-x-4">
            <div class="w-16 h-16 rounded-2xl bg-blue-600 text-white font-bold flex items-center justify-center text-2xl shrink-0 shadow-2xs">
                {{ substr($lamaran->pelamar->user->name, 0, 1) }}
            </div>
            <div>
                <div class="flex items-center space-x-2">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                        {{ $lamaran->pelamar->user->name }}
                    </h1>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                        IPK {{ number_format($lamaran->pelamar->ipk, 2) }}
                    </span>
                </div>
                <p class="text-xs sm:text-sm font-semibold text-slate-600 mt-1">
                    {{ $lamaran->pelamar->headline }}
                </p>
                <p class="text-xs text-slate-400 mt-0.5">
                    NIM: <strong>{{ $lamaran->pelamar->nim }}</strong> &bull; Angkatan: {{ $lamaran->pelamar->angkatan }} &bull; D3 Teknik Informatika USU
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ asset('storage/' . $lamaran->cv_snapshot) }}" target="_blank"
               class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-2xs transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Buka CV Snapshot (PDF)
            </a>

            <a href="{{ $lamaran->github_snapshot }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                </svg>
                GitHub Profil
            </a>

            <a href="{{ route('talenta.detail', $lamaran->pelamar->id) }}" target="_blank"
               class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                Portofolio Publik
            </a>
        </div>
    </div>

    <!-- Cover Letter / Surat Lamaran -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-3">
        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Surat Lamaran (Cover Letter) Kandidat</h2>
        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-700 leading-relaxed whitespace-pre-line">
            {{ $lamaran->surat_lamaran }}
        </div>
    </div>

    <!-- Candidate Portfolio Projects Showcase -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Proyek Karya E-Portofolio ({{ $lamaran->pelamar->portofolio->count() }})</h2>
                <p class="text-xs text-slate-500">Karya terdaftar yang telah diunggah kandidat ke sistem.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($lamaran->pelamar->portofolio as $proyek)
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-blue-50 text-blue-700 border border-blue-200">
                            {{ $proyek->kategori }}
                        </span>
                        <a href="{{ $proyek->link_github }}" target="_blank" rel="noopener noreferrer" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center">
                            Repo &rarr;
                        </a>
                    </div>
                    <h3 class="text-xs font-bold text-slate-900">{{ $proyek->judul_proyek }}</h3>
                    <p class="text-[11px] text-slate-600 line-clamp-2">{{ $proyek->deskripsi }}</p>
                    <p class="text-[10px] text-slate-400 font-mono">Stack: {{ $proyek->tech_stack }}</p>
                </div>
            @empty
                <div class="col-span-full py-4 text-center text-xs text-slate-400">
                    Kandidat belum mencantumkan karya portofolio tambahan.
                </div>
            @endforelse
        </div>
    </div>

    <!-- HR Action Form: Status Update & E-Interview Scheduling -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-6">
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-base font-bold text-slate-900">Keputusan Seleksi & Penjadwalan Wawancara (E-Interview)</h2>
            <p class="text-xs text-slate-500">Perbarui status pelamar dan atur jadwal wawancara untuk mengundang kandidat secara resmi.</p>
        </div>

        <form action="{{ route('perusahaan.pelamar.status', $lamaran->id) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Status Choice Radio Grid -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-2">Tentukan Status Seleksi:</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <label class="p-3 border rounded-xl cursor-pointer transition-all flex items-center space-x-2"
                           :class="status === 'dilihat' ? 'border-blue-500 bg-blue-50/50' : 'border-slate-200 bg-white hover:bg-slate-50'">
                        <input type="radio" name="status_lamaran" value="dilihat" x-model="status" class="text-blue-600">
                        <span class="text-xs font-semibold text-slate-800">Ditinjau (Dilihat)</span>
                    </label>

                    <label class="p-3 border rounded-xl cursor-pointer transition-all flex items-center space-x-2"
                           :class="status === 'interview' ? 'border-amber-500 bg-amber-50/50' : 'border-slate-200 bg-white hover:bg-slate-50'">
                        <input type="radio" name="status_lamaran" value="interview" x-model="status" class="text-amber-600">
                        <span class="text-xs font-semibold text-slate-800">Tahap Interview</span>
                    </label>

                    <label class="p-3 border rounded-xl cursor-pointer transition-all flex items-center space-x-2"
                           :class="status === 'diterima' ? 'border-emerald-500 bg-emerald-50/50' : 'border-slate-200 bg-white hover:bg-slate-50'">
                        <input type="radio" name="status_lamaran" value="diterima" x-model="status" class="text-emerald-600">
                        <span class="text-xs font-semibold text-slate-800">Diterima Bekerja</span>
                    </label>

                    <label class="p-3 border rounded-xl cursor-pointer transition-all flex items-center space-x-2"
                           :class="status === 'ditolak' ? 'border-rose-500 bg-rose-50/50' : 'border-slate-200 bg-white hover:bg-slate-50'">
                        <input type="radio" name="status_lamaran" value="ditolak" x-model="status" class="text-rose-600">
                        <span class="text-xs font-semibold text-slate-800">Tidak Lolos</span>
                    </label>
                </div>
            </div>

            <!-- E-Interview Scheduling Box (Shown when interview status selected) -->
            <div x-show="status === 'interview'" x-transition class="p-5 bg-amber-50/50 border border-amber-200 rounded-2xl space-y-4">
                <div class="flex items-center space-x-2 pb-2 border-b border-amber-200">
                    <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Konfigurasi Jadwal E-Interview</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="jadwal_interview" class="block text-xs font-semibold text-slate-700 mb-1">Tanggal & Waktu Interview</label>
                        <input type="datetime-local" id="jadwal_interview" name="jadwal_interview"
                               value="{{ old('jadwal_interview', $lamaran->jadwal_interview ? $lamaran->jadwal_interview->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-3 py-2 text-xs bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        @error('jadwal_interview') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="metode_interview" class="block text-xs font-semibold text-slate-700 mb-1">Metode Pelaksanaan</label>
                        <select id="metode_interview" name="metode_interview"
                                class="w-full px-3 py-2 text-xs bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="Online" {{ old('metode_interview', $lamaran->metode_interview) == 'Online' ? 'selected' : '' }}>Online (Google Meet / Zoom)</option>
                            <option value="Offline" {{ old('metode_interview', $lamaran->metode_interview) == 'Offline' ? 'selected' : '' }}>Offline (Tatap Muka di Kantor)</option>
                        </select>
                        @error('metode_interview') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="link_atau_lokasi_interview" class="block text-xs font-semibold text-slate-700 mb-1">Tautan Virtual Meeting / Alamat Ruangan</label>
                    <input type="text" id="link_atau_lokasi_interview" name="link_atau_lokasi_interview"
                           value="{{ old('link_atau_lokasi_interview', $lamaran->link_atau_lokasi_interview) }}"
                           placeholder="https://meet.google.com/xyz-abc atau Ruang Rapat Lt. 2 Kantor Medan"
                           class="w-full px-3 py-2 text-xs bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('link_atau_lokasi_interview') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- HR Notes -->
            <div>
                <label for="catatan_hrd" class="block text-xs font-semibold text-slate-700 mb-1">Catatan Tambahan / Umpan Balik HRD</label>
                <textarea id="catatan_hrd" name="catatan_hrd" rows="3"
                          class="w-full px-3 py-2 text-xs bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                          placeholder="Catatan ini akan dapat dibaca oleh kandidat pada halaman tracking status lamaran...">{{ old('catatan_hrd', $lamaran->catatan_hrd) }}</textarea>
                @error('catatan_hrd') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-100">
                <a href="{{ route('perusahaan.pelamar.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-xl shadow-sm transition-colors">
                    Simpan Keputusan & Perbarui Status
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
