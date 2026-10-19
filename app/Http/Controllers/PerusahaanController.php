<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Notifikasi;
use App\Models\Perusahaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PerusahaanController extends Controller
{
    /**
     * Get authenticated company profile or abort.
     */
    private function getPerusahaan(): Perusahaan
    {
        $user = Auth::user();

        return $user->perusahaan ?? Perusahaan::create([
            'user_id' => $user->id,
            'nama_perusahaan' => $user->name,
            'slug' => Str::slug($user->name).'-'.Str::random(4),
            'bidang_industri' => 'Teknologi Informasi',
            'website' => null,
            'email_hrd' => $user->email,
            'no_telp' => '08xxxxxxxxxx',
            'alamat' => 'Kota Medan',
            'kota' => 'Kota Medan',
            'deskripsi' => 'Profil instansi perusahaan mitra rekrutmen D3 Teknik Informatika USU.',
            'logo' => null,
            'status_verifikasi' => 'pending',
        ]);
    }

    /**
     * Display corporate dashboard.
     */
    public function dashboard(): View
    {
        $perusahaan = $this->getPerusahaan();

        $totalLowonganAktif = Lowongan::where('perusahaan_id', $perusahaan->id)->where('status_aktif', true)->count();
        $totalPelamar = Lamaran::whereHas('lowongan', fn ($q) => $q->where('perusahaan_id', $perusahaan->id))->count();
        $totalInterview = Lamaran::whereHas('lowongan', fn ($q) => $q->where('perusahaan_id', $perusahaan->id))->where('status_lamaran', 'interview')->count();
        $totalDiterima = Lamaran::whereHas('lowongan', fn ($q) => $q->where('perusahaan_id', $perusahaan->id))->where('status_lamaran', 'diterima')->count();

        // Recent applications
        $lamaranTerbaru = Lamaran::with(['pelamar.user', 'lowongan'])
            ->whereHas('lowongan', fn ($q) => $q->where('perusahaan_id', $perusahaan->id))
            ->latest()
            ->take(6)
            ->get();

        // Active jobs preview
        $lowonganList = Lowongan::withCount('lamaran')
            ->where('perusahaan_id', $perusahaan->id)
            ->latest()
            ->take(4)
            ->get();

        return view('perusahaan.dashboard', compact(
            'perusahaan',
            'totalLowonganAktif',
            'totalPelamar',
            'totalInterview',
            'totalDiterima',
            'lamaranTerbaru',
            'lowonganList'
        ));
    }

    /**
     * Show company profile view.
     */
    public function profil(): View
    {
        $perusahaan = $this->getPerusahaan();

        return view('perusahaan.profil', compact('perusahaan'));
    }

    /**
     * Update company profile and logo.
     */
    public function updateProfil(Request $request): RedirectResponse
    {
        $perusahaan = $this->getPerusahaan();

        $validated = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'bidang_industri' => ['required', 'string', 'max:255'],
            'kota' => ['required', 'string', 'max:100'],
            'email_hrd' => ['required', 'email', 'max:255'],
            'no_telp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'deskripsi' => ['required', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            if ($perusahaan->logo && Storage::disk('public')->exists($perusahaan->logo)) {
                Storage::disk('public')->delete($perusahaan->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        } else {
            unset($validated['logo']);
        }

        $perusahaan->update($validated);
        $perusahaan->user->update(['name' => $validated['nama_perusahaan']]);

        return redirect()->route('perusahaan.profil')
            ->with('success', 'Profil instansi perusahaan berhasil diperbarui.');
    }

    /**
     * List all vacancies created by this company.
     */
    public function lowonganIndex(): View
    {
        $perusahaan = $this->getPerusahaan();
        $lowongan = Lowongan::withCount('lamaran')
            ->where('perusahaan_id', $perusahaan->id)
            ->latest()
            ->paginate(10);

        return view('perusahaan.lowongan_index', compact('perusahaan', 'lowongan'));
    }

    /**
     * Form to create a new job vacancy.
     */
    public function lowonganCreate(): View|RedirectResponse
    {
        $perusahaan = $this->getPerusahaan();

        if ($perusahaan->status_verifikasi === 'ditolak') {
            return redirect()->route('perusahaan.dashboard')
                ->with('error', 'Akun perusahaan Anda belum disetujui untuk mempublikasikan lowongan.');
        }

        return view('perusahaan.lowongan_create', compact('perusahaan'));
    }

    /**
     * Store new job vacancy.
     */
    public function lowonganStore(Request $request): RedirectResponse
    {
        $perusahaan = $this->getPerusahaan();

        $validated = $request->validate([
            'judul_lowongan' => ['required', 'string', 'max:255'],
            'kategori_bidang' => ['required', 'string', 'max:100'],
            'tipe_pekerjaan' => ['required', 'in:Full-time,Part-time,Internship,Contract'],
            'sistem_kerja' => ['required', 'in:On-site,Remote,Hybrid'],
            'lokasi' => ['required', 'string', 'max:255'],
            'rentang_gaji' => ['required', 'string', 'max:100'],
            'deskripsi_pekerjaan' => ['required', 'string'],
            'kualifikasi' => ['required', 'string'],
            'batas_lamaran' => ['required', 'date', 'after:today'],
        ]);

        $validated['perusahaan_id'] = $perusahaan->id;
        $validated['slug'] = Str::slug($validated['judul_lowongan'].' '.$perusahaan->nama_perusahaan).'-'.Str::random(5);
        $validated['status_aktif'] = true;

        Lowongan::create($validated);

        return redirect()->route('perusahaan.lowongan.index')
            ->with('success', 'Lowongan pekerjaan baru berhasil diterbitkan.');
    }

    /**
     * Form to edit vacancy.
     */
    public function lowonganEdit(int $id): View
    {
        $perusahaan = $this->getPerusahaan();
        $lowongan = Lowongan::where('perusahaan_id', $perusahaan->id)->findOrFail($id);

        return view('perusahaan.lowongan_edit', compact('perusahaan', 'lowongan'));
    }

    /**
     * Update job vacancy.
     */
    public function lowonganUpdate(Request $request, int $id): RedirectResponse
    {
        $perusahaan = $this->getPerusahaan();
        $lowongan = Lowongan::where('perusahaan_id', $perusahaan->id)->findOrFail($id);

        $validated = $request->validate([
            'judul_lowongan' => ['required', 'string', 'max:255'],
            'kategori_bidang' => ['required', 'string', 'max:100'],
            'tipe_pekerjaan' => ['required', 'in:Full-time,Part-time,Internship,Contract'],
            'sistem_kerja' => ['required', 'in:On-site,Remote,Hybrid'],
            'lokasi' => ['required', 'string', 'max:255'],
            'rentang_gaji' => ['required', 'string', 'max:100'],
            'deskripsi_pekerjaan' => ['required', 'string'],
            'kualifikasi' => ['required', 'string'],
            'batas_lamaran' => ['required', 'date'],
            'status_aktif' => ['required', 'boolean'],
        ]);

        $lowongan->update($validated);

        return redirect()->route('perusahaan.lowongan.index')
            ->with('success', 'Perubahan lowongan pekerjaan berhasil disimpan.');
    }

    /**
     * Toggle active status of a vacancy.
     */
    public function lowonganToggleStatus(int $id): RedirectResponse
    {
        $perusahaan = $this->getPerusahaan();
        $lowongan = Lowongan::where('perusahaan_id', $perusahaan->id)->findOrFail($id);
        $lowongan->update(['status_aktif' => ! $lowongan->status_aktif]);

        $statusStr = $lowongan->status_aktif ? 'diaktifkan kembali' : 'dinonaktifkan/ditutup';

        return back()->with('success', "Status lowongan '{$lowongan->judul_lowongan}' berhasil {$statusStr}.");
    }

    /**
     * Delete a vacancy.
     */
    public function lowonganDestroy(int $id): RedirectResponse
    {
        $perusahaan = $this->getPerusahaan();
        $lowongan = Lowongan::where('perusahaan_id', $perusahaan->id)->findOrFail($id);
        $lowongan->delete();

        return redirect()->route('perusahaan.lowongan.index')
            ->with('success', 'Lowongan pekerjaan telah dihapus.');
    }

    /**
     * Candidate selection list.
     */
    public function pelamarIndex(Request $request): View
    {
        $perusahaan = $this->getPerusahaan();

        $query = Lamaran::with(['pelamar.user', 'lowongan'])
            ->whereHas('lowongan', fn ($q) => $q->where('perusahaan_id', $perusahaan->id));

        if ($request->filled('lowongan_id')) {
            $query->where('lowongan_id', $request->input('lowongan_id'));
        }

        if ($request->filled('status_lamaran')) {
            $query->where('status_lamaran', $request->input('status_lamaran'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('kode_lamaran', 'like', "%{$search}%")
                    ->orWhereHas('pelamar', function ($qp) use ($search) {
                        $qp->where('nim', 'like', "%{$search}%")
                            ->orWhereHas('user', fn ($qu) => $qu->where('name', 'like', "%{$search}%"));
                    });
            });
        }

        $lamaran = $query->latest()->paginate(10)->withQueryString();
        $lowonganList = Lowongan::where('perusahaan_id', $perusahaan->id)->get();

        return view('perusahaan.pelamar_index', compact('perusahaan', 'lamaran', 'lowonganList'));
    }

    /**
     * Candidate inspection details and scheduling form.
     */
    public function pelamarDetail(int $id): View
    {
        $perusahaan = $this->getPerusahaan();
        $lamaran = Lamaran::with(['pelamar.user', 'pelamar.portofolio', 'lowongan'])
            ->whereHas('lowongan', fn ($q) => $q->where('perusahaan_id', $perusahaan->id))
            ->findOrFail($id);

        // Auto mark as 'dilihat' if currently 'dilamar'
        if ($lamaran->status_lamaran === 'dilamar') {
            $lamaran->update([
                'status_lamaran' => 'dilihat',
                'catatan_hrd' => 'Berkas dan portofolio kandidat telah ditinjau oleh HRD.',
            ]);
        }

        return view('perusahaan.pelamar_detail', compact('perusahaan', 'lamaran'));
    }

    /**
     * Update candidate application status & schedule E-Interview.
     */
    public function updateStatusLamaran(Request $request, int $id): RedirectResponse
    {
        $perusahaan = $this->getPerusahaan();
        $lamaran = Lamaran::whereHas('lowongan', fn ($q) => $q->where('perusahaan_id', $perusahaan->id))->findOrFail($id);

        $validated = $request->validate([
            'status_lamaran' => ['required', 'in:dilamar,dilihat,interview,diterima,ditolak'],
            'jadwal_interview' => ['nullable', 'required_if:status_lamaran,interview', 'date'],
            'metode_interview' => ['nullable', 'required_if:status_lamaran,interview', 'in:Online,Offline'],
            'link_atau_lokasi_interview' => ['nullable', 'required_if:status_lamaran,interview', 'string', 'max:255'],
            'catatan_hrd' => ['nullable', 'string'],
        ], [
            'jadwal_interview.required_if' => 'Waktu dan tanggal wajib diisi jika status diubah ke Tahap Interview.',
            'metode_interview.required_if' => 'Metode interview wajib dipilih jika status diubah ke Tahap Interview.',
            'link_atau_lokasi_interview.required_if' => 'Tautan meeting atau lokasi ruangan wajib diisi untuk undangan interview.',
        ]);

        $lamaran->update($validated);

        // Send In-App Notification to Applicant
        $statusLabel = match ($validated['status_lamaran']) {
            'interview' => 'Panggilan Interview Kerja',
            'diterima' => 'Selamat! Lamaran Anda Diterima',
            'ditolak' => 'Pemberitahuan Status Lamaran',
            default => 'Pembaruan Status Lamaran',
        };

        $statusMsg = match ($validated['status_lamaran']) {
            'interview' => 'Anda diundang ke tahap interview oleh '.$lamaran->lowongan->perusahaan->nama_perusahaan.' untuk posisi '.$lamaran->lowongan->judul_lowongan.'.',
            'diterima' => 'Selamat! Anda dinyatakan diterima pada posisi '.$lamaran->lowongan->judul_lowongan.' di '.$lamaran->lowongan->perusahaan->nama_perusahaan.'.',
            'ditolak' => 'Pemberitahuan: Proses seleksi Anda untuk posisi '.$lamaran->lowongan->judul_lowongan.' di '.$lamaran->lowongan->perusahaan->nama_perusahaan.' telah selesai.',
            default => 'Status lamaran Anda untuk posisi '.$lamaran->lowongan->judul_lowongan.' telah diperbarui menjadi '.ucfirst($validated['status_lamaran']).'.',
        };

        Notifikasi::kirim(
            $lamaran->pelamar->user_id,
            $statusLabel,
            $statusMsg,
            route('pelamar.lamaran.show', $lamaran->kode_lamaran),
            $validated['status_lamaran'] === 'interview' ? 'interview' : 'status'
        );

        return redirect()->route('perusahaan.pelamar.detail', $lamaran->id)

            ->with('success', 'Status seleksi pelamar dan jadwal berhasil diperbarui.');
    }

    /**
     * Recruitment report summary page.
     */
    public function laporan(Request $request): View
    {
        $perusahaan = $this->getPerusahaan();

        $query = Lamaran::with(['pelamar.user', 'lowongan'])
            ->whereHas('lowongan', fn ($q) => $q->where('perusahaan_id', $perusahaan->id));

        if ($request->filled('lowongan_id')) {
            $query->where('lowongan_id', $request->input('lowongan_id'));
        }

        if ($request->filled('status_lamaran')) {
            $query->where('status_lamaran', $request->input('status_lamaran'));
        }

        $lamaran = $query->latest()->get();
        $lowonganList = Lowongan::where('perusahaan_id', $perusahaan->id)->get();

        return view('perusahaan.laporan', compact('perusahaan', 'lamaran', 'lowonganList'));
    }

    /**
     * Download Recruitment Report PDF with company header.
     */
    public function cetakLaporanPdf(Request $request): Response
    {
        $perusahaan = $this->getPerusahaan();

        $query = Lamaran::with(['pelamar.user', 'lowongan'])
            ->whereHas('lowongan', fn ($q) => $q->where('perusahaan_id', $perusahaan->id));

        if ($request->filled('lowongan_id')) {
            $query->where('lowongan_id', $request->input('lowongan_id'));
        }

        if ($request->filled('status_lamaran')) {
            $query->where('status_lamaran', $request->input('status_lamaran'));
        }

        $lamaran = $query->latest()->get();

        $pdf = Pdf::loadView('pdf.laporan_perusahaan', compact('perusahaan', 'lamaran'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Rekrutmen-'.Str::slug($perusahaan->nama_perusahaan).'-'.date('Ymd').'.pdf');
    }
}
