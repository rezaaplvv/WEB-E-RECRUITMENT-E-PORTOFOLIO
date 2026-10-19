<?php

namespace Tests\Feature;

use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Pelamar;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecruitmentSystemTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Test public pages accessibility.
     */
    public function test_public_pages_are_accessible(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/lowongan')->assertStatus(200);
        $this->get('/talenta')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
    }

    /**
     * Test single job vacancy detail page.
     */
    public function test_detail_lowongan_page(): void
    {
        $lowongan = Lowongan::first();
        if ($lowongan) {
            $response = $this->get('/lowongan/'.$lowongan->slug);
            $response->assertStatus(200);
            $response->assertSee($lowongan->judul_lowongan);
        }
    }

    /**
     * Test single talent detail page.
     */
    public function test_detail_talenta_page(): void
    {
        $pelamar = Pelamar::first();
        if ($pelamar) {
            $response = $this->get('/talenta/'.$pelamar->id);
            $response->assertStatus(200);
            $response->assertSee($pelamar->user->name);
        }
    }

    /**
     * Test login functionality with valid user.
     */
    public function test_user_can_login_and_redirects_to_correct_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $response = $this->post('/login', [
                'email' => $admin->email,
                'password' => 'password',
            ]);
            $response->assertRedirect('/admin/dashboard');
        }
    }

    /**
     * Test pelamar authenticated access and interview PDF.
     */
    public function test_pelamar_can_access_dashboard_and_download_pdf(): void
    {
        $user = User::where('role', 'pelamar')->first();
        if ($user) {
            $this->actingAs($user);
            $this->get('/pelamar/dashboard')->assertStatus(200);
            $this->get('/pelamar/profil')->assertStatus(200);
            $this->get('/pelamar/portofolio')->assertStatus(200);
            $this->get('/pelamar/lamaran')->assertStatus(200);

            $interviewLamaran = Lamaran::where('pelamar_id', $user->pelamar->id)
                ->where('status_lamaran', 'interview')
                ->first();

            if ($interviewLamaran) {
                $this->get('/pelamar/lamaran/'.$interviewLamaran->kode_lamaran)->assertStatus(200);
                $pdfResponse = $this->get('/pelamar/lamaran/'.$interviewLamaran->kode_lamaran.'/cetak-interview');
                $pdfResponse->assertStatus(200);
                $pdfResponse->assertHeader('content-type', 'application/pdf');
            }
        }
    }

    /**
     * Test perusahaan authenticated access and recruitment PDF.
     */
    public function test_perusahaan_can_access_dashboard_and_download_pdf(): void
    {
        $user = User::where('role', 'perusahaan')->first();
        if ($user) {
            $this->actingAs($user);
            $this->get('/perusahaan/dashboard')->assertStatus(200);
            $this->get('/perusahaan/profil')->assertStatus(200);
            $this->get('/perusahaan/lowongan')->assertStatus(200);
            $this->get('/perusahaan/pelamar')->assertStatus(200);
            $this->get('/perusahaan/laporan')->assertStatus(200);

            $pdfResponse = $this->get('/perusahaan/laporan/cetak-pdf');
            $pdfResponse->assertStatus(200);
            $pdfResponse->assertHeader('content-type', 'application/pdf');
        }
    }

    /**
     * Test admin authenticated access and executive PDF.
     */
    public function test_admin_can_access_dashboard_and_download_pdf(): void
    {
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $this->actingAs($admin);
            $this->get('/admin/dashboard')->assertStatus(200);
            $this->get('/admin/perusahaan')->assertStatus(200);
            $this->get('/admin/users')->assertStatus(200);
            $this->get('/admin/lowongan')->assertStatus(200);
            $this->get('/admin/laporan')->assertStatus(200);

            $pdfResponse = $this->get('/admin/laporan/cetak-pdf');
            $pdfResponse->assertStatus(200);
            $pdfResponse->assertHeader('content-type', 'application/pdf');
        }
    }

    /**
     * Test pelamar registration creates user and applicant profile.
     */
    public function test_pelamar_registration_flow(): void
    {
        $response = $this->post('/register/pelamar', [
            'name' => 'Budi Santoso',
            'email' => 'budisantoso@mahasiswa.usu.ac.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nim' => '210502999',
            'angkatan' => '2023',
            'ipk' => '3.80',
            'no_telp' => '081299998888',
            'alamat' => 'Jl. Dr. Mansyur No. 9, Medan',
            'headline' => 'Junior Web Developer',
            'keahlian' => 'PHP, Laravel, MySQL',
            'link_github' => 'https://github.com/budisantoso',
        ]);

        $response->assertRedirect('/pelamar/profil');
        $this->assertDatabaseHas('users', [
            'email' => 'budisantoso@mahasiswa.usu.ac.id',
            'role' => 'pelamar',
        ]);
        $this->assertDatabaseHas('pelamar', [
            'nim' => '210502999',
            'ipk' => 3.80,
        ]);
    }

    /**
     * Test corporate partner registration creates user and pending company profile.
     */
    public function test_perusahaan_registration_flow(): void
    {
        $response = $this->post('/register/perusahaan', [
            'nama_perusahaan' => 'PT Andalas Digital Solusi',
            'email' => 'contact@andalasdigital.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'bidang_industri' => 'Information Technology',
            'kota' => 'Medan',
            'no_telp' => '061-8889999',
            'alamat' => 'Komp. Ruko Adam Malik, Medan',
            'deskripsi' => 'Perusahaan konsultan IT dan pengembang perangkat lunak.',
            'website' => 'https://andalasdigital.id',
        ]);

        $response->assertRedirect('/perusahaan/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'contact@andalasdigital.id',
            'role' => 'perusahaan',
        ]);
        $this->assertDatabaseHas('perusahaan', [
            'nama_perusahaan' => 'PT Andalas Digital Solusi',
            'status_verifikasi' => 'pending',
        ]);
    }

    /**
     * Test pelamar can apply to an active job vacancy.
     */
    public function test_pelamar_can_apply_job_and_generate_lamaran(): void
    {
        $user = User::where('role', 'pelamar')->first();
        $this->actingAs($user);

        // Find a job vacancy not yet applied by this pelamar
        $appliedLowonganIds = Lamaran::where('pelamar_id', $user->pelamar->id)->pluck('lowongan_id')->toArray();
        $lowongan = Lowongan::where('status_aktif', true)
            ->whereNotIn('id', $appliedLowonganIds)
            ->first();

        if ($lowongan) {
            $response = $this->post('/pelamar/lowongan/'.$lowongan->id.'/apply', [
                'surat_lamaran' => 'Dengan hormat, saya mengajukan lamaran ini dengan penuh antusias untuk posisi yang tersedia.',
            ]);

            $response->assertSessionHas('success');
            $this->assertDatabaseHas('lamaran', [
                'lowongan_id' => $lowongan->id,
                'pelamar_id' => $user->pelamar->id,
                'status_lamaran' => 'dilamar',
            ]);
        }
    }

    /**
     * Test perusahaan can update application status and schedule interview.
     */
    public function test_perusahaan_can_update_lamaran_status_and_schedule_interview(): void
    {
        $perusahaanUser = User::where('role', 'perusahaan')->first();
        $perusahaan = $perusahaanUser->perusahaan;
        $this->actingAs($perusahaanUser);

        // Find an application belonging to this perusahaan
        $lamaran = Lamaran::whereHas('lowongan', function ($query) use ($perusahaan) {
            $query->where('perusahaan_id', $perusahaan->id);
        })->first();

        if ($lamaran) {
            $response = $this->post('/perusahaan/pelamar/'.$lamaran->id.'/status', [
                'status_lamaran' => 'interview',
                'jadwal_interview' => '2026-11-01 09:30:00',
                'metode_interview' => 'Online',
                'link_atau_lokasi_interview' => 'https://meet.google.com/test-meet-code',
                'catatan_hrd' => 'Harap persiapkan portofolio proyek dan CV untuk sesi wawancara teknis.',
            ]);

            $response->assertRedirect('/perusahaan/pelamar/'.$lamaran->id);
            $response->assertSessionHas('success');

            $this->assertDatabaseHas('lamaran', [
                'id' => $lamaran->id,
                'status_lamaran' => 'interview',
                'metode_interview' => 'Online',
            ]);
        }
    }

    /**
     * Test admin can verify pending company.
     */
    public function test_admin_can_verify_perusahaan(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin);

        $pendingCompany = Perusahaan::where('status_verifikasi', 'pending')->first();
        if ($pendingCompany) {
            $response = $this->post('/admin/perusahaan/'.$pendingCompany->id.'/verifikasi', [
                'status_verifikasi' => 'terverifikasi',
            ]);

            $response->assertRedirect('/admin/perusahaan');
            $response->assertSessionHas('success');

            $this->assertDatabaseHas('perusahaan', [
                'id' => $pendingCompany->id,
                'status_verifikasi' => 'terverifikasi',
            ]);
        }
    }
}
