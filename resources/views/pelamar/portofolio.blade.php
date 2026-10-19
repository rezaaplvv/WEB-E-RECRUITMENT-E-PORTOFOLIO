@extends('layouts.dashboard')

@section('title', 'Portofolio Proyek')
@section('page_title', 'Kelola Portofolio Proyek Karya')
@section('page_subtitle', 'Tampilkan karya rekayasa perangkat lunak dan solusi TI terbaik Anda kepada mitra industri')

@section('content')
<div class="space-y-8" x-data="{
    modalOpen: false,
    editMode: false,
    formAction: '{{ route('pelamar.portofolio.store') }}',
    formData: {
        id: null,
        judul_proyek: '',
        kategori: 'Web Application',
        tech_stack: '',
        deskripsi: '',
        link_github: '',
        link_demo: ''
    },
    openCreateModal() {
        this.editMode = false;
        this.formAction = '{{ route('pelamar.portofolio.store') }}';
        this.formData = {
            id: null,
            judul_proyek: '',
            kategori: 'Web Application',
            tech_stack: '',
            deskripsi: '',
            link_github: '',
            link_demo: ''
        };
        this.modalOpen = true;
    },
    openEditModal(item) {
        this.editMode = true;
        this.formAction = '/pelamar/portofolio/' + item.id;
        this.formData = {
            id: item.id,
            judul_proyek: item.judul_proyek,
            kategori: item.kategori,
            tech_stack: item.tech_stack,
            deskripsi: item.deskripsi,
            link_github: item.link_github,
            link_demo: item.link_demo || ''
        };
        this.modalOpen = true;
    }
}">

    <!-- Top Action Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900">Daftar Karya Proyek Terdaftar ({{ $proyek->count() }})</h2>
            <p class="text-xs text-slate-500">Karya ini akan tampil di profil talenta publik Anda dan dapat ditinjau oleh HRD perusahaan saat Anda melamar.</p>
        </div>
        <button type="button" @click="openCreateModal()"
                class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-xl shadow-xs transition-colors flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Proyek Baru
        </button>
    </div>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($proyek as $item)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:border-blue-300 transition-all">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded bg-blue-50 text-blue-700 border border-blue-200">
                            {{ $item->kategori }}
                        </span>
                        <div class="flex items-center space-x-1">
                            <button type="button" @click="openEditModal({{ json_encode($item) }})"
                                    class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-colors" title="Edit Proyek">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <form action="{{ route('pelamar.portofolio.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors" title="Hapus Proyek">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <h3 class="text-base font-bold text-slate-900 mb-2">{{ $item->judul_proyek }}</h3>
                    <p class="text-xs text-slate-600 leading-relaxed line-clamp-3 mb-4">
                        {{ $item->deskripsi }}
                    </p>

                    <!-- Tech Stack Badges -->
                    <div class="flex flex-wrap gap-1 mb-4">
                        @foreach($item->tech_stack_array as $tech)
                            <span class="text-[10px] px-2 py-0.5 rounded bg-slate-100 text-slate-600">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ $item->link_github }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center text-xs font-semibold text-slate-700 hover:text-slate-900">
                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                        </svg>
                        GitHub Repo
                    </a>

                    @if($item->link_demo)
                        <a href="{{ $item->link_demo }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800">
                            Live Demo
                            <svg class="w-3.5 h-3.5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200 p-8">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 mx-auto flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">Belum Ada Proyek Ditambahkan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Mulai tambahkan tugas akhir, tugas kuliah, proyek magang, atau aplikasi personal Anda.
                </p>
                <button type="button" @click="openCreateModal()" class="mt-4 px-4 py-2 bg-blue-600 text-white font-semibold text-xs rounded-lg hover:bg-blue-700 transition-colors">
                    Tambah Proyek Sekarang
                </button>
            </div>
        @endforelse
    </div>

    <!-- Alpine.js Modal for Create / Edit Portfolio -->
    <div x-show="modalOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 flex items-center justify-center p-4"
         style="display: none;">
        
        <div class="bg-white rounded-2xl border border-slate-200 max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-xl" @click.away="modalOpen = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900" x-text="editMode ? 'Edit Proyek Portofolio' : 'Tambah Proyek Portofolio'"></h3>
                <button type="button" @click="modalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form :action="formAction" method="POST" class="space-y-4">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Proyek</label>
                    <input type="text" name="judul_proyek" x-model="formData.judul_proyek" required
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Contoh: Sistem E-Commerce Produk UMKM">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori Proyek</label>
                    <select name="kategori" x-model="formData.kategori" required
                            class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="Web Application">Web Application</option>
                        <option value="Mobile Application">Mobile Application</option>
                        <option value="UI/UX Design">UI/UX Design</option>
                        <option value="Data & AI">Data & AI</option>
                        <option value="Networking & IoT">Networking & IoT</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Teknologi yang Digunakan (Tech Stack)</label>
                    <input type="text" name="tech_stack" x-model="formData.tech_stack" required
                           class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Laravel 11, Tailwind CSS, MySQL, Alpine.js">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Proyek</label>
                    <textarea name="deskripsi" x-model="formData.deskripsi" rows="3" required
                              class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                              placeholder="Jelaskan tujuan aplikasi, fitur unggulan, dan peran Anda dalam pengembangannya"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tautan GitHub Repository</label>
                        <input type="url" name="link_github" x-model="formData.link_github" required
                               class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="https://github.com/...">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tautan Demo / APK (Opsional)</label>
                        <input type="url" name="link_demo" x-model="formData.link_demo"
                               class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                               placeholder="https://demo.example.com">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-2">
                    <button type="button" @click="modalOpen = false"
                            class="px-4 py-2 text-xs font-semibold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-5 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-2xs">
                        Simpan Proyek
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
