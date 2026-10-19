<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Notifikasi;
use App\Models\Pelamar;
use App\Models\Perusahaan;
use App\Models\PortofolioProyek;
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

        // Portfolio category distribution
        $totalProyek = PortofolioProyek::count();
        $kategoriProyek = PortofolioProyek::selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get()
            ->map(function ($item) use ($totalProyek) {
                $item->persentase = $totalProyek > 0 ? round(($item->total / $totalProyek) * 100, 1) : 0;

                return $item;
            });

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
            'totalProyek',
            'kategoriProyek',
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

        // Send In-App Notification to Company
        $verifikasiMsg = $validated['status_verifikasi'] === 'terverifikasi'
            ? 'Selamat! Akun kemitraan perusahaan Anda telah diverifikasi oleh Administrator Program Studi D3 TI USU.'
            : 'Status kemitraan perusahaan Anda telah diperbarui menjadi: '.ucfirst($validated['status_verifikasi']).'.';

        Notifikasi::kirim(
            $perusahaan->user_id,
            'Status Verifikasi Perusahaan',
            $verifikasiMsg,
            route('perusahaan.dashboard'),
            'verifikasi'
        );

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
    public function laporan(Request $request): View
    {
        $selectedAngkatan = $request->input('angkatan');
        $angkatanList = Pelamar::select('angkatan')->distinct()->orderByDesc('angkatan')->pluck('angkatan');

        $queryPelamar = Pelamar::query();
        if ($selectedAngkatan) {
            $queryPelamar->where('angkatan', $selectedAngkatan);
        }
        $totalPelamar = $queryPelamar->count();

        $queryPenempatan = Lamaran::with(['pelamar.user', 'lowongan.perusahaan'])
            ->where('status_lamaran', 'diterima');
        if ($selectedAngkatan) {
            $queryPenempatan->whereHas('pelamar', fn ($q) => $q->where('angkatan', $selectedAngkatan));
        }
        $penempatan = $queryPenempatan->latest()->get();
        $totalDiterima = $penempatan->count();

        $queryInterview = Lamaran::where('status_lamaran', 'interview');
        if ($selectedAngkatan) {
            $queryInterview->whereHas('pelamar', fn ($q) => $q->where('angkatan', $selectedAngkatan));
        }
        $totalInterview = $queryInterview->count();

        $queryLamaran = Lamaran::query();
        if ($selectedAngkatan) {
            $queryLamaran->whereHas('pelamar', fn ($q) => $q->where('angkatan', $selectedAngkatan));
        }
        $totalLamaran = $queryLamaran->count();

        $totalPerusahaan = Perusahaan::where('status_verifikasi', 'terverifikasi')->count();
        $absorptionRate = $totalPelamar > 0 ? round(($totalDiterima / $totalPelamar) * 100, 1) : 0;

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
            'kategoriStats',
            'selectedAngkatan',
            'angkatanList'
        ));
    }

    /**
     * Generate official formal executive report PDF with Faculty Kop Surat.
     */
    public function cetakLaporanPdf(Request $request): Response
    {
        $selectedAngkatan = $request->input('angkatan');

        $queryPelamar = Pelamar::query();
        if ($selectedAngkatan) {
            $queryPelamar->where('angkatan', $selectedAngkatan);
        }
        $totalPelamar = $queryPelamar->count();

        $queryPenempatan = Lamaran::with(['pelamar.user', 'lowongan.perusahaan'])
            ->where('status_lamaran', 'diterima');
        if ($selectedAngkatan) {
            $queryPenempatan->whereHas('pelamar', fn ($q) => $q->where('angkatan', $selectedAngkatan));
        }
        $penempatan = $queryPenempatan->latest()->get();
        $totalDiterima = $penempatan->count();

        $queryInterview = Lamaran::where('status_lamaran', 'interview');
        if ($selectedAngkatan) {
            $queryInterview->whereHas('pelamar', fn ($q) => $q->where('angkatan', $selectedAngkatan));
        }
        $totalInterview = $queryInterview->count();

        $queryLamaran = Lamaran::query();
        if ($selectedAngkatan) {
            $queryLamaran->whereHas('pelamar', fn ($q) => $q->where('angkatan', $selectedAngkatan));
        }
        $totalLamaran = $queryLamaran->count();

        $totalPerusahaan = Perusahaan::where('status_verifikasi', 'terverifikasi')->count();
        $absorptionRate = $totalPelamar > 0 ? round(($totalDiterima / $totalPelamar) * 100, 1) : 0;

        $queryAllLamaran = Lamaran::with(['pelamar.user', 'lowongan.perusahaan']);
        if ($selectedAngkatan) {
            $queryAllLamaran->whereHas('pelamar', fn ($q) => $q->where('angkatan', $selectedAngkatan));
        }
        $allLamaran = $queryAllLamaran->latest()->get();

        $pdf = Pdf::loadView('pdf.laporan_admin', compact(
            'totalPelamar',
            'totalDiterima',
            'totalInterview',
            'totalLamaran',
            'totalPerusahaan',
            'absorptionRate',
            'penempatan',
            'allLamaran',
            'selectedAngkatan'
        ))->setPaper('a4', 'portrait');

        $suffix = $selectedAngkatan ? '-Angkatan-'.$selectedAngkatan : '';

        return $pdf->download('Laporan-Eksekutif-Prodi-D3TI-USU'.$suffix.'-'.date('Ymd').'.pdf');
    }
}
