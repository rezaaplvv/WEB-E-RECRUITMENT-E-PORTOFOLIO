@extends('layouts.dashboard')

@section('title', 'Tracking Lamaran ' . $lamaran->kode_lamaran)
@section('page_title', 'Linimasa Tracking Lamaran')
@section('page_subtitle', 'Pantau tahapan seleksi secara transparan dan terdata')

@section('content')
<div class="max-w-4xl space-y-8">
    
    <!-- Top Summary Banner -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <div class="flex items-center space-x-2">
                <span class="font-mono text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded">
                    {{ $lamaran->kode_lamaran }}
                </span>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $lamaran->status_badge_classes }}">
                    {{ $lamaran->status_label }}
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight pt-1">
                {{ $lamaran->lowongan->judul_lowongan }}
            </h1>
            <p class="text-xs sm:text-sm font-semibold text-slate-700">
                {{ $lamaran->lowongan->perusahaan->nama_perusahaan }} &bull; <span class="text-slate-500 font-normal">{{ $lamaran->lowongan->perusahaan->kota }}</span>
            </p>
        </div>

        @if($lamaran->status_lamaran === 'interview')
            <a href="{{ route('pelamar.lamaran.cetak-interview', $lamaran->kode_lamaran) }}"
               class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors shrink-0">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Cetak Bukti Undangan Interview (PDF)
            </a>
        @endif
    </div>

    <!-- Visual Tracking Timeline Progress Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
        <h2 class="text-sm font-bold text-slate-900 mb-6 uppercase tracking-wider">Tahapan Progress Seleksi</h2>

        @php
            $stages = [
                'dilamar' => ['title' => 'Berkas Dikirim', 'desc' => 'Lamaran masuk ke sistem'],
                'dilihat' => ['title' => 'Ditinjau HRD', 'desc' => 'Portofolio sedang dievaluasi'],
                'interview' => ['title' => 'Tahap Interview', 'desc' => 'Wawancara kompetensi'],
                'keputusan' => ['title' => 'Hasil Akhir', 'desc' => 'Penerimaan / Tidak Lolos'],
            ];

            $order = [
                'dilamar' => 1,
                'dilihat' => 2,
                'interview' => 3,
                'diterima' => 4,
                'ditolak' => 4,
            ];

            $currentStep = $order[$lamaran->status_lamaran] ?? 1;
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 relative">
            <!-- Stage 1 -->
            <div class="p-4 rounded-xl border {{ $currentStep >= 1 ? 'border-blue-500 bg-blue-50/50' : 'border-slate-200 bg-slate-50' }}">
                <div class="flex items-center space-x-2 mb-1">
                    <div class="w-6 h-6 rounded-full {{ $currentStep >= 1 ? 'bg-blue-600 text-white' : 'bg-slate-300 text-slate-600' }} flex items-center justify-center font-bold text-xs">
                        1
                    </div>
                    <span class="text-xs font-bold text-slate-900">Berkas Dikirim</span>
                </div>
                <p class="text-[11px] text-slate-500 pl-8">Lamaran tercatat pada sistem</p>
            </div>

            <!-- Stage 2 -->
            <div class="p-4 rounded-xl border {{ $currentStep >= 2 ? 'border-blue-500 bg-blue-50/50' : 'border-slate-200 bg-slate-50' }}">
                <div class="flex items-center space-x-2 mb-1">
                    <div class="w-6 h-6 rounded-full {{ $currentStep >= 2 ? 'bg-blue-600 text-white' : 'bg-slate-300 text-slate-600' }} flex items-center justify-center font-bold text-xs">
                        2
                    </div>
                    <span class="text-xs font-bold text-slate-900">Ditinjau HRD</span>
                </div>
                <p class="text-[11px] text-slate-500 pl-8">CV & GitHub kandidat dibuka</p>
            </div>

            <!-- Stage 3 -->
            <div class="p-4 rounded-xl border {{ $currentStep >= 3 ? 'border-amber-500 bg-amber-50/50' : 'border-slate-200 bg-slate-50' }}">
                <div class="flex items-center space-x-2 mb-1">
                    <div class="w-6 h-6 rounded-full {{ $currentStep >= 3 ? 'bg-amber-600 text-white' : 'bg-slate-300 text-slate-600' }} flex items-center justify-center font-bold text-xs">
                        3
                    </div>
                    <span class="text-xs font-bold text-slate-900">E-Interview</span>
                </div>
                <p class="text-[11px] text-slate-500 pl-8">Jadwal & link meeting diberikan</p>
            </div>

            <!-- Stage 4 -->
            <div class="p-4 rounded-xl border {{ $currentStep >= 4 ? ($lamaran->status_lamaran === 'diterima' ? 'border-emerald-500 bg-emerald-50/50' : 'border-rose-500 bg-rose-50/50') : 'border-slate-200 bg-slate-50' }}">
                <div class="flex items-center space-x-2 mb-1">
                    <div class="w-6 h-6 rounded-full {{ $currentStep >= 4 ? ($lamaran->status_lamaran === 'diterima' ? 'bg-emerald-600 text-white' : 'bg-rose-600 text-white') : 'bg-slate-300 text-slate-600' }} flex items-center justify-center font-bold text-xs">
                        4
                    </div>
                    <span class="text-xs font-bold text-slate-900">Keputusan Akhir</span>
                </div>
                <p class="text-[11px] text-slate-500 pl-8">
                    @if($lamaran->status_lamaran === 'diterima') Dinyatakan Diterima @elseif($lamaran->status_lamaran === 'ditolak') Belum Lolos @else Menunggu hasil @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Interview Detail Box (If stage is interview) -->
    @if($lamaran->status_lamaran === 'interview')
        <div class="bg-white rounded-2xl border border-amber-200 p-6 sm:p-8 space-y-4 shadow-2xs">
            <div class="flex items-center space-x-3 pb-3 border-b border-amber-100">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Informasi Jadwal E-Interview</h2>
                    <p class="text-xs text-slate-500">Silakan hadir tepat waktu sesuai dengan ketentuan di bawah ini.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <span class="text-slate-400 block font-semibold mb-1">Waktu & Tanggal:</span>
                    <span class="text-sm font-bold text-slate-900">
                        {{ $lamaran->jadwal_interview?->isoFormat('dddd, D MMMM Y - HH:mm') ?? 'Jadwal segera diumumkan' }} WIB
                    </span>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <span class="text-slate-400 block font-semibold mb-1">Metode Wawancara:</span>
                    <span class="text-sm font-bold text-slate-900">
                        {{ $lamaran->metode_interview ?? 'Online (Daring)' }}
                    </span>
                </div>
            </div>

            @if($lamaran->link_atau_lokasi_interview)
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl text-xs space-y-1">
                    <span class="font-bold text-blue-900 block">Tautan Virtual Meeting / Alamat Lokasi:</span>
                    @if(Str::startsWith($lamaran->link_atau_lokasi_interview, 'http'))
                        <a href="{{ $lamaran->link_atau_lokasi_interview }}" target="_blank" rel="noopener noreferrer"
                           class="text-blue-700 underline font-semibold break-all hover:text-blue-900">
                            {{ $lamaran->link_atau_lokasi_interview }}
                        </a>
                    @else
                        <p class="text-slate-800 font-medium">{{ $lamaran->link_atau_lokasi_interview }}</p>
                    @endif
                </div>
            @endif

            @if($lamaran->catatan_hrd)
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl text-xs space-y-1">
                    <span class="font-bold text-slate-700 block">Instruksi & Catatan Tambahan dari HRD:</span>
                    <p class="text-slate-600 leading-relaxed">{{ $lamaran->catatan_hrd }}</p>
                </div>
            @endif
        </div>
    @endif

    <!-- Decision Result Alert if Accepted or Rejected -->
    @if($lamaran->status_lamaran === 'diterima')
        <div class="p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 space-y-2">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-base font-bold">Selamat! Anda Dinyatakan Lolos & Diterima</h2>
            </div>
            <p class="text-xs text-emerald-800 leading-relaxed pl-8">
                {{ $lamaran->catatan_hrd ?? 'Pihak HRD perusahaan akan segera menghubungi Anda untuk tahap administrasi penandatanganan kontrak kerja.' }}
            </p>
        </div>
    @elseif($lamaran->status_lamaran === 'ditolak')
        <div class="p-6 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 space-y-2">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-base font-bold">Status Lamaran: Tidak Lolos</h2>
            </div>
            <p class="text-xs text-rose-800 leading-relaxed pl-8">
                {{ $lamaran->catatan_hrd ?? 'Terima kasih atas partisipasi Anda. Jangan berkecil hati, tetap semangat meningkatkan portofolio dan mencoba lowongan lainnya.' }}
            </p>
        </div>
    @endif

    <!-- Application Snapshots Info -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-6">
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Snapshot Berkas Terkunci Saat Melamar</h2>
            <p class="text-xs text-slate-500">Berkas dan tautan ini disimpan sebagai bukti otentik saat Anda mengirimkan lamaran.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                <div>
                    <span class="text-slate-400 block font-semibold">Snapshot CV PDF:</span>
                    <span class="font-bold text-slate-900">{{ basename($lamaran->cv_snapshot) }}</span>
                </div>
                <a href="{{ asset('storage/' . $lamaran->cv_snapshot) }}" target="_blank"
                   class="px-3 py-1.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold rounded-lg shadow-2xs">
                    Buka CV
                </a>
            </div>

            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                <div class="overflow-hidden pr-2">
                    <span class="text-slate-400 block font-semibold">Snapshot GitHub:</span>
                    <span class="font-bold text-slate-900 truncate block">{{ $lamaran->github_snapshot }}</span>
                </div>
                <a href="{{ $lamaran->github_snapshot }}" target="_blank" rel="noopener noreferrer"
                   class="px-3 py-1.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold rounded-lg shadow-2xs shrink-0">
                    Buka Repo
                </a>
            </div>
        </div>

        <div>
            <h3 class="text-xs font-semibold text-slate-700 mb-1">Surat Lamaran (Cover Letter):</h3>
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 leading-relaxed whitespace-pre-line">
                {{ $lamaran->surat_lamaran }}
            </div>
        </div>
    </div>
</div>
@endsection
