@extends('layouts.dashboard')

@section('title', 'Dashboard Administrator Prodi')
@section('page_title', 'Dashboard Ekosistem Karir D3 Teknik Informatika')
@section('page_subtitle', 'Monitoring rekrutmen terpadu, kemitraan industri, dan serapan lulusan Fakultas Vokasi USU')

@section('content')
<div class="space-y-8">
    
    <!-- Top Ecosystem Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase block">Talenta Lulusan</span>
            <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalPelamar }}</p>
            <span class="text-[10px] text-slate-400">Mahasiswa / Alumni</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase block">Mitra Terverifikasi</span>
            <p class="text-2xl font-extrabold text-blue-600 mt-1">{{ $totalPerusahaanVerified }}</p>
            <span class="text-[10px] text-slate-400">Perusahaan aktif</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase block">Mitra Pending</span>
            <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ $totalPerusahaanPending }}</p>
            <span class="text-[10px] text-slate-400">Menunggu review</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase block">Lowongan Aktif</span>
            <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalLowonganAktif }}</p>
            <span class="text-[10px] text-slate-400">Dari total {{ $totalLowongan }}</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase block">Transaksi Lamaran</span>
            <p class="text-2xl font-extrabold text-indigo-600 mt-1">{{ $totalLamaran }}</p>
            <span class="text-[10px] text-slate-400">Berkas terkirim</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-emerald-200 bg-emerald-50/20 shadow-2xs">
            <span class="text-[11px] font-bold text-emerald-800 uppercase block">Tingkat Serapan</span>
            <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $absorptionRate }}%</p>
            <span class="text-[10px] text-emerald-700 font-semibold">{{ $totalDiterima }} Lulusan diterima</span>
        </div>
    </div>

    <!-- Pending Partner Approvals Queue -->
    @if($perusahaanPending->count() > 0)
        <div class="bg-white rounded-2xl border border-amber-200 shadow-2xs overflow-hidden">
            <div class="bg-amber-500/10 px-6 py-4 border-b border-amber-200 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h2 class="text-sm font-bold text-slate-900">Permohonan Kemitraan Perusahaan Baru (Menunggu Verifikasi)</h2>
                </div>
                <a href="{{ route('admin.perusahaan.index', ['status' => 'pending']) }}" class="text-xs font-semibold text-amber-800 hover:underline">
                    Kelola Semua ({{ $totalPerusahaanPending }})
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @foreach($perusahaanPending as $p)
                    <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <h3 class="text-sm font-bold text-slate-900">{{ $p->nama_perusahaan }}</h3>
                            <p class="text-xs text-slate-500">{{ $p->bidang_industri }} &bull; {{ $p->kota }} &bull; Email: {{ $p->email_hrd }}</p>
                            <p class="text-[11px] text-slate-600 line-clamp-1 max-w-xl">{{ $p->deskripsi }}</p>
                        </div>

                        <div class="flex items-center space-x-2 shrink-0">
                            <form action="{{ route('admin.perusahaan.verifikasi', $p->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status_verifikasi" value="terverifikasi">
                                <button type="submit" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-lg shadow-2xs transition-colors flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Setujui Mitra
                                </button>
                            </form>

                            <form action="{{ route('admin.perusahaan.verifikasi', $p->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status_verifikasi" value="ditolak">
                                <button type="submit" class="px-3.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold text-xs rounded-lg border border-rose-200 transition-colors">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: System Transactions Activity -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-900">Aktivitas Rekrutmen Terkini di Seluruh Platform</h2>
                <a href="{{ route('admin.laporan') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                    Laporan Lengkap &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                            <th class="py-3 px-6">Pelamar</th>
                            <th class="py-3 px-6">Mitra & Posisi</th>
                            <th class="py-3 px-6">Waktu</th>
                            <th class="py-3 px-6 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($lamaranTerbaru as $tx)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-6">
                                    <p class="font-bold text-slate-900">{{ $tx->pelamar->user->name }}</p>
                                    <span class="text-[11px] text-slate-400">NIM: {{ $tx->pelamar->nim }}</span>
                                </td>
                                <td class="py-3.5 px-6">
                                    <p class="font-semibold text-slate-800">{{ $tx->lowongan->judul_lowongan }}</p>
                                    <span class="text-[11px] text-slate-400">{{ $tx->lowongan->perusahaan->nama_perusahaan }}</span>
                                </td>
                                <td class="py-3.5 px-6 text-slate-500">
                                    {{ $tx->created_at->isoFormat('D MMM Y, HH:mm') }}
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold {{ $tx->status_badge_classes }}">
                                        {{ $tx->status_label }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500">
                                    Belum ada transaksi rekrutmen.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Fast Actions & Reports -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-2xs space-y-4">
                <h2 class="text-sm font-bold text-slate-900 pb-2 border-b border-slate-100">Pusat Laporan & Data Prodi</h2>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Unduh rekapitulasi data penyerapan kerja lulusan D3 Teknik Informatika USU berformat PDF resmi dengan kop fakultas.
                </p>
                <div class="space-y-2 pt-2">
                    <a href="{{ route('admin.laporan') }}" class="w-full py-2.5 px-4 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Buka Laporan Eksekutif Prodi
                    </a>
                    <a href="{{ route('admin.laporan.pdf') }}" class="w-full py-2 px-4 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded-xl shadow-2xs transition-colors flex items-center justify-center">
                        Unduh Laporan PDF Langsung
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-2xs space-y-3">
                <h2 class="text-sm font-bold text-slate-900 pb-2 border-b border-slate-100">Tautan Manajemen</h2>
                <div class="flex flex-col space-y-2 text-xs">
                    <a href="{{ route('admin.perusahaan.index') }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 text-slate-700 font-medium">
                        <span>Kelola Perusahaan Mitra</span>
                        <span class="text-slate-400">&rarr;</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 text-slate-700 font-medium">
                        <span>Kelola Akun Pengguna</span>
                        <span class="text-slate-400">&rarr;</span>
                    </a>
                    <a href="{{ route('admin.lowongan.index') }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 text-slate-700 font-medium">
                        <span>Pantau Semua Lowongan</span>
                        <span class="text-slate-400">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
