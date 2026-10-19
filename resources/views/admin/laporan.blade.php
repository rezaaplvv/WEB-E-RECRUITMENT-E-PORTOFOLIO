@extends('layouts.dashboard')

@section('title', 'Laporan Eksekutif Prodi D3 TI')
@section('page_title', 'Laporan Rekapitulasi & Serapan Lulusan')
@section('page_subtitle', 'Laporan eksekutif penempatan kerja alumni Program Studi D3 Teknik Informatika, Fakultas Vokasi USU')

@section('content')
<div class="space-y-8">
    
    <!-- Header with Action Button -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900">Rekapitulasi Penyerapan Lulusan Industri</h2>
            <p class="text-xs text-slate-500">Data resmi keterhubungan talenta vokasi dengan mitra industri terverifikasi.</p>
        </div>
        <a href="{{ route('admin.laporan.pdf') }}"
           class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors flex items-center shrink-0">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Cetak Laporan Resmi PDF (Dompdf)
        </a>
    </div>

    <!-- Summary Stats Box -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase">Total Alumni Terdaftar</span>
            <p class="text-3xl font-extrabold text-slate-900 mt-2">{{ $totalPelamar }}</p>
            <span class="text-[11px] text-slate-400 mt-1 block">Kandidat siap kerja</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase">Perusahaan Mitra</span>
            <p class="text-3xl font-extrabold text-blue-600 mt-2">{{ $totalPerusahaan }}</p>
            <span class="text-[11px] text-slate-400 mt-1 block">Mitra terverifikasi</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase">Alumni Diterima Kerja</span>
            <p class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $totalDiterima }}</p>
            <span class="text-[11px] text-slate-400 mt-1 block">Lolos seleksi industri</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-emerald-200 bg-emerald-50/20 shadow-2xs">
            <span class="text-xs font-bold text-emerald-800 uppercase">Rasio Serapan Kerja</span>
            <p class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $absorptionRate }}%</p>
            <span class="text-[11px] text-emerald-700 font-semibold mt-1 block">Tingkat serapan lulusan</span>
        </div>
    </div>

    <!-- Placement Table (Diterima Kerja) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Daftar Penempatan Kerja Lulusan D3 TI USU</h2>
                <p class="text-xs text-slate-500">Daftar mahasiswa/alumni yang telah berhasil diterima bekerja pada mitra industri.</p>
            </div>
            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                {{ $penempatan->count() }} Orang Diterima
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                        <th class="py-3 px-6">No</th>
                        <th class="py-3 px-6">Kode Registrasi</th>
                        <th class="py-3 px-6">Nama Alumni</th>
                        <th class="py-3 px-6">NIM / Angkatan</th>
                        <th class="py-3 px-6">Posisi Diterima</th>
                        <th class="py-3 px-6">Perusahaan Penempatan</th>
                        <th class="py-3 px-6">Tanggal Diterima</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($penempatan as $index => $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-6 font-semibold text-slate-400">{{ $index + 1 }}</td>
                            <td class="py-3.5 px-6 font-mono font-bold text-slate-900">{{ $item->kode_lamaran }}</td>
                            <td class="py-3.5 px-6 font-bold text-slate-900">{{ $item->pelamar->user->name }}</td>
                            <td class="py-3.5 px-6">{{ $item->pelamar->nim }} &bull; {{ $item->pelamar->angkatan }} (IPK {{ number_format($item->pelamar->ipk, 2) }})</td>
                            <td class="py-3.5 px-6 font-semibold text-slate-800">{{ $item->lowongan->judul_lowongan }}</td>
                            <td class="py-3.5 px-6">
                                <span class="font-bold text-blue-700">{{ $item->lowongan->perusahaan->nama_perusahaan }}</span>
                                <span class="text-[10px] text-slate-400 block">{{ $item->lowongan->perusahaan->kota }}</span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-500">
                                {{ $item->updated_at->isoFormat('D MMMM Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500">
                                Belum ada data penempatan kerja alumni.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
