<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Pelamar;
use App\Models\Perusahaan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display comprehensive administrative ecosystem dashboard.
     */
    public function dashboard(): View
    {
        $totalPelamar = Pelamar::count();
        $totalPerusahaanVerified = Perusahaan::where('status_verifikasi', 'terverifikasi')->count();
        $totalPerusahaanPending = Perusahaan::where('status_verifikasi', 'pending')->count();
        $totalLowongan = Lowongan::count();
        $totalLowonganAktif = Lowongan::where('status_aktif', true)->count();
        $totalLamaran = Lamaran::count();
        $totalDiterima = Lamaran::where('status_lamaran', 'diterima')->count();
        $totalInterview = Lamaran::where('status_lamaran', 'interview')->count();

        // Calculate Graduate Absorption Rate
        $absorptionRate = $totalPelamar > 0 ? round(($totalDiterima / $totalPelamar) * 100, 1) : 0;

        // Pending partner approvals
        $perusahaanPending = Perusahaan::where('status_verifikasi', 'pending')->latest()->take(5)->get();

        // Latest system applications
        $lamaranTerbaru = Lamaran::with(['pelamar.user', 'lowongan.perusahaan'])->latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'totalPelamar',
            'totalPerusahaanVerified',
            'totalPerusahaanPending',
            'totalLowongan',
            'totalLowonganAktif',
            'totalLamaran',
            'totalDiterima',
            'totalInterview',
            'absorptionRate',
            'perusahaanPending',
            'lamaranTerbaru'
        ));
    }

    /**
     * Corporate partners verification management.
     */
    public function perusahaanIndex(Request $request): View
    {
        $query = Perusahaan::with('user');

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_perusahaan', 'like', "%{$search}%")
                    ->orWhere('kota', 'like', "%{$search}%")
                    ->orWhere('bidang_industri', 'like', "%{$search}%")
                    ->orWhere('email_hrd', 'like', "%{$search}%");
            });
        }

        $perusahaan = $query->latest()->paginate(10)->withQueryString();

        return view('admin.perusahaan_index', compact('perusahaan'));
    }

    /**
     * Approve or reject corporate partner.
     */
    public function verifikasiPerusahaan(Request $request, int $id): RedirectResponse
    {
        $perusahaan = Perusahaan::findOrFail($id);

        $validated = $request->validate([
            'status_verifikasi' => ['required', 'in:terverifikasi,ditolak,pending'],
        ]);

        $perusahaan->update($validated);

        $statusStr = match ($validated['status_verifikasi']) {
            'terverifikasi' => 'disetujui sebagai mitra terverifikasi',
            'ditolak' => 'ditolak',
            'pending' => 'dikembalikan ke status pending',
            default => 'diperbarui',
        };

        return redirect()->route('admin.perusahaan.index')
            ->with('success', "Status perusahaan '{$perusahaan->nama_perusahaan}' berhasil {$statusStr}.");
    }

    /**
     * System user accounts management.
     */
    public function usersIndex(Request $request): View
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(12)->withQueryString();

        return view('admin.users_index', compact('users'));
    }

    /**
     * Toggle active status of a user.
     */
    public function toggleUserStatus(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Prevent admin deactivating themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        $statusStr = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun '{$user->name}' berhasil {$statusStr}.");
    }

    /**
     * All job vacancies overview.
     */
    public function lowonganIndex(Request $request): View
    {
        $query = Lowongan::with(['perusahaan', 'lamaran']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul_lowongan', 'like', "%{$search}%")
                    ->orWhereHas('perusahaan', fn ($qp) => $qp->where('nama_perusahaan', 'like', "%{$search}%"));
            });
        }

        $lowongan = $query->latest()->paginate(10)->withQueryString();

        return view('admin.lowongan_index', compact('lowongan'));
    }

    /**
     * Program study executive placement report view.
     */
    public function laporan(): View
    {
        $totalPelamar = Pelamar::count();
        $totalDiterima = Lamaran::where('status_lamaran', 'diterima')->count();
        $totalInterview = Lamaran::where('status_lamaran', 'interview')->count();
        $totalLamaran = Lamaran::count();
        $totalPerusahaan = Perusahaan::where('status_verifikasi', 'terverifikasi')->count();

        $absorptionRate = $totalPelamar > 0 ? round(($totalDiterima / $totalPelamar) * 100, 1) : 0;

        // Placements list (diterima)
        $penempatan = Lamaran::with(['pelamar.user', 'lowongan.perusahaan'])
            ->where('status_lamaran', 'diterima')
            ->latest()
            ->get();

        // Overall summary per category
        $kategoriStats = Lowongan::selectRaw('kategori_bidang, count(*) as count')
            ->groupBy('kategori_bidang')
            ->get();

        return view('admin.laporan', compact(
            'totalPelamar',
            'totalDiterima',
            'totalInterview',
            'totalLamaran',
            'totalPerusahaan',
            'absorptionRate',
            'penempatan',
            'kategoriStats'
        ));
    }

    /**
     * Generate official formal executive report PDF with Faculty Kop Surat.
     */
    public function cetakLaporanPdf(): Response
    {
        $totalPelamar = Pelamar::count();
        $totalDiterima = Lamaran::where('status_lamaran', 'diterima')->count();
        $totalInterview = Lamaran::where('status_lamaran', 'interview')->count();
        $totalLamaran = Lamaran::count();
        $totalPerusahaan = Perusahaan::where('status_verifikasi', 'terverifikasi')->count();
        $absorptionRate = $totalPelamar > 0 ? round(($totalDiterima / $totalPelamar) * 100, 1) : 0;

        $penempatan = Lamaran::with(['pelamar.user', 'lowongan.perusahaan'])
            ->where('status_lamaran', 'diterima')
            ->latest()
            ->get();

        $allLamaran = Lamaran::with(['pelamar.user', 'lowongan.perusahaan'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('pdf.laporan_admin', compact(
            'totalPelamar',
            'totalDiterima',
            'totalInterview',
            'totalLamaran',
            'totalPerusahaan',
            'absorptionRate',
            'penempatan',
            'allLamaran'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('Laporan-Eksekutif-Prodi-D3TI-USU-'.date('Ymd').'.pdf');
    }
}
