@extends('layouts.dashboard')

@section('title', 'Dashboard Pelamar')
@section('page_title', 'Dashboard Mahasiswa / Alumni')
@section('page_subtitle', 'Selamat datang di Panel E-Recruitment & E-Portofolio D3 Teknik Informatika USU')

@section('content')
<div class="space-y-8">
    
    <!-- Profile Completion Alert if incomplete -->
    @if($completionPoints < 100)
        <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center space-x-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-600">Kelengkapan Profil</span>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">{{ $completionPoints }}%</span>
                </div>
                <h2 class="text-sm font-bold text-slate-900">Tingkatkan Peluang Diterima Kerja</h2>
                <p class="text-xs text-slate-500 max-w-xl">
                    Lengkapi seluruh biodata akademik, unggah berkas CV berformat PDF, dan tambahkan portofolio proyek karya Anda agar profil Anda menarik minat HRD mitra industri.
                </p>
            </div>
            <a href="{{ route('pelamar.profil') }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-lg shrink-0 transition-colors">
                Lengkapi Profil Sekarang
            </a>
        </div>
    @endif

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase">Total Lamaran</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">{{ $totalLamaran }}</p>
            <span class="text-[11px] text-slate-400 mt-1 block">Lamaran pekerjaan terkirim</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase">Menunggu Respon</span>
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold text-slate-700 mt-2">{{ $totalMenunggu }}</p>
            <span class="text-[11px] text-slate-400 mt-1 block">Status dilamar & dilihat HRD</span>
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
            <span class="text-[11px] text-slate-400 mt-1 block">Undangan wawancara aktif</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase">Diterima Kerja</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-extrabold text-emerald-600 mt-2">{{ $totalDiterima }}</p>
            <span class="text-[11px] text-slate-400 mt-1 block">Penawaran kerja resmi</span>
        </div>
    </div>

    <!-- Active Interview Invitations Notification Box -->
    @if($jadwalInterview->count() > 0)
        <div class="bg-white rounded-2xl border border-amber-200 shadow-2xs overflow-hidden">
            <div class="bg-amber-500/10 px-6 py-4 border-b border-amber-200 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <h2 class="text-sm font-bold text-slate-900">Jadwal Undangan Wawancara (E-Interview) Terdekat</h2>
                </div>
                <span class="text-xs font-semibold text-amber-700">{{ $jadwalInterview->count() }} Undangan</span>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($jadwalInterview as $inv)
                    <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-blue-600">{{ $inv->lowongan->perusahaan->nama_perusahaan }}</span>
                            <h3 class="text-base font-bold text-slate-900">{{ $inv->lowongan->judul_lowongan }}</h3>
                            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-600 pt-1">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $inv->jadwal_interview?->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB
                                </span>
                                <span class="flex items-center">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                                    Metode: {{ $inv->metode_interview }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 shrink-0">
                            <a href="{{ route('pelamar.lamaran.show', $inv->kode_lamaran) }}" class="px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                                Detail Pelacakan
                            </a>
                            <a href="{{ route('pelamar.lamaran.cetak-interview', $inv->kode_lamaran) }}" class="px-3.5 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-2xs transition-colors flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Unduh Undangan (PDF)
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Recent Applications Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900">Riwayat Lamaran Pekerjaan Terbaru</h2>
            <a href="{{ route('pelamar.lamaran.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                Lihat Semua Lamaran &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                        <th class="py-3 px-6">Kode Lamaran</th>
                        <th class="py-3 px-6">Posisi & Perusahaan</th>
                        <th class="py-3 px-6">Tanggal Kirim</th>
                        <th class="py-3 px-6">Status Terkini</th>
                        <th class="py-3 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($lamaranTerbaru as $lam)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-6 font-mono font-bold text-slate-900">
                                {{ $lam->kode_lamaran }}
                            </td>
                            <td class="py-3.5 px-6">
                                <p class="font-bold text-slate-900">{{ $lam->lowongan->judul_lowongan }}</p>
                                <p class="text-[11px] text-slate-500">{{ $lam->lowongan->perusahaan->nama_perusahaan }}</p>
                            </td>
                            <td class="py-3.5 px-6 text-slate-500">
                                {{ $lam->created_at->isoFormat('D MMM Y, HH:mm') }}
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $lam->status_badge_classes }}">
                                    {{ $lam->status_label }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <a href="{{ route('pelamar.lamaran.show', $lam->kode_lamaran) }}" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800">
                                    Tracking Status
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-500">
                                Anda belum memiliki riwayat lamaran pekerjaan. <a href="{{ route('lowongan.index') }}" class="text-blue-600 underline font-semibold">Cari lowongan sekarang</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
