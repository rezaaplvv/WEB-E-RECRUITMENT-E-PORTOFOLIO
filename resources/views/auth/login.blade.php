@extends('layouts.app')

@section('title', 'Masuk ke Sistem - E-Recruitment D3 TI USU')

@section('content')
<div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl border border-slate-200 shadow-sm" x-data="{
        fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    }">
        <!-- Header -->
        <div class="text-center">
            <div class="w-12 h-12 bg-blue-600 rounded-xl mx-auto flex items-center justify-center text-white mb-4 shadow-sm">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Masuk ke Portal</h1>
            <p class="mt-2 text-sm text-slate-600">
                Sistem E-Recruitment & E-Portofolio D3 Teknik Informatika
            </p>
        </div>

        <!-- Quick Demo Credential Autofill Buttons (Zero Emoji) -->
        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Akun Uji Coba Cepat (Klik untuk Mengisi):</p>
            <div class="grid grid-cols-3 gap-2">
                <button type="button" @click="fillCredentials('admin@vokasi.usu.ac.id', 'password')" class="px-2 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-200 hover:border-blue-500 hover:text-blue-600 rounded-lg shadow-2xs transition-all">
                    Admin Prodi
                </button>
                <button type="button" @click="fillCredentials('hrd@medantech.id', 'password')" class="px-2 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-200 hover:border-blue-500 hover:text-blue-600 rounded-lg shadow-2xs transition-all">
                    Perusahaan
                </button>
                <button type="button" @click="fillCredentials('pelamar@mahasiswa.usu.ac.id', 'password')" class="px-2 py-1.5 text-xs font-medium text-slate-700 bg-white border border-slate-200 hover:border-blue-500 hover:text-blue-600 rounded-lg shadow-2xs transition-all">
                    Pelamar
                </button>
            </div>
        </div>

        <!-- Login Form -->
        <form class="mt-8 space-y-5" action="{{ route('login.post') }}" method="POST">
            @csrf

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email</label>
                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                       class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-rose-500 @enderror"
                       placeholder="nama@domain.com">
                @error('email')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                       class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-rose-500 @enderror"
                       placeholder="••••••••">
                @error('password')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                    <label for="remember" class="ml-2 block text-xs text-slate-600">Ingat perangkat ini</label>
                </div>
            </div>

            <button type="submit"
                    class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Masuk ke Akun
            </button>
        </form>

        <div class="text-center text-xs text-slate-500 pt-2 border-t border-slate-100">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700">Daftar sekarang</a>
        </div>
    </div>
</div>
@endsection
