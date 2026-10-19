<?php

namespace App\Http\Controllers;

use App\Models\Pelamar;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the unified login page.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'perusahaan' => redirect()->route('perusahaan.dashboard'),
                'pelamar' => redirect()->route('pelamar.dashboard'),
                default => redirect('/'),
            };
        }

        return view('auth.login');
    }

    /**
     * Handle login authentication.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if (! $user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withInput($request->only('email'))
                    ->withErrors(['email' => 'Akun Anda dinonaktifkan oleh administrator.']);
            }

            $request->session()->regenerate();

            return match ($user->role) {
                'admin' => redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang kembali, Administrator.'),
                'perusahaan' => redirect()->intended(route('perusahaan.dashboard'))
                    ->with('success', 'Selamat datang di Panel Perusahaan Mitra.'),
                'pelamar' => redirect()->intended(route('pelamar.dashboard'))
                    ->with('success', 'Selamat datang kembali di Portal E-Recruitment D3 TI.'),
                default => redirect('/'),
            };
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => 'Kombinasi email dan kata sandi tidak cocok dengan data kami.']);
    }

    /**
     * Show the unified registration page with dual-role tabs.
     */
    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.register');
    }

    /**
     * Handle applicant (Pelamar / Mahasiswa) registration.
     */
    public function registerPelamar(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nim' => ['required', 'string', 'max:20', 'unique:pelamar,nim'],
            'angkatan' => ['required', 'string', 'max:4'],
            'ipk' => ['required', 'numeric', 'between:0,4.00'],
            'no_telp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'headline' => ['required', 'string', 'max:255'],
            'keahlian' => ['required', 'string'],
            'link_github' => ['required', 'url', 'max:255'],
        ], [
            'email.unique' => 'Alamat email sudah terdaftar di sistem.',
            'nim.unique' => 'NIM sudah terdaftar. Silakan hubungi prodi jika ada kekeliruan.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'link_github.url' => 'Format URL GitHub wajib valid (contoh: https://github.com/username).',
        ]);

        DB::transaction(function () use ($validated, &$user) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'pelamar',
                'is_active' => true,
            ]);

            Pelamar::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'angkatan' => $validated['angkatan'],
                'ipk' => $validated['ipk'],
                'no_telp' => $validated['no_telp'],
                'alamat' => $validated['alamat'],
                'headline' => $validated['headline'],
                'ringkasan_profil' => 'Lulusan Program Studi D3 Teknik Informatika USU berdedikasi dengan fokus keahlian di bidang rekayasa perangkat lunak.',
                'keahlian' => $validated['keahlian'],
                'link_github' => $validated['link_github'],
                'link_linkedin' => null,
                'link_portofolio_web' => null,
                'file_cv' => null,
            ]);
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('pelamar.profil')
            ->with('success', 'Akun berhasil dibuat. Silakan lengkapi berkas CV dan portofolio proyek Anda.');
    }

    /**
     * Handle corporate partner (Perusahaan) registration.
     */
    public function registerPerusahaan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'bidang_industri' => ['required', 'string', 'max:255'],
            'kota' => ['required', 'string', 'max:100'],
            'no_telp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'deskripsi' => ['required', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
        ], [
            'email.unique' => 'Alamat email perusahaan sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        DB::transaction(function () use ($validated, &$user) {
            $user = User::create([
                'name' => $validated['nama_perusahaan'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'perusahaan',
                'is_active' => true,
            ]);

            Perusahaan::create([
                'user_id' => $user->id,
                'nama_perusahaan' => $validated['nama_perusahaan'],
                'slug' => Str::slug($validated['nama_perusahaan']).'-'.Str::random(4),
                'bidang_industri' => $validated['bidang_industri'],
                'website' => $validated['website'] ?? null,
                'email_hrd' => $validated['email'],
                'no_telp' => $validated['no_telp'],
                'alamat' => $validated['alamat'],
                'kota' => $validated['kota'],
                'deskripsi' => $validated['deskripsi'],
                'logo' => null,
                'status_verifikasi' => 'pending',
            ]);
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('perusahaan.dashboard')
            ->with('info', 'Pendaftaran berhasil. Akun Anda sedang dalam proses verifikasi oleh Admin Program Studi D3 TI.');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
