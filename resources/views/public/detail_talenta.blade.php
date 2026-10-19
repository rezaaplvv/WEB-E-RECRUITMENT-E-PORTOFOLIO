@extends('layouts.app')

@section('title', 'E-Portofolio ' . $pelamar->user->name . ' - D3 TI USU')
@section('meta_description', $pelamar->headline . ' - Lulusan D3 Teknik Informatika USU')

@section('content')
<!-- Student Header Banner -->
<div class="bg-white border-b border-slate-200 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <span>/</span>
            <a href="{{ route('talenta.index') }}" class="hover:text-blue-600 transition-colors">Direktori Talenta</a>
            <span>/</span>
            <span class="text-slate-900 font-semibold truncate">{{ $pelamar->user->name }}</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-start sm:items-center space-x-4">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-blue-600 text-white font-bold flex items-center justify-center text-2xl shrink-0 shadow-md">
                    {{ substr($pelamar->user->name, 0, 1) }}
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            {{ $pelamar->user->name }}
                        </h1>
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                            IPK {{ number_format($pelamar->ipk, 2) }}
                        </span>
                    </div>
                    <p class="text-sm font-semibold text-blue-600">{{ $pelamar->headline }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        NIM: <strong>{{ $pelamar->nim }}</strong> &bull; Angkatan: <strong>{{ $pelamar->angkatan }}</strong> &bull; D3 Teknik Informatika USU
                    </p>
                </div>
            </div>

            <!-- Social / CV Action Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ $pelamar->link_github }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg shadow-2xs hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                    </svg>
                    GitHub Profil
                </a>

                @if($pelamar->link_linkedin)
                    <a href="{{ $pelamar->link_linkedin }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg shadow-2xs hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4 mr-1.5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                        LinkedIn
                    </a>
                @endif

                @if($pelamar->link_portofolio_web)
                    <a href="{{ $pelamar->link_portofolio_web }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg shadow-2xs hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4 mr-1.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                        Website Pribadi
                    </a>
                @endif

                @if($pelamar->file_cv)
                    <a href="{{ asset('storage/' . $pelamar->file_cv) }}" target="_blank"
                       class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh Berkas CV
                    </a>
                @endif

                <a href="{{ route('talenta.cv.digital', $pelamar->id) }}"
                   class="inline-flex items-center px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Unduh CV Digital D3 TI (PDF)
                </a>
            </div>
        </div>
    </div>
</div>


<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Biography & Skills -->
        <div class="space-y-6">
            <!-- Ringkasan Profil -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-3">
                <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Ringkasan Profil</h2>
                <p class="text-xs text-slate-600 leading-relaxed">
                    {{ $pelamar->ringkasan_profil }}
                </p>
            </div>

            <!-- Keahlian Teknis -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-3">
                <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Keahlian & Teknologi</h2>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($pelamar->skills_array as $skill)
                        <span class="text-xs px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 font-medium">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Kontak Akademik -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-3 text-xs text-slate-600">
                <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Informasi Akademik</h2>
                <p>Alamat: <span class="text-slate-800 font-medium">{{ $pelamar->alamat }}</span></p>
                <p>Status: <span class="text-emerald-700 font-semibold">Lulusan D3 Teknik Informatika</span></p>
            </div>
        </div>

        <!-- Right Column: Projects Portfolio Showcase -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-900">Showcase Proyek Karya ({{ $pelamar->portofolio->count() }})</h2>
                <span class="text-xs text-slate-500">Terverifikasi di GitHub</span>
            </div>

            <div class="space-y-6">
                @forelse($pelamar->portofolio as $proyek)
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:border-blue-300 transition-all space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $proyek->kategori }}
                                </span>
                                <h3 class="text-base font-bold text-slate-900 mt-2">{{ $proyek->judul_proyek }}</h3>
                            </div>

                            <div class="flex items-center space-x-2 shrink-0">
                                <a href="{{ $proyek->link_github }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                                    </svg>
                                    Repository
                                </a>

                                @if($proyek->link_demo)
                                    <a href="{{ $proyek->link_demo }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Live Demo
                                    </a>
                                @endif
                            </div>
                        </div>

                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $proyek->deskripsi }}
                        </p>

                        <!-- Tech Stack Tags -->
                        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center gap-1.5">
                            <span class="text-[10px] font-semibold text-slate-400 mr-1">Teknologi:</span>
                            @foreach($proyek->tech_stack_array as $ts)
                                <span class="text-[10px] px-2 py-0.5 rounded bg-slate-50 border border-slate-200 text-slate-600">
                                    {{ $ts }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center bg-white rounded-2xl border border-slate-200 p-8">
                        <p class="text-xs text-slate-500">Mahasiswa belum menambahkan proyek portofolio karya.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
