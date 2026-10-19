@extends('layouts.dashboard')

@section('title', 'Lowongan Tersimpan - E-Recruitment D3 TI USU')
@section('header-title', 'Lowongan Tersimpan')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Daftar Lowongan Pekerjaan Tersimpan</h2>
            <p class="text-sm text-slate-500 mt-1">Daftar posisi kerja dan magang yang telah Anda tandai sebagai favorit untuk dilamar kemudian.</p>
        </div>
        <a href="{{ route('lowongan.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            Jelajah Lowongan Lainnya
        </a>
    </div>

    @if($bookmarks->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($bookmarks as $item)
                @php $lowongan = $item->lowongan; @endphp
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:border-blue-300 transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-slate-700 shrink-0">
                                    {{ substr($lowongan->perusahaan->nama_perusahaan, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-slate-900 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('lowongan.detail', $lowongan->slug) }}">{{ $lowongan->judul_lowongan }}</a>
                                    </h3>
                                    <p class="text-xs text-slate-500 font-medium">{{ $lowongan->perusahaan->nama_perusahaan }}</p>
                                </div>
                            </div>

                            <form action="{{ route('pelamar.bookmarks.toggle', $lowongan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition-colors" title="Hapus dari Simpanan">
                                    <svg class="w-5 h-5 fill-rose-500" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="flex flex-wrap gap-2 my-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $lowongan->tipe_pekerjaan }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                {{ $lowongan->sistem_kerja }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700">
                                {{ $lowongan->lokasi }}
                            </span>
                        </div>

                        <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed mb-4">
                            {{ Str::limit(strip_tags($lowongan->deskripsi_pekerjaan), 140) }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <div>
                            <span class="font-bold text-slate-900 block text-sm">{{ $lowongan->rentang_gaji }}</span>
                            <span class="text-[11px] text-slate-400">Batas: {{ $lowongan->batas_lamaran->format('d M Y') }}</span>
                        </div>
                        <a href="{{ route('lowongan.detail', $lowongan->slug) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-900 hover:bg-blue-600 text-white font-semibold rounded-xl transition-colors">
                            <span>Detail & Lamar</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $bookmarks->links() }}
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-800">Belum Ada Lowongan Tersimpan</h3>
            <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto mb-6">Tandai posisi lowongan yang menarik saat menjelajahi katalog lowongan untuk menyimpannya di sini.</p>
            <a href="{{ route('lowongan.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                Jelajahi Lowongan Kerja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection
