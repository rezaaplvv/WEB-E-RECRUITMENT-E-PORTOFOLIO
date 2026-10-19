@extends('layouts.dashboard')

@section('title', 'Laporan Rekapitulasi Rekrutmen')
@section('page_title', 'Laporan Rekrutmen & Penempatan')
@section('page_subtitle', 'Rekapitulasi seluruh pelamar yang masuk ke instansi ' . $perusahaan->nama_perusahaan)

@section('content')
<div class="space-y-6">
    
    <!-- Filter and PDF Export Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900">Rekap Data Kandidat ({{ $lamaran->count() }})</h2>
            <p class="text-xs text-slate-500">Cetak laporan resmi dalam format PDF berstandar kop instansi.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ route('perusahaan.laporan') }}" method="GET" class="flex items-center gap-2">
                <select name="status_lamaran" class="px-3 py-2 text-xs bg-white border border-slate-300 rounded-lg text-slate-700 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="interview" {{ request('status_lamaran') == 'interview' ? 'selected' : '' }}>Tahap Interview</option>
                    <option value="diterima" {{ request('status_lamaran') == 'diterima' ? 'selected' : '' }}>Diterima Bekerja</option>
                    <option value="ditolak" {{ request('status_lamaran') == 'ditolak' ? 'selected' : '' }}>Tidak Lolos</option>
                </select>
                <button type="submit" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                    Filter
                </button>
            </form>

            <a href="{{ route('perusahaan.laporan.pdf', request()->all()) }}"
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors flex items-center shrink-0">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Laporan PDF (Dompdf)
            </a>
        </div>
    </div>

    <!-- Summary Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                        <th class="py-3 px-6">No.</th>
                        <th class="py-3 px-6">Kode Lamaran</th>
                        <th class="py-3 px-6">Nama Kandidat</th>
                        <th class="py-3 px-6">NIM / IPK</th>
                        <th class="py-3 px-6">Posisi Lowongan</th>
                        <th class="py-3 px-6">Tanggal Pengajuan</th>
                        <th class="py-3 px-6">Status Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($lamaran as $index => $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-6 font-semibold text-slate-400">{{ $index + 1 }}</td>
                            <td class="py-3 px-6 font-mono font-bold text-slate-900">{{ $item->kode_lamaran }}</td>
                            <td class="py-3 px-6 font-bold text-slate-900">{{ $item->pelamar->user->name }}</td>
                            <td class="py-3 px-6">{{ $item->pelamar->nim }} &bull; IPK {{ number_format($item->pelamar->ipk, 2) }}</td>
                            <td class="py-3 px-6 font-semibold text-slate-800">{{ $item->lowongan->judul_lowongan }}</td>
                            <td class="py-3 px-6 text-slate-500">{{ $item->created_at->isoFormat('D MMM Y') }}</td>
                            <td class="py-3 px-6">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $item->status_badge_classes }}">
                                    {{ $item->status_label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500">
                                Belum ada data transaksi rekrutmen yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
