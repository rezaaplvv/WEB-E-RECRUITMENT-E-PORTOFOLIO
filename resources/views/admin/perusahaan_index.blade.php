@extends('layouts.dashboard')

@section('title', 'Verifikasi & Kemitraan Perusahaan')
@section('page_title', 'Verifikasi & Kemitraan Perusahaan')
@section('page_subtitle', 'Persetujuan pendaftaran instansi industri mitra Program Studi D3 Teknik Informatika USU')

@section('content')
<div class="space-y-6">
    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
        <form action="{{ route('admin.perusahaan.index') }}" method="GET">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <label for="search" class="block text-xs font-semibold text-slate-600 mb-1">Cari Perusahaan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                               placeholder="Nama instansi, sektor industri, kota, email..."
                               class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-xs font-semibold text-slate-600 mb-1">Status Verifikasi</label>
                    <select id="status" name="status" class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                        <option value="terverifikasi" {{ request('status') == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between pt-3 border-t border-slate-100">
                <span class="text-xs text-slate-500">Total <strong>{{ $perusahaan->total() }}</strong> perusahaan terdaftar</span>
                <div class="flex items-center space-x-2">
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.perusahaan.index') }}" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-slate-900">
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

    <!-- Company Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                        <th class="py-3.5 px-6">Instansi Perusahaan</th>
                        <th class="py-3.5 px-6">Kontak HRD</th>
                        <th class="py-3.5 px-6">Alamat Domisili</th>
                        <th class="py-3.5 px-6">Status Verifikasi</th>
                        <th class="py-3.5 px-6 text-right">Aksi Administrator</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($perusahaan as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900 text-sm">{{ $item->nama_perusahaan }}</p>
                                <span class="text-[11px] text-slate-500">{{ $item->bidang_industri }}</span>
                                @if($item->website)
                                    <a href="{{ $item->website }}" target="_blank" class="text-[10px] text-blue-600 hover:underline block mt-0.5">
                                        {{ $item->website }}
                                    </a>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-medium text-slate-800">{{ $item->email_hrd }}</p>
                                <span class="text-[11px] text-slate-400 block">{{ $item->no_telp }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-slate-700">{{ $item->kota }}</p>
                                <span class="text-[11px] text-slate-400 line-clamp-1 max-w-xs">{{ $item->alamat }}</span>
                            </td>
                            <td class="py-4 px-6">
                                @if($item->status_verifikasi === 'terverifikasi')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Terverifikasi
                                    </span>
                                @elseif($item->status_verifikasi === 'pending')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        Menunggu Review
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right space-x-1">
                                @if($item->status_verifikasi !== 'terverifikasi')
                                    <form action="{{ route('admin.perusahaan.verifikasi', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status_verifikasi" value="terverifikasi">
                                        <button type="submit" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold shadow-2xs transition-colors">
                                            Setujui
                                        </button>
                                    </form>
                                @endif

                                @if($item->status_verifikasi !== 'ditolak')
                                    <form action="{{ route('admin.perusahaan.verifikasi', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak permohonan kemitraan perusahaan ini?');">
                                        @csrf
                                        <input type="hidden" name="status_verifikasi" value="ditolak">
                                        <button type="submit" class="px-3 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-semibold border border-rose-200 transition-colors">
                                            Tolak
                                        </button>
                                    </form>
                                @endif

                                @if($item->status_verifikasi !== 'pending')
                                    <form action="{{ route('admin.perusahaan.verifikasi', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status_verifikasi" value="pending">
                                        <button type="submit" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition-colors" title="Kembalikan ke status Pending">
                                            Reset
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-500">
                                Tidak ada data perusahaan yang sesuai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($perusahaan->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $perusahaan->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
