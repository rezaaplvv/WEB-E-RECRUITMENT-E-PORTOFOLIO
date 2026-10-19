@extends('layouts.app')

@section('title', $lowongan->judul_lowongan . ' - ' . $lowongan->perusahaan->nama_perusahaan)
@section('meta_description', Str::limit(strip_tags($lowongan->deskripsi_pekerjaan), 150))

@section('content')
<!-- Breadcrumb Header -->
<div class="bg-white border-b border-slate-200 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-4">
            <a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <span>/</span>
            <a href="{{ route('lowongan.index') }}" class="hover:text-blue-600 transition-colors">Lowongan Kerja</a>
            <span>/</span>
            <span class="text-slate-900 font-semibold truncate">{{ $lowongan->judul_lowongan }}</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2 mb-2">
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded bg-blue-50 text-blue-700 border border-blue-200">
                        {{ $lowongan->kategori_bidang }}
                    </span>
                    <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-slate-100 text-slate-700">
                        {{ $lowongan->tipe_pekerjaan }}
                    </span>
                    <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-slate-100 text-slate-700">
                        {{ $lowongan->sistem_kerja }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    {{ $lowongan->judul_lowongan }}
                </h1>
                <p class="text-sm font-semibold text-slate-700 mt-1">
                    {{ $lowongan->perusahaan->nama_perusahaan }} &bull; <span class="text-slate-500 font-normal">{{ $lowongan->lokasi }}</span>
                </p>
            </div>

            <div class="text-left md:text-right">
                <span class="text-xs text-slate-500 block">Kisaran Kompensasi</span>
                <span class="text-lg font-bold text-slate-900">{{ $lowongan->rentang_gaji }}</span>
                <span class="text-xs text-slate-400 block mt-0.5">Batas: {{ $lowongan->batas_lamaran->isoFormat('D MMMM Y') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Job Details Content -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Description -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
                <h2 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Deskripsi Pekerjaan
                </h2>
                <div class="text-sm text-slate-700 leading-relaxed space-y-3 whitespace-pre-line">
                    {{ $lowongan->deskripsi_pekerjaan }}
                </div>
            </div>

            <!-- Qualifications -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
                <h2 class="text-lg font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Kualifikasi & Persyaratan Khusus
                </h2>
                <div class="text-sm text-slate-700 leading-relaxed space-y-3 whitespace-pre-line">
                    {{ $lowongan->kualifikasi }}
                </div>
            </div>

            <!-- Apply Section Form -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8" id="lamar-sekarang">
                <h2 class="text-lg font-bold text-slate-900 mb-2">Formulir Lamaran Pekerjaan</h2>
                <p class="text-xs text-slate-500 mb-6">Proses rekrutmen elektronik resmi Program Studi D3 TI USU.</p>

                @auth
                    @if(auth()->user()->isPelamar())
                        @if($sudahMelamar)
                            <div class="p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 space-y-3">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm font-semibold">Anda telah mengirimkan lamaran untuk posisi ini.</p>
                                </div>
                                <div class="text-xs space-y-1">
                                    <p>Kode Registrasi: <strong>{{ $lamaranSaya->kode_lamaran }}</strong></p>
                                    <p>Status Saat Ini: <span class="px-2 py-0.5 rounded text-[11px] font-semibold {{ $lamaranSaya->status_badge_classes }}">{{ $lamaranSaya->status_label }}</span></p>
                                </div>
                                <div>
                                    <a href="{{ route('pelamar.lamaran.show', $lamaranSaya->kode_lamaran) }}" class="inline-flex items-center text-xs font-semibold text-blue-700 underline hover:text-blue-900">
                                        Buka Detail Status & Timeline Seleksi &rarr;
                                    </a>
                                </div>
                            </div>
                        @else
                            @php
                                $pelamar = auth()->user()->pelamar;
                                $hasCv = !empty($pelamar?->file_cv);
                                $hasGithub = !empty($pelamar?->link_github);
                            @endphp

                            @if(!$hasCv || !$hasGithub)
                                <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 space-y-2 mb-4">
                                    <p class="text-xs font-semibold">Persyaratan Profil Belum Lengkap:</p>
                                    <ul class="text-xs list-disc list-inside space-y-1">
                                        @if(!$hasCv) <li>Berkas CV PDF belum diunggah.</li> @endif
                                        @if(!$hasGithub) <li>Tautan repositori GitHub belum diisi.</li> @endif
                                    </ul>
                                    <a href="{{ route('pelamar.profil') }}" class="inline-block mt-2 text-xs font-bold text-amber-900 underline">
                                        Lengkapi Profil & Unggah CV Sekarang &rarr;
                                    </a>
                                </div>
                            @endif

                            <form action="{{ route('pelamar.lamaran.apply', $lowongan->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="surat_lamaran" class="block text-xs font-semibold text-slate-700 mb-1">
                                        Surat Lamaran Singkat / Cover Letter (Wajib)
                                    </label>
                                    <textarea id="surat_lamaran" name="surat_lamaran" rows="4" required
                                              class="w-full px-3.5 py-2.5 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                              placeholder="Tuliskan alasan ketertarikan Anda dan kesesuaian keahlian Anda dengan posisi ini...">{{ old('surat_lamaran') }}</textarea>
                                    @error('surat_lamaran')
                                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-600 space-y-1">
                                    <p class="font-semibold text-slate-700">Snapshot Berkas yang Akan Disertakan:</p>
                                    <p>&bull; Berkas CV: <strong>{{ $hasCv ? 'Tersedia (' . basename($pelamar->file_cv) . ')' : 'Belum diunggah' }}</strong></p>
                                    <p>&bull; Repositori GitHub: <strong>{{ $pelamar?->link_github ?? 'Belum diisi' }}</strong></p>
                                    <p>&bull; Portofolio Terdaftar: <strong>{{ $pelamar?->portofolio->count() ?? 0 }} proyek karya</strong></p>
                                </div>

                                <button type="submit" @if(!$hasCv || !$hasGithub) disabled @endif
                                        class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white font-semibold text-sm rounded-xl shadow-sm transition-colors flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    Kirim Lamaran Sekarang
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-slate-600 text-xs">
                            Anda masuk sebagai <strong>{{ auth()->user()->role }}</strong>. Formulir lamaran hanya dapat diajukan oleh akun dengan peran <strong>Pelamar</strong>.
                        </div>
                    @endif
                @else
                    <div class="text-center py-6 border border-dashed border-slate-300 rounded-xl bg-slate-50 p-6 space-y-3">
                        <p class="text-sm text-slate-700 font-medium">Silakan masuk ke akun Anda untuk mengajukan lamaran.</p>
                        <div class="flex items-center justify-center space-x-3">
                            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-xs">
                                Masuk ke Akun
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg shadow-2xs">
                                Buat Akun Baru
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Right: Company Profile & Related Jobs -->
        <div class="space-y-6">
            <!-- Company Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-400">Profil Instansi Mitra</h3>
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-xl bg-slate-900 text-white font-bold flex items-center justify-center text-lg shrink-0">
                        {{ substr($lowongan->perusahaan->nama_perusahaan, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">{{ $lowongan->perusahaan->nama_perusahaan }}</h4>
                        <span class="inline-flex items-center text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 mt-1">
                            <svg class="w-3 h-3 mr-1 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Mitra Terverifikasi
                        </span>
                    </div>
                </div>

                <p class="text-xs text-slate-600 leading-relaxed">
                    {{ $lowongan->perusahaan->deskripsi }}
                </p>

                <div class="pt-4 border-t border-slate-100 text-xs space-y-2 text-slate-600">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>{{ $lowongan->perusahaan->bidang_industri }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ $lowongan->perusahaan->alamat }}, {{ $lowongan->perusahaan->kota }}</span>
                    </div>
                    @if($lowongan->perusahaan->website)
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                            <a href="{{ $lowongan->perusahaan->website }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline truncate">
                                {{ $lowongan->perusahaan->website }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Related Vacancies -->
            @if($lowonganTerkait->count() > 0)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-400">Lowongan Terkait</h3>
                    <div class="space-y-3">
                        @foreach($lowonganTerkait as $rel)
                            <a href="{{ route('lowongan.detail', $rel->slug) }}" class="block p-3 rounded-xl bg-slate-50 hover:bg-blue-50/50 border border-slate-200 hover:border-blue-200 transition-all group">
                                <p class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                                    {{ $rel->judul_lowongan }}
                                </p>
                                <p class="text-[11px] text-slate-500 mt-0.5">{{ $rel->perusahaan->nama_perusahaan }}</p>
                                <span class="text-[10px] text-slate-400 block mt-1">{{ $rel->rentang_gaji }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
