@extends('layouts.app')

@section('title', 'E-Recruitment & E-Portofolio D3 Teknik Informatika USU')
@section('meta_description', 'Portal Karir dan E-Portofolio Resmi Lulusan D3 Teknik Informatika, Fakultas Vokasi, Universitas Sumatera Utara.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-white border-b border-slate-200 overflow-hidden">
    <!-- Subtle Background Grid Pattern -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#f1f5f9_1px,transparent_1px),linear-gradient(to_bottom,#f1f5f9_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-70"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 text-center">
        <!-- Institution Badge -->
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold mb-6">
            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
            <span>Program Studi D3 Teknik Informatika - Fakultas Vokasi USU</span>
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight max-w-4xl mx-auto leading-tight">
            Jembatan Karir Profesional & Showcase Portofolio Talenta TI
        </h1>

        <p class="mt-6 text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Platform terpadu rekrutmen kerja dan showcase portofolio proyek karya nyata lulusan D3 Teknik Informatika Universitas Sumatera Utara dengan mitra industri terpercaya.
        </p>

        <!-- CTA Action Buttons -->
        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('lowongan.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Jelajahi Lowongan Kerja
            </a>
            <a href="{{ route('talenta.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 text-base font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 rounded-xl shadow-xs transition-all">
                <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Direktori Portofolio Talenta
            </a>
        </div>

        <!-- Quick Search Bar -->
        <div class="mt-12 max-w-3xl mx-auto">
            <form action="{{ route('lowongan.index') }}" method="GET" class="p-2 bg-white rounded-2xl border border-slate-200 shadow-md flex flex-col sm:flex-row items-center gap-2">
                <div class="relative flex-1 w-full">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="keyword" placeholder="Cari posisi kerja, skill (Laravel, Flutter), atau lokasi..."
                           class="w-full pl-11 pr-4 py-2.5 text-sm text-slate-900 bg-transparent rounded-xl focus:outline-none placeholder:text-slate-400">
                </div>
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-xl transition-colors shrink-0">
                    Cari Lowongan
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Key Ecosystem Metrics / Statistik Singkat -->
<section class="py-12 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-3xl sm:text-4xl font-extrabold text-blue-600 tracking-tight">{{ $totalLowongan }}</p>
                <p class="mt-2 text-xs sm:text-sm font-semibold text-slate-600">Lowongan Terbuka</p>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">{{ $totalPerusahaan }}</p>
                <p class="mt-2 text-xs sm:text-sm font-semibold text-slate-600">Perusahaan Mitra</p>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-3xl sm:text-4xl font-extrabold text-indigo-600 tracking-tight">{{ $totalPelamar }}</p>
                <p class="mt-2 text-xs sm:text-sm font-semibold text-slate-600">Talenta D3 TI Terdaftar</p>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="text-3xl sm:text-4xl font-extrabold text-emerald-600 tracking-tight">{{ $totalDiterima }}</p>
                <p class="mt-2 text-xs sm:text-sm font-semibold text-slate-600">Penempatan Kerja</p>
            </div>
        </div>
    </div>
</section>

<!-- Latest Job Vacancies / 6 Lowongan Terbaru -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">Peluang Karir</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Lowongan Pekerjaan Terbaru</h2>
                <p class="text-sm text-slate-600 mt-1">Daftar posisi kerja dan magang dari mitra industri yang telah terverifikasi</p>
            </div>
            <a href="{{ route('lowongan.index') }}" class="mt-4 md:mt-0 inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700">
                Lihat Semua Lowongan
                <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($lowonganTerbaru as $job)
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
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                            <a href="{{ route('lowongan.detail', $job->slug) }}">
                                {{ $job->judul_lowongan }}
                            </a>
                        </h3>

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
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200">
                    <p class="text-sm text-slate-500">Belum ada lowongan pekerjaan aktif saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Talents Showcase / 4 Talenta Unggulan -->
<section class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-indigo-600">E-Portofolio Lulusan</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Talenta Siap Kerja D3 TI USU</h2>
                <p class="text-sm text-slate-600 mt-1">Profil lulusan yang telah dilengkapi portofolio proyek dan terverifikasi kompetensinya</p>
            </div>
            <a href="{{ route('talenta.index') }}" class="mt-4 md:mt-0 inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700">
                Lihat Direktori Selengkapnya
                <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($talentaUnggulan as $t)
                <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:shadow-md hover:bg-white transition-all">
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-600 text-white font-bold flex items-center justify-center text-base shrink-0 shadow-2xs">
                                {{ substr($t->user->name, 0, 1) }}
                            </div>
                            <div class="overflow-hidden">
                                <h3 class="text-sm font-bold text-slate-900 truncate">{{ $t->user->name }}</h3>
                                <p class="text-xs text-slate-500">NIM: {{ $t->nim }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 mb-3">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">
                                IPK {{ number_format($t->ipk, 2) }}
                            </span>
                            <span class="text-xs text-slate-500">Angkatan {{ $t->angkatan }}</span>
                        </div>

                        <p class="text-xs font-semibold text-slate-700 line-clamp-1 mb-2">
                            {{ $t->headline }}
                        </p>

                        <!-- Tech Stack Tags -->
                        <div class="flex flex-wrap gap-1 mb-4">
                            @foreach(array_slice($t->skills_array, 0, 3) as $skill)
                                <span class="text-[10px] px-2 py-0.5 rounded bg-white border border-slate-200 text-slate-600">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        </div>

                        <p class="text-xs text-slate-500">
                            {{ $t->portofolio->count() }} Proyek Portofolio Terdaftar
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                        <a href="{{ $t->link_github }}" target="_blank" rel="noopener noreferrer" class="text-slate-500 hover:text-slate-900 transition-colors" title="GitHub">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                            </svg>
                        </a>
                        <a href="{{ route('talenta.detail', $t->id) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                            Lihat Profil
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-slate-500">
                    Belum ada data talenta yang terdaftar.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Platform Workflow Section / Alur Cara Kerja -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">Alur Sistem</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-1">Bagaimana Platform Bekerja</h2>
            <p class="text-sm text-slate-600 mt-2">Proses rekrutmen terstandarisasi, transparan, dan terintegrasi dari awal hingga interview</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Step 1 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 relative">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm mb-4">
                    01
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Buat E-Portofolio</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Mahasiswa mengisi biodata akademik, mengunggah CV PDF berstandar industri, serta mencantumkan tautan proyek dan repositori GitHub.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 relative">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm mb-4">
                    02
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Temukan Lowongan</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Jelajahi katalog lowongan kerja dari perusahaan mitra resmi yang telah diverifikasi kelayakannya oleh admin prodi.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 relative">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm mb-4">
                    03
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">Apply & Review HRD</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Kirim lamaran secara elektronik. Sistem mengunci snapshot CV dan repositori, lalu menghasilkan kode pelacakan unik.
                </p>
            </div>

            <!-- Step 4 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 relative">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm mb-4">
                    04
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">E-Interview & Hasil</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Dapatkan jadwal interview online atau offline, cetak bukti undangan format PDF resmi, dan pantau hasil penerimaan kerja.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
