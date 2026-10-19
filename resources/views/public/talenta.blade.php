@extends('layouts.app')

@section('title', 'Direktori Talenta & E-Portofolio D3 Teknik Informatika USU')
@section('meta_description', 'Direktori showcase talenta dan lulusan berkompeten D3 Teknik Informatika USU lengkap dengan portofolio proyek dan tautan repositori GitHub.')

@section('content')
<div class="bg-white border-b border-slate-200 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">Direktori Talenta Lulusan</span>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1">E-Portofolio Mahasiswa & Alumni</h1>
        <p class="mt-2 text-sm text-slate-600 max-w-2xl">
            Jelajahi profil kompetensi, keahlian teknis, dan portofolio karya nyata mahasiswa dan lulusan D3 Teknik Informatika USU.
        </p>

        <!-- Search & Filter Form -->
        <form action="{{ route('talenta.index') }}" method="GET" class="mt-8 p-4 bg-slate-50 border border-slate-200 rounded-2xl">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <label for="keyword" class="block text-xs font-semibold text-slate-600 mb-1">Cari Talenta</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="keyword" name="keyword" value="{{ request('keyword') }}"
                               placeholder="Nama, NIM, keahlian (Laravel, Flutter, Python, Figma)..."
                               class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="angkatan" class="block text-xs font-semibold text-slate-600 mb-1">Tahun Angkatan</label>
                    <select id="angkatan" name="angkatan" class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Angkatan</option>
                        <option value="2023" {{ request('angkatan') == '2023' ? 'selected' : '' }}>2023</option>
                        <option value="2022" {{ request('angkatan') == '2022' ? 'selected' : '' }}>2022</option>
                        <option value="2021" {{ request('angkatan') == '2021' ? 'selected' : '' }}>2021</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between pt-3 border-t border-slate-200">
                <span class="text-xs text-slate-500">
                    Menampilkan <strong>{{ $talenta->total() }}</strong> talenta terdaftar
                </span>
                <div class="flex items-center space-x-2">
                    @if(request()->hasAny(['keyword', 'angkatan']))
                        <a href="{{ route('talenta.index') }}" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-slate-900">
                            Reset Filter
                        </a>
                    @endif
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-xs transition-colors">
                        Terapkan Pencarian
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($talenta->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($talenta as $t)
                <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:shadow-md hover:border-blue-300 transition-all group">
                    <div>
                        <!-- Avatar & Info -->
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-600 text-white font-bold flex items-center justify-center text-lg shrink-0 shadow-2xs">
                                {{ substr($t->user->name, 0, 1) }}
                            </div>
                            <div class="overflow-hidden">
                                <h2 class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors truncate">
                                    <a href="{{ route('talenta.detail', $t->id) }}">
                                        {{ $t->user->name }}
                                    </a>
                                </h2>
                                <p class="text-xs text-slate-500">NIM: {{ $t->nim }}</p>
                            </div>
                        </div>

                        <!-- Academic Badges -->
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                                IPK {{ number_format($t->ipk, 2) }}
                            </span>
                            <span class="text-xs text-slate-500">Angkatan {{ $t->angkatan }}</span>
                        </div>

                        <!-- Headline -->
                        <p class="text-xs font-semibold text-slate-700 line-clamp-1 mb-2">
                            {{ $t->headline }}
                        </p>

                        <!-- Skills -->
                        <div class="flex flex-wrap gap-1 mb-4">
                            @foreach(array_slice($t->skills_array, 0, 3) as $skill)
                                <span class="text-[10px] px-2 py-0.5 rounded bg-slate-100 text-slate-600">
                                    {{ $skill }}
                                </span>
                            @endforeach
                            @if(count($t->skills_array) > 3)
                                <span class="text-[10px] px-1.5 py-0.5 text-slate-400">
                                    +{{ count($t->skills_array) - 3 }}
                                </span>
                            @endif
                        </div>

                        <p class="text-xs text-slate-500 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            {{ $t->portofolio->count() }} Proyek Portofolio
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ $t->link_github }}" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-slate-900 transition-colors" title="Buka GitHub">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                            </svg>
                        </a>
                        <a href="{{ route('talenta.detail', $t->id) }}" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-700">
                            Lihat Portofolio
                            <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $talenta->links() }}
        </div>
    @else
        <div class="py-16 text-center bg-white rounded-2xl border border-slate-200 p-8">
            <h3 class="text-base font-semibold text-slate-900">Tidak ada talenta yang cocok</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                Silakan coba sesuaikan kata kunci pencarian Anda.
            </p>
            <div class="mt-4">
                <a href="{{ route('talenta.index') }}" class="px-4 py-2 bg-slate-900 text-white text-xs font-semibold rounded-lg hover:bg-slate-800 transition-colors">
                    Reset Pencarian
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
