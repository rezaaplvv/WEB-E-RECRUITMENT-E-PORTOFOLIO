@extends('layouts.dashboard')

@section('title', 'Tracking Lamaran Saya')
@section('page_title', 'Status & Riwayat Lamaran Pekerjaan')
@section('page_subtitle', 'Pantau perkembangan proses rekrutmen elektronik dari mitra industri')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900">Total Lamaran Terkirim ({{ $lamaran->total() }})</h2>
            <p class="text-xs text-slate-500">Setiap pembaruan status seleksi dari HRD akan tercatat pada linimasa pelacakan.</p>
        </div>
        <a href="{{ route('lowongan.index') }}" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors shrink-0">
            Cari Lowongan Lainnya
        </a>
    </div>

    <!-- Table of Applications -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                        <th class="py-3.5 px-6">Kode Registrasi</th>
                        <th class="py-3.5 px-6">Posisi Lowongan</th>
                        <th class="py-3.5 px-6">Perusahaan Mitra</th>
                        <th class="py-3.5 px-6">Tanggal Pengajuan</th>
                        <th class="py-3.5 px-6">Status Terkini</th>
                        <th class="py-3.5 px-6 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($lamaran as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                {{ $item->kode_lamaran }}
                            </td>
                            <td class="py-4 px-6">
                                <a href="{{ route('lowongan.detail', $item->lowongan->slug) }}" class="font-bold text-slate-900 hover:text-blue-600">
                                    {{ $item->lowongan->judul_lowongan }}
                                </a>
                                <span class="text-[11px] text-slate-400 block">{{ $item->lowongan->tipe_pekerjaan }} &bull; {{ $item->lowongan->sistem_kerja }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-semibold text-slate-800">{{ $item->lowongan->perusahaan->nama_perusahaan }}</span>
                                <span class="text-[11px] text-slate-500 block">{{ $item->lowongan->perusahaan->kota }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $item->created_at->isoFormat('D MMM Y, HH:mm') }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $item->status_badge_classes }}">
                                    {{ $item->status_label }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('pelamar.lamaran.show', $item->kode_lamaran) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-xs font-semibold transition-colors">
                                    Lihat Progress
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                Belum ada riwayat lamaran yang diajukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lamaran->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $lamaran->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
