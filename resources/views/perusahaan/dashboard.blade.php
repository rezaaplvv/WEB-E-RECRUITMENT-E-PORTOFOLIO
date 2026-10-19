@extends('layouts.dashboard')

@section('title', 'Dashboard Perusahaan')
@section('page_title', 'Dashboard Mitra Industri')
@section('page_subtitle', $perusahaan->nama_perusahaan . ' - Panel Rekrutmen & Talent Acquisition')

@section('content')
<div class="space-y-8">
    
    <!-- Verification Status Banner -->
    @if($perusahaan->status_verifikasi === 'pending')
        <div class="p-5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 font-bold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold">Akun Dalam Proses Verifikasi</h2>
                    <p class="text-xs text-amber-800">
                        Pendaftaran kemitraan instansi Anda sedang ditinjau oleh Admin Program Studi D3 Teknik Informatika USU.
                    </p>
                </div>
            </div>
            <span class="px-3 py-1 bg-amber-200 text-amber-900 rounded-full text-xs font-semibold shrink-0">
                Menunggu Persetujuan
            </span>
        </div>
    @elseif($perusahaan->status_verifikasi === 'terverifikasi')
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span class="text-xs font-bold">Mitra Industri Terverifikasi Resmi Prodi D3 TI USU</span>
            </div>
            <a href="{{ route('perusahaan.lowongan.create') }}" class="text-xs font-semibold text-emerald-900 underline hover:text-emerald-700">
                + Pasang Lowongan Baru
            </a>
        </div>
    @endif

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase">Lowongan Aktif</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">{{ $totalLowonganAktif }}</p>
            <span class="text-[11px] text-slate-400 mt-1 block">Posisi sedang dibuka</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase">Total Pelamar Masuk</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">{{ $totalPelamar }}</p>
            <span class="text-[11px] text-slate-400 mt-1 block">Kandidat mahasiswa melamar</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase">Tahap Interview</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-2">{{ $totalInterview }}</p>
            <span class="text-[11px] text-slate-400 mt-1 block">Kandidat dijadwalkan wawancara</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase">Kandidat Diterima</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold text-emerald-600 mt-2">{{ $totalDiterima }}</p>
            <span class="text-[11px] text-slate-400 mt-1 block">Kandidat lolos rekrutmen</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Recent Applicants Table -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-900">Pelamar Masuk Terbaru</h2>
                <a href="{{ route('perusahaan.pelamar.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                    Buka Seleksi Pelamar &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                            <th class="py-3 px-6">Kandidat</th>
                            <th class="py-3 px-6">Posisi Lowongan</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($lamaranTerbaru as $lam)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-6">
                                    <p class="font-bold text-slate-900">{{ $lam->pelamar->user->name }}</p>
                                    <p class="text-[11px] text-slate-400">NIM: {{ $lam->pelamar->nim }} &bull; IPK: {{ number_format($lam->pelamar->ipk, 2) }}</p>
                                </td>
                                <td class="py-3.5 px-6">
                                    <p class="font-semibold text-slate-800">{{ $lam->lowongan->judul_lowongan }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $lam->created_at->isoFormat('D MMM Y') }}</p>
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $lam->status_badge_classes }}">
                                        {{ $lam->status_label }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    <a href="{{ route('perusahaan.pelamar.detail', $lam->id) }}" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800">
                                        Periksa Berkas
                                        <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500">
                                    Belum ada berkas lamaran yang masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Lowongan Preview -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-2xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h2 class="text-sm font-bold text-slate-900">Lowongan Anda</h2>
                <a href="{{ route('perusahaan.lowongan.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                    Kelola
                </a>
            </div>

            <div class="space-y-3">
                @forelse($lowonganList as $vac)
                    <div class="p-3.5 rounded-xl border {{ $vac->status_aktif ? 'border-slate-200 bg-slate-50' : 'border-slate-100 bg-slate-100/50 opacity-60' }}">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded {{ $vac->status_aktif ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                {{ $vac->status_aktif ? 'Aktif' : 'Tutup' }}
                            </span>
                            <span class="text-xs font-bold text-slate-700">{{ $vac->lamaran_count }} Pelamar</span>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900 line-clamp-1">{{ $vac->judul_lowongan }}</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $vac->tipe_pekerjaan }} &bull; {{ $vac->sistem_kerja }}</p>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 py-4 text-center">Belum ada lowongan yang dipasang.</p>
                @endforelse
            </div>

            <a href="{{ route('perusahaan.lowongan.create') }}" class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors flex items-center justify-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Lowongan Pekerjaan Baru
            </a>
        </div>
    </div>
</div>
@endsection
