@extends('layouts.dashboard')

@section('title', 'Semua Lowongan Kerja')
@section('page_title', 'Monitoring Semua Lowongan Kerja')
@section('page_subtitle', 'Pengawasan seluruh lowongan yang dibuka oleh mitra industri untuk mahasiswa D3 TI USU')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
        <form action="{{ route('admin.lowongan.index') }}" method="GET">
            <div class="flex items-center gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari judul lowongan atau nama perusahaan..."
                           class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-xs transition-colors shrink-0">
                    Cari Lowongan
                </button>
            </div>
        </form>
    </div>

    <!-- Vacancies Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                        <th class="py-3.5 px-6">Posisi Lowongan</th>
                        <th class="py-3.5 px-6">Perusahaan Mitra</th>
                        <th class="py-3.5 px-6">Tipe & Sistem</th>
                        <th class="py-3.5 px-6">Pelamar</th>
                        <th class="py-3.5 px-6">Batas Waktu</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($lowongan as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $item->judul_lowongan }}
                                <span class="text-[11px] text-slate-400 block font-normal">{{ $item->kategori_bidang }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-semibold text-slate-800">{{ $item->perusahaan->nama_perusahaan }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $item->perusahaan->kota }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span>{{ $item->tipe_pekerjaan }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $item->sistem_kerja }}</span>
                            </td>
                            <td class="py-4 px-6 font-semibold text-blue-600">
                                {{ $item->lamaran->count() }} Berkas
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $item->batas_lamaran->isoFormat('D MMM Y') }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold {{ $item->status_aktif ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                    {{ $item->status_aktif ? 'Aktif' : 'Tutup' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('lowongan.detail', $item->slug) }}" target="_blank"
                                   class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800">
                                    Tinjau Publik
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500">
                                Tidak ada data lowongan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lowongan->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $lowongan->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
