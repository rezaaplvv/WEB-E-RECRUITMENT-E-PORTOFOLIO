<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Pelamar;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * Display public landing page.
     */
    public function index(): View
    {
        $totalLowongan = Lowongan::where('status_aktif', true)->count();
        $totalPerusahaan = Perusahaan::where('status_verifikasi', 'terverifikasi')->count();
        $totalPelamar = Pelamar::count();
        $totalDiterima = Lamaran::where('status_lamaran', 'diterima')->count();

        // 6 Latest active job vacancies
        $lowonganTerbaru = Lowongan::with('perusahaan')
            ->where('status_aktif', true)
            ->whereDate('batas_lamaran', '>=', now())
            ->latest()
            ->take(6)
            ->get();

        // 4 Featured graduate talents with portfolio
        $talentaUnggulan = Pelamar::with(['user', 'portofolio'])
            ->has('portofolio')
            ->latest()
            ->take(4)
            ->get();

        return view('public.index', compact(
            'totalLowongan',
            'totalPerusahaan',
            'totalPelamar',
            'totalDiterima',
            'lowonganTerbaru',
            'talentaUnggulan'
        ));
    }

    /**
     * Display job vacancy catalog with filters.
     */
    public function lowongan(Request $request): View
    {
        $query = Lowongan::with('perusahaan')
            ->where('status_aktif', true)
            ->whereDate('batas_lamaran', '>=', now());

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('judul_lowongan', 'like', "%{$keyword}%")
                    ->orWhere('kategori_bidang', 'like', "%{$keyword}%")
                    ->orWhere('lokasi', 'like', "%{$keyword}%")
                    ->orWhereHas('perusahaan', function ($qp) use ($keyword) {
                        $qp->where('nama_perusahaan', 'like', "%{$keyword}%")
                            ->orWhere('kota', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('tipe_pekerjaan')) {
            $query->where('tipe_pekerjaan', $request->input('tipe_pekerjaan'));
        }

        if ($request->filled('sistem_kerja')) {
            $query->where('sistem_kerja', $request->input('sistem_kerja'));
        }

        $lowongan = $query->latest()->paginate(9)->withQueryString();

        return view('public.lowongan', compact('lowongan'));
    }

    /**
     * Display job vacancy details.
     */
    public function detailLowongan(string $slug): View
    {
        $lowongan = Lowongan::with(['perusahaan', 'lamaran'])->where('slug', $slug)->firstOrFail();

        // Related jobs in the same category or company
        $lowonganTerkait = Lowongan::with('perusahaan')
            ->where('id', '!=', $lowongan->id)
            ->where('status_aktif', true)
            ->where(function ($q) use ($lowongan) {
                $q->where('kategori_bidang', $lowongan->kategori_bidang)
                    ->orWhere('perusahaan_id', $lowongan->perusahaan_id);
            })
            ->latest()
            ->take(3)
            ->get();

        // Check if current authenticated pelamar has applied
        $sudahMelamar = false;
        $lamaranSaya = null;
        if (auth()->check() && auth()->user()->isPelamar() && auth()->user()->pelamar) {
            $lamaranSaya = Lamaran::where('lowongan_id', $lowongan->id)
                ->where('pelamar_id', auth()->user()->pelamar->id)
                ->first();
            $sudahMelamar = $lamaranSaya !== null;
        }

        return view('public.detail_lowongan', compact('lowongan', 'lowonganTerkait', 'sudahMelamar', 'lamaranSaya'));
    }

    /**
     * Display talent e-portfolio directory.
     */
    public function talenta(Request $request): View
    {
        $query = Pelamar::with(['user', 'portofolio']);

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('headline', 'like', "%{$keyword}%")
                    ->orWhere('keahlian', 'like', "%{$keyword}%")
                    ->orWhere('nim', 'like', "%{$keyword}%")
                    ->orWhereHas('user', function ($qu) use ($keyword) {
                        $qu->where('name', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->input('angkatan'));
        }

        $talenta = $query->latest()->paginate(12)->withQueryString();

        return view('public.talenta', compact('talenta'));
    }

    /**
     * Display single talent's detailed profile and portfolio showcase.
     */
    public function detailTalenta(int $id): View
    {
        $pelamar = Pelamar::with(['user', 'portofolio'])->findOrFail($id);

        return view('public.detail_talenta', compact('pelamar'));
    }
}
