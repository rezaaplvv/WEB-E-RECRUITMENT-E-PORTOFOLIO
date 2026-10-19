@extends('layouts.dashboard')

@section('title', 'Kelola Lowongan Pekerjaan')
@section('page_title', 'Manajemen Lowongan Kerja')
@section('page_subtitle', 'Kelola daftar posisi pekerjaan dan magang yang dibuka untuk mahasiswa D3 TI USU')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900">Daftar Lowongan Kerja Anda ({{ $lowongan->total() }})</h2>
            <p class="text-xs text-slate-500">Aktifkan atau tutup status lamaran sesuai dengan kebutuhan kuota rekrutmen Anda.</p>
        </div>
        <a href="{{ route('perusahaan.lowongan.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Pasang Lowongan Baru
        </a>
    </div>

    <!-- Table of Company Vacancies -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                        <th class="py-3.5 px-6">Posisi Lowongan</th>
                        <th class="py-3.5 px-6">Tipe & Sistem</th>
                        <th class="py-3.5 px-6">Pelamar Masuk</th>
                        <th class="py-3.5 px-6">Batas Lamaran</th>
                        <th class="py-3.5 px-6">Status Publikasi</th>
                        <th class="py-3.5 px-6 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($lowongan as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <a href="{{ route('lowongan.detail', $item->slug) }}" target="_blank" class="font-bold text-slate-900 hover:text-blue-600">
                                    {{ $item->judul_lowongan }}
                                </a>
                                <span class="text-[11px] text-slate-400 block">{{ $item->kategori_bidang }} &bull; {{ $item->rentang_gaji }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="font-medium text-slate-800">{{ $item->tipe_pekerjaan }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $item->sistem_kerja }} ({{ $item->lokasi }})</span>
                            </td>
                            <td class="py-4 px-6">
                                <a href="{{ route('perusahaan.pelamar.index', ['lowongan_id' => $item->id]) }}" class="inline-flex items-center font-bold text-blue-600 hover:underline">
                                    {{ $item->lamaran_count }} Kandidat
                                </a>
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $item->batas_lamaran->isoFormat('D MMM Y') }}
                                @if($item->isExpired())
                                    <span class="text-[10px] text-rose-600 block font-semibold">Telah Berakhir</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <form action="{{ route('perusahaan.lowongan.toggle', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded-full text-[11px] font-semibold transition-colors {{ $item->status_aktif ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200' }}"
                                            title="Klik untuk mengubah status">
                                        {{ $item->status_aktif ? 'Dibuka (Aktif)' : 'Ditutup' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('perusahaan.lowongan.edit', $item->id) }}"
                                   class="inline-flex items-center p-1.5 text-slate-500 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-colors" title="Edit Lowongan">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('perusahaan.lowongan.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini beserta seluruh riwayat lamarannya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors" title="Hapus Lowongan">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                Perusahaan Anda belum mempublikasikan lowongan pekerjaan.
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
