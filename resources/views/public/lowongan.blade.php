@extends('layouts.app')

@section('title', 'Katalog Lowongan Pekerjaan - E-Recruitment D3 TI USU')
@section('meta_description', 'Eksplorasi lowongan kerja dan magang bidang IT dan rekayasa perangkat lunak khusus mahasiswa dan lulusan D3 Teknik Informatika USU.')

@section('content')
<div class="bg-white border-b border-slate-200 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">Peluang Karir Mitra</span>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Katalog Lowongan Kerja</h1>
        <p class="mt-2 text-sm text-slate-600 max-w-2xl">
            Temukan kesempatan berkarir di bidang teknologi informasi dari mitra industri resmi Program Studi D3 Teknik Informatika USU.
        </p>

        <!-- Search & Filter Form -->
        <form action="{{ route('lowongan.index') }}" method="GET" class="mt-8 p-4 bg-slate-50 border border-slate-200 rounded-2xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="lg:col-span-2">
                    <label for="keyword" class="block text-xs font-semibold text-slate-600 mb-1">Kata Kunci</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="keyword" name="keyword" value="{{ request('keyword') }}"
                               placeholder="Posisi, nama perusahaan, keahlian..."
                               class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="tipe_pekerjaan" class="block text-xs font-semibold text-slate-600 mb-1">Tipe Pekerjaan</label>
                    <select id="tipe_pekerjaan" name="tipe_pekerjaan" class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Tipe</option>
                        <option value="Full-time" {{ request('tipe_pekerjaan') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="Internship" {{ request('tipe_pekerjaan') == 'Internship' ? 'selected' : '' }}>Internship (Magang)</option>
                        <option value="Part-time" {{ request('tipe_pekerjaan') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="Contract" {{ request('tipe_pekerjaan') == 'Contract' ? 'selected' : '' }}>Contract</option>
                    </select>
                </div>

                <div>
                    <label for="sistem_kerja" class="block text-xs font-semibold text-slate-600 mb-1">Sistem Kerja</label>
                    <select id="sistem_kerja" name="sistem_kerja" class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Sistem</option>
                        <option value="On-site" {{ request('sistem_kerja') == 'On-site' ? 'selected' : '' }}>On-site</option>
                        <option value="Remote" {{ request('sistem_kerja') == 'Remote' ? 'selected' : '' }}>Remote</option>
                        <option value="Hybrid" {{ request('sistem_kerja') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between pt-3 border-t border-slate-200">
                <span class="text-xs text-slate-500">
                    Menampilkan <strong>{{ $lowongan->total() }}</strong> lowongan kerja aktif
                </span>
                <div class="flex items-center space-x-2">
                    @if(request()->hasAny(['keyword', 'tipe_pekerjaan', 'sistem_kerja']))
                        <a href="{{ route('lowongan.index') }}" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-slate-900">
                            Reset Filter
                        </a>
                    @endif
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-xs transition-colors">
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($lowongan->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($lowongan as $job)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:shadow-md hover:border-blue-300 transition-all group">
                    <div>
                        <!-- Header Badges -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-slate-100 text-slate-700">
                                {{ $job->tipe_pekerjaan }}
                            </span>
                            <span class="text-xs font-medium px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 border border-blue-100">
                                {{ $job->sistem_kerja }}
                            </span>
                        </div>

                        <!-- Job Title -->
                        <h2 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                            <a href="{{ route('lowongan.detail', $job->slug) }}">
                                {{ $job->judul_lowongan }}
                            </a>
                        </h2>

                        <!-- Company Info -->
                        <p class="text-sm font-semibold text-slate-700 mt-1">
                            {{ $job->perusahaan->nama_perusahaan }}
                        </p>
                        <p class="text-xs text-slate-500 mt-0.5 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $job->lokasi }}
                        </p>

                        <!-- Salary & Category -->
                        <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="font-semibold text-slate-900">{{ $job->rentang_gaji }}</span>
                            <span class="text-slate-500">{{ $job->kategori_bidang }}</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-[11px] text-slate-400">
                            Batas: {{ $job->batas_lamaran->isoFormat('D MMM Y') }}
                        </span>
                        <a href="{{ route('lowongan.detail', $job->slug) }}" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-700">
                            Detail & Lamar
                            <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $lowongan->links() }}
        </div>
    @else
        <div class="py-16 text-center bg-white rounded-2xl border border-slate-200 p-8">
            <div class="w-12 h-12 rounded-full bg-slate-100 mx-auto flex items-center justify-center text-slate-400 mb-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h3 class="text-base font-semibold text-slate-900">Tidak ada lowongan ditemukan</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                Coba sesuaikan kata kunci pencarian atau ubah filter tipe pekerjaan dan sistem kerja Anda.
            </p>
            <div class="mt-6">
                <a href="{{ route('lowongan.index') }}" class="px-4 py-2 bg-slate-900 text-white text-xs font-semibold rounded-lg hover:bg-slate-800 transition-colors">
                    Reset Semua Filter
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
