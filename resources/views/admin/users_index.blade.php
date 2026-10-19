@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna')
@section('page_title', 'Manajemen Akun Pengguna')
@section('page_subtitle', 'Kelola hak akses dan status keaktifan akun seluruh pengguna platform')

@section('content')
<div class="space-y-6">
    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
        <form action="{{ route('admin.users.index') }}" method="GET">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <label for="search" class="block text-xs font-semibold text-slate-600 mb-1">Cari Akun</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                               placeholder="Nama pengguna atau alamat email..."
                               class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-xs font-semibold text-slate-600 mb-1">Peran Akun</label>
                    <select id="role" name="role" class="w-full px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Peran</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin Prodi</option>
                        <option value="perusahaan" {{ request('role') == 'perusahaan' ? 'selected' : '' }}>Perusahaan Mitra</option>
                        <option value="pelamar" {{ request('role') == 'pelamar' ? 'selected' : '' }}>Pelamar / Mahasiswa</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between pt-3 border-t border-slate-100">
                <span class="text-xs text-slate-500">Total <strong>{{ $users->total() }}</strong> akun terdaftar</span>
                <div class="flex items-center space-x-2">
                    @if(request()->hasAny(['search', 'role']))
                        <a href="{{ route('admin.users.index') }}" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:text-slate-900">
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

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                        <th class="py-3.5 px-6">Nama Pengguna</th>
                        <th class="py-3.5 px-6">Email Terdaftar</th>
                        <th class="py-3.5 px-6">Peran (Role)</th>
                        <th class="py-3.5 px-6">Status Akun</th>
                        <th class="py-3.5 px-6">Waktu Bergabung</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-6 font-bold text-slate-900">
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="text-[10px] text-blue-600 font-semibold ml-1">(Anda)</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 font-mono text-slate-600">
                                {{ $user->email }}
                            </td>
                            <td class="py-3.5 px-6">
                                @php
                                    $roleBadge = match($user->role) {
                                        'admin' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'perusahaan' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'pelamar' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        default => 'bg-slate-50 text-slate-700 border-slate-200',
                                    };
                                    $roleName = match($user->role) {
                                        'admin' => 'Admin Prodi',
                                        'perusahaan' => 'Perusahaan',
                                        'pelamar' => 'Pelamar (D3 TI)',
                                        default => $user->role,
                                    };
                                @endphp
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold border {{ $roleBadge }}">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold {{ $user->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-500">
                                {{ $user->created_at->isoFormat('D MMM Y') }}
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Ubah status keaktifan akun ini?');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 rounded-lg text-xs font-semibold transition-colors {{ $user->is_active ? 'bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200' }}">
                                            {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[11px] text-slate-400">Terkunci</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500">
                                Tidak ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
