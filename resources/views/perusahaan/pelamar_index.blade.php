@extends('layouts.dashboard')

@section('title', 'Seleksi Pelamar & E-Interview')
@section('page_title', 'Seleksi Kandidat & Jadwal E-Interview')
@section('page_subtitle', 'Tinjau berkas lamaran, portofolio proyek, dan atur jadwal wawancara kerja')

@section('content')
<div class="space-y-6">
    <!-- Filter & Search Toolbar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
        <form action="{{ route('perusahaan.pelamar.index') }}" method="GET">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="lg:col-span-2">
                    <label for="search" class="block text-xs font-semibold text-slate-600 mb-1">Cari Pelamar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                               placeholder="Nama kandidat, NIM, atau kode lamaran..."
                               class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="lowongan_id" class="block text-xs font-semibold text-slate-600 mb-1">Pilih Lowongan</label>
                    <select id="lowongan_id" name="lowongan_id" class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Posisi</option>
                        @foreach($lowonganList as $v)
                            <option value="{{ $v->id }}" {{ request('lowongan_id') == $v->id ? 'selected' : '' }}>
                                {{ $v->judul_lowongan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status_lamaran" class="block text-xs font-semibold text-slate-600 mb-1">Tahap Status</label>
                    <select id="status_lamaran" name="status_lamaran" class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="dilamar" {{ request('status_lamaran') == 'dilamar' ? 'selected' : '' }}>Dilamar</option>
                        <option value="dilihat" {{ request('status_lamaran') == 'dilihat' ? 'selected' : '' }}>Dilihat HRD</option>
                        <option value="interview" {{ request('status_lamaran') == 'interview' ? 'selected' : '' }}>Tahap Interview</option>
                        <option value="diterima" {{ request('status_lamaran') == 'diterima' ? 'selected' : '' }}>Diterima Bekerja</option>
                        <option value="ditolak" {{ request('status_lamaran') == 'ditolak' ? 'selected' : '' }}>Tidak Lolos</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between pt-3 border-t border-slate-100">
                <span class="text-xs text-slate-500">
                    Ditemukan <strong>{{ $lamaran->total() }}</strong> berkas kandidat
                </span>
                <div class="flex items-center space-x-2">
                    @if(request()->hasAny(['search', 'lowongan_id', 'status_lamaran']))
                        <a href="{{ route('perusahaan.pelamar.index') }}" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-slate-900">
                            Reset
                        </a>
                    @endif
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-xs transition-colors">
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Candidate Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                        <th class="py-3.5 px-6">Kandidat Mahasiswa</th>
                        <th class="py-3.5 px-6">Posisi Lowongan</th>
                        <th class="py-3.5 px-6">Tanggal Melamar</th>
                        <th class="py-3.5 px-6">Status Seleksi</th>
                        <th class="py-3.5 px-6 text-right">Tindakan HRD</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($lamaran as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900 text-sm">{{ $item->pelamar->user->name }}</p>
                                <p class="text-[11px] text-slate-500">
                                    NIM: {{ $item->pelamar->nim }} &bull; Angkatan: {{ $item->pelamar->angkatan }} (IPK {{ number_format($item->pelamar->ipk, 2) }})
                                </p>
                                <span class="font-mono text-[10px] text-slate-400 block mt-0.5">Kode: {{ $item->kode_lamaran }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-semibold text-slate-800">{{ $item->lowongan->judul_lowongan }}</p>
                                <span class="text-[11px] text-slate-400 block">{{ $item->lowongan->kategori_bidang }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-500">
                                {{ $item->created_at->isoFormat('D MMM Y, HH:mm') }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $item->status_badge_classes }}">
                                    {{ $item->status_label }}
                                </span>
                                @if($item->status_lamaran === 'interview' && $item->jadwal_interview)
                                    <span class="text-[10px] text-amber-700 block mt-1 font-medium">
                                        {{ $item->jadwal_interview->format('d/m H:i') }} ({{ $item->metode_interview }})
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('perusahaan.pelamar.detail', $item->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shadow-2xs transition-colors">
                                    Review & Jadwal Interview
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-500">
                                Tidak ada data kandidat yang sesuai dengan filter pencarian.
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
