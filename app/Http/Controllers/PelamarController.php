<?php

namespace App\Http\Controllers;

use App\Models\BookmarkLowongan;
use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Notifikasi;
use App\Models\Pelamar;
use App\Models\PortofolioProyek;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PelamarController extends Controller
{
    /**
     * Get the authenticated applicant's profile or create one if missing.
     */
    private function getPelamar(): Pelamar
    {
        $user = Auth::user();

        return $user->pelamar ?? Pelamar::create([
            'user_id' => $user->id,
            'nim' => 'NIM-'.$user->id,
            'angkatan' => date('Y'),
            'ipk' => 3.50,
            'no_telp' => '08xxxxxxxxxx',
            'alamat' => 'Alamat belum dilengkapi',
            'headline' => 'Lulusan D3 Teknik Informatika USU',
            'ringkasan_profil' => 'Lulusan D3 Teknik Informatika Fakultas Vokasi USU.',
            'keahlian' => 'Web Development, Laravel',
            'link_github' => 'https://github.com',
            'file_cv' => null,
        ]);
    }

    /**
     * Display applicant dashboard.
     */
    public function dashboard(): View
    {
        $pelamar = $this->getPelamar();
        $pelamar->load('portofolio');

        $totalLamaran = Lamaran::where('pelamar_id', $pelamar->id)->count();
        $totalMenunggu = Lamaran::where('pelamar_id', $pelamar->id)->whereIn('status_lamaran', ['dilamar', 'dilihat'])->count();
        $totalInterview = Lamaran::where('pelamar_id', $pelamar->id)->where('status_lamaran', 'interview')->count();
        $totalDiterima = Lamaran::where('pelamar_id', $pelamar->id)->where('status_lamaran', 'diterima')->count();

        // Calculate profile completion percentage
        $completionPoints = 0;
        if (! empty($pelamar->nim)) {
            $completionPoints += 15;
        }
        if (! empty($pelamar->ipk)) {
            $completionPoints += 15;
        }
        if (! empty($pelamar->headline)) {
            $completionPoints += 15;
        }
        if (! empty($pelamar->keahlian)) {
            $completionPoints += 15;
        }
        if (! empty($pelamar->link_github)) {
            $completionPoints += 15;
        }
        if (! empty($pelamar->file_cv)) {
            $completionPoints += 15;
        }
        if ($pelamar->portofolio->count() > 0) {
            $completionPoints += 10;
        }

        // Upcoming interview schedule
        $jadwalInterview = Lamaran::with(['lowongan.perusahaan'])
            ->where('pelamar_id', $pelamar->id)
            ->where('status_lamaran', 'interview')
            ->whereNotNull('jadwal_interview')
            ->orderBy('jadwal_interview')
            ->get();

        // Recent applications
        $lamaranTerbaru = Lamaran::with(['lowongan.perusahaan'])
            ->where('pelamar_id', $pelamar->id)
            ->latest()
            ->take(5)
            ->get();

        return view('pelamar.dashboard', compact(
            'pelamar',
            'totalLamaran',
            'totalMenunggu',
            'totalInterview',
            'totalDiterima',
            'completionPoints',
            'jadwalInterview',
            'lamaranTerbaru'
        ));
    }

    /**
     * Show profile & CV edit view.
     */
    public function profil(): View
    {
        $pelamar = $this->getPelamar();

        return view('pelamar.profil', compact('pelamar'));
    }

    /**
     * Update academic and personal profile data.
     */
    public function updateProfil(Request $request): RedirectResponse
    {
        $pelamar = $this->getPelamar();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:20', 'unique:pelamar,nim,'.$pelamar->id],
            'angkatan' => ['required', 'string', 'max:4'],
            'ipk' => ['required', 'numeric', 'between:0,4.00'],
            'no_telp' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string'],
            'headline' => ['required', 'string', 'max:255'],
            'ringkasan_profil' => ['required', 'string'],
            'keahlian' => ['required', 'string'],
            'link_github' => ['required', 'url', 'max:255'],
            'link_linkedin' => ['nullable', 'url', 'max:255'],
            'link_portofolio_web' => ['nullable', 'url', 'max:255'],
            'file_cv' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ], [
            'file_cv.mimes' => 'Berkas CV wajib berformat PDF.',
            'file_cv.max' => 'Ukuran berkas CV maksimal 2MB.',
            'nim.unique' => 'NIM sudah digunakan oleh profil lain.',
        ]);

        // Update User name
        $pelamar->user->update([
            'name' => $validated['name'],
        ]);

        // Handle CV upload
        if ($request->hasFile('file_cv')) {
            if ($pelamar->file_cv && Storage::disk('public')->exists($pelamar->file_cv)) {
                // Keep dummy-cv intact, delete previous unique upload
                if (! str_contains($pelamar->file_cv, 'dummy-cv')) {
                    Storage::disk('public')->delete($pelamar->file_cv);
                }
            }
            $cvPath = $request->file('file_cv')->store('cv', 'public');
            $validated['file_cv'] = $cvPath;
        } else {
            unset($validated['file_cv']);
        }

        unset($validated['name']);
        $pelamar->update($validated);

        return redirect()->route('pelamar.profil')
            ->with('success', 'Biodata akademik dan informasi profil berhasil diperbarui.');
    }

    /**
     * Portfolio projects management.
     */
    public function portofolio(): View
    {
        $pelamar = $this->getPelamar();
        $proyek = PortofolioProyek::where('pelamar_id', $pelamar->id)->latest()->get();

        return view('pelamar.portofolio', compact('pelamar', 'proyek'));
    }

    /**
     * Store new portfolio project.
     */
    public function storePortofolio(Request $request): RedirectResponse
    {
        $pelamar = $this->getPelamar();

        $validated = $request->validate([
            'judul_proyek' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:Web Application,Mobile Application,UI/UX Design,Data & AI,Networking & IoT'],
            'tech_stack' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'link_github' => ['required', 'url', 'max:255'],
            'link_demo' => ['nullable', 'url', 'max:255'],
        ], [
            'link_github.url' => 'Format tautan GitHub repository wajib valid.',
        ]);

        $validated['pelamar_id'] = $pelamar->id;
        PortofolioProyek::create($validated);

        return redirect()->route('pelamar.portofolio.index')
            ->with('success', 'Karya proyek portofolio baru berhasil ditambahkan.');
    }

    /**
     * Update existing portfolio project.
     */
    public function updatePortofolio(Request $request, int $id): RedirectResponse
    {
        $pelamar = $this->getPelamar();
        $proyek = PortofolioProyek::where('pelamar_id', $pelamar->id)->findOrFail($id);

        $validated = $request->validate([
            'judul_proyek' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:Web Application,Mobile Application,UI/UX Design,Data & AI,Networking & IoT'],
            'tech_stack' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'link_github' => ['required', 'url', 'max:255'],
            'link_demo' => ['nullable', 'url', 'max:255'],
        ]);

        $proyek->update($validated);

        return redirect()->route('pelamar.portofolio.index')
            ->with('success', 'Data portofolio proyek berhasil diperbarui.');
    }

    /**
     * Delete portfolio project.
     */
    public function destroyPortofolio(int $id): RedirectResponse
    {
        $pelamar = $this->getPelamar();
        $proyek = PortofolioProyek::where('pelamar_id', $pelamar->id)->findOrFail($id);
        $proyek->delete();

        return redirect()->route('pelamar.portofolio.index')
            ->with('success', 'Proyek portofolio telah dihapus.');
    }

    /**
     * Submit application to a job vacancy.
     */
    public function apply(Request $request, int $lowonganId): RedirectResponse
    {
        $pelamar = $this->getPelamar();
        $lowongan = Lowongan::where('status_aktif', true)->findOrFail($lowonganId);

        // Check if already applied
        if (Lamaran::where('lowongan_id', $lowongan->id)->where('pelamar_id', $pelamar->id)->exists()) {
            return back()->with('error', 'Anda telah mengirimkan lamaran untuk posisi ini sebelumnya.');
        }

        // Validate CV and GitHub requirement
        if (empty($pelamar->file_cv)) {
            return redirect()->route('pelamar.profil')
                ->with('error', 'Silakan unggah berkas CV PDF terlebih dahulu sebelum melamar lowongan pekerjaan.');
        }

        if (empty($pelamar->link_github)) {
            return redirect()->route('pelamar.profil')
                ->with('error', 'Silakan lengkapi tautan repository GitHub Anda di menu profil sebelum melamar.');
        }

        $validated = $request->validate([
            'surat_lamaran' => ['required', 'string', 'min:30'],
        ], [
            'surat_lamaran.required' => 'Surat lamaran singkat wajib diisi.',
            'surat_lamaran.min' => 'Surat lamaran minimal 30 karakter.',
        ]);

        $kodeLamaran = Lamaran::generateKodeLamaran();

        $lamaran = Lamaran::create([
            'kode_lamaran' => $kodeLamaran,
            'lowongan_id' => $lowongan->id,
            'pelamar_id' => $pelamar->id,
            'cv_snapshot' => $pelamar->file_cv,
            'github_snapshot' => $pelamar->link_github,
            'surat_lamaran' => $validated['surat_lamaran'],
            'status_lamaran' => 'dilamar',
            'jadwal_interview' => null,
            'metode_interview' => null,
            'link_atau_lokasi_interview' => null,
            'catatan_hrd' => 'Lamaran terkirim dan menunggu peninjauan oleh tim rekrutmen perusahaan.',
        ]);

        // Send In-App Notification to Company HRD
        Notifikasi::kirim(
            $lowongan->perusahaan->user_id,
            'Pelamar Baru Masuk',
            $pelamar->user->name.' telah mengajukan lamaran untuk posisi '.$lowongan->judul_lowongan.' (Kode: '.$kodeLamaran.').',
            route('perusahaan.pelamar.detail', $lamaran->id),
            'info'
        );

        return redirect()->route('pelamar.lamaran.show', $lamaran->kode_lamaran)

            ->with('success', 'Lamaran Anda berhasil dikirim ke '.$lowongan->perusahaan->nama_perusahaan.'. Kode Lamaran: '.$kodeLamaran);
    }

    /**
     * List all submitted applications.
     */
    public function lamaran(): View
    {
        $pelamar = $this->getPelamar();
        $lamaran = Lamaran::with(['lowongan.perusahaan'])
            ->where('pelamar_id', $pelamar->id)
            ->latest()
            ->paginate(10);

        return view('pelamar.lamaran_index', compact('pelamar', 'lamaran'));
    }

    /**
     * Show tracking status timeline for a specific application.
     */
    public function showLamaran(string $kode): View
    {
        $pelamar = $this->getPelamar();
        $lamaran = Lamaran::with(['lowongan.perusahaan', 'pelamar.user'])
            ->where('pelamar_id', $pelamar->id)
            ->where('kode_lamaran', $kode)
            ->firstOrFail();

        return view('pelamar.lamaran_tracking', compact('lamaran'));
    }

    /**
     * Generate PDF of interview invitation.
     */
    public function cetakBuktiInterview(string $kode): Response
    {
        $pelamar = $this->getPelamar();
        $lamaran = Lamaran::with(['lowongan.perusahaan', 'pelamar.user'])
            ->where('pelamar_id', $pelamar->id)
            ->where('kode_lamaran', $kode)
            ->where('status_lamaran', 'interview')
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.bukti_interview', compact('lamaran'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Undangan-Interview-'.$lamaran->kode_lamaran.'.pdf');
    }

    /**
     * List all saved / bookmarked job vacancies.
     */
    public function bookmarks(): View
    {
        $pelamar = $this->getPelamar();
        $bookmarks = BookmarkLowongan::with(['lowongan.perusahaan'])
            ->where('pelamar_id', $pelamar->id)
            ->latest()
            ->paginate(10);

        return view('pelamar.bookmarks', compact('pelamar', 'bookmarks'));
    }

    /**
     * Toggle bookmark state for a job vacancy.
     */
    public function toggleBookmark(int $lowonganId): RedirectResponse
    {
        $pelamar = $this->getPelamar();
        $lowongan = Lowongan::findOrFail($lowonganId);

        $existing = BookmarkLowongan::where('pelamar_id', $pelamar->id)
            ->where('lowongan_id', $lowongan->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Lowongan berhasil dihapus dari daftar simpanan.';
        } else {
            BookmarkLowongan::create([
                'pelamar_id' => $pelamar->id,
                'lowongan_id' => $lowongan->id,
            ]);
            $message = 'Lowongan berhasil disimpan ke daftar favorit Anda.';
        }

        return back()->with('success', $message);
    }

    /**
     * Generate official Academic Digital CV / Resume PDF with USU letterhead.
     */
    public function cetakCvDigital(?int $id = null): Response
    {
        if ($id) {
            $pelamar = Pelamar::with(['user', 'portofolio'])->findOrFail($id);
        } else {
            $pelamar = $this->getPelamar();
            $pelamar->load(['user', 'portofolio']);
        }

        $pdf = Pdf::loadView('pdf.cv_digital', compact('pelamar'))
            ->setPaper('a4', 'portrait');

        $filename = 'CV-Digital-D3TI-USU-'.str_replace(' ', '-', $pelamar->user->name).'.pdf';

        return $pdf->download($filename);
    }
}
