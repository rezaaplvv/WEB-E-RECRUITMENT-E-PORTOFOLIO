<?php

namespace Database\Seeders;

use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Pelamar;
use App\Models\Perusahaan;
use App\Models\PortofolioProyek;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure storage directory for CV and Logos exists
        Storage::disk('public')->makeDirectory('cv');
        Storage::disk('public')->makeDirectory('logos');

        // Create sample CV PDF if not exists
        $dummyCvPath = 'cv/dummy-cv.pdf';
        if (! Storage::disk('public')->exists($dummyCvPath)) {
            $pdf = Pdf::loadHTML('
                <div style="font-family: sans-serif; padding: 30px; line-height: 1.6;">
                    <h1 style="color: #1e293b; border-bottom: 2px solid #2563eb; padding-bottom: 10px;">CURRICULUM VITAE</h1>
                    <h2 style="color: #334155; margin-top: 5px;">Lulusan D3 Teknik Informatika - Fakultas Vokasi USU</h2>
                    <hr style="border: 0; border-top: 1px solid #cbd5e1; margin: 15px 0;">
                    <p><strong>Nama:</strong> Mahasiswa / Alumni D3 TI USU</p>
                    <p><strong>Program Studi:</strong> D3 Teknik Informatika</p>
                    <p><strong>Fakultas:</strong> Fakultas Vokasi, Universitas Sumatera Utara</p>
                    <p><strong>Kompetensi:</strong> Web Application Development, Mobile Development, Database Administration, UI/UX Design, Cloud Infrastructure.</p>
                    <p><strong>Dokumen ini sah</strong> dihasilkan oleh Sistem E-Recruitment & E-Portofolio D3 TI USU.</p>
                </div>
            ');
            Storage::disk('public')->put($dummyCvPath, $pdf->output());
        }

        // 1. Akun Admin Prodi D3 TI USU
        User::create([
            'name' => 'Administrator Prodi D3 TI',
            'email' => 'admin@vokasi.usu.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // 2. Tiga Akun Perusahaan Terverifikasi + 1 Pending
        $ptMedan = User::create([
            'name' => 'PT Medan Solusi Teknologi',
            'email' => 'hrd@medantech.id',
            'password' => Hash::make('password'),
            'role' => 'perusahaan',
            'is_active' => true,
        ]);

        $perusahaan1 = Perusahaan::create([
            'user_id' => $ptMedan->id,
            'nama_perusahaan' => 'PT Medan Solusi Teknologi',
            'slug' => Str::slug('PT Medan Solusi Teknologi'),
            'bidang_industri' => 'Information Technology & Software Services',
            'website' => 'https://medantech.id',
            'email_hrd' => 'hrd@medantech.id',
            'no_telp' => '081260001111',
            'alamat' => 'Jl. Iskandar Muda No. 120, Babura, Kec. Medan Baru',
            'kota' => 'Kota Medan',
            'deskripsi' => 'Perusahaan konsultan IT dan penyedia solusi software enterprise terkemuka di Kota Medan yang berfokus pada transformasi digital industri perbankan dan logistik.',
            'logo' => null,
            'status_verifikasi' => 'terverifikasi',
        ]);

        $cvSumatera = User::create([
            'name' => 'CV Sumatera Digital Kreatif',
            'email' => 'career@sumateradigital.co.id',
            'password' => Hash::make('password'),
            'role' => 'perusahaan',
            'is_active' => true,
        ]);

        $perusahaan2 = Perusahaan::create([
            'user_id' => $cvSumatera->id,
            'nama_perusahaan' => 'CV Sumatera Digital Kreatif',
            'slug' => Str::slug('CV Sumatera Digital Kreatif'),
            'bidang_industri' => 'Creative Digital Agency & UI/UX Studio',
            'website' => 'https://sumateradigital.co.id',
            'email_hrd' => 'career@sumateradigital.co.id',
            'no_telp' => '081260002222',
            'alamat' => 'Jl. Dr. Mansyur No. 45, Padang Bulan, Kec. Medan Selayang',
            'kota' => 'Kota Medan',
            'deskripsi' => 'Digital agency dinamis yang mengkhususkan diri pada pengembangan produk web interaktif, aplikasi mobile modern, serta riset pengalaman pengguna (UI/UX).',
            'logo' => null,
            'status_verifikasi' => 'terverifikasi',
        ]);

        $ptNusantara = User::create([
            'name' => 'PT Nusantara Cloud Nusantara',
            'email' => 'recruitment@nusantaracloud.com',
            'password' => Hash::make('password'),
            'role' => 'perusahaan',
            'is_active' => true,
        ]);

        $perusahaan3 = Perusahaan::create([
            'user_id' => $ptNusantara->id,
            'nama_perusahaan' => 'PT Nusantara Cloud Nusantara',
            'slug' => Str::slug('PT Nusantara Cloud Nusantara'),
            'bidang_industri' => 'Cloud Computing & Infrastructure Architecture',
            'website' => 'https://nusantaracloud.com',
            'email_hrd' => 'recruitment@nusantaracloud.com',
            'no_telp' => '081260003333',
            'alamat' => 'Sudirman Central Business District (SCBD) & Branch Office Medan, Jl. Adam Malik No. 8',
            'kota' => 'Kota Medan',
            'deskripsi' => 'Penyedia infrastruktur komputasi awan dan keamanan siber skala nasional dengan komitmen memperluas pusat data dan talenta jaringan di Sumatera Utara.',
            'logo' => null,
            'status_verifikasi' => 'terverifikasi',
        ]);

        // Perusahaan Ke-4 (Pending, untuk demonstrasi verifikasi admin)
        $ptInovasi = User::create([
            'name' => 'PT Inovasi Siber Deli',
            'email' => 'kontak@inovasisiberdeli.id',
            'password' => Hash::make('password'),
            'role' => 'perusahaan',
            'is_active' => true,
        ]);

        Perusahaan::create([
            'user_id' => $ptInovasi->id,
            'nama_perusahaan' => 'PT Inovasi Siber Deli',
            'slug' => Str::slug('PT Inovasi Siber Deli'),
            'bidang_industri' => 'Cybersecurity & Managed Network',
            'website' => 'https://inovasisiberdeli.id',
            'email_hrd' => 'kontak@inovasisiberdeli.id',
            'no_telp' => '081260004444',
            'alamat' => 'Jl. Raden Saleh No. 3, Kesawan, Kec. Medan Barat',
            'kota' => 'Kota Medan',
            'deskripsi' => 'Perusahaan startup keamanan digital lokal yang sedang mengajukan kemitraan rekrutmen alumni D3 TI USU.',
            'logo' => null,
            'status_verifikasi' => 'pending',
        ]);

        // 3. Empat Akun Pelamar (Mahasiswa / Alumni D3 TI USU)
        $userPelamar1 = User::create([
            'name' => 'Ahmad Reza Pratama',
            'email' => 'pelamar@mahasiswa.usu.ac.id',
            'password' => Hash::make('password'),
            'role' => 'pelamar',
            'is_active' => true,
        ]);

        $pelamar1 = Pelamar::create([
            'user_id' => $userPelamar1->id,
            'nim' => '230501001',
            'angkatan' => '2023',
            'ipk' => 3.85,
            'no_telp' => '082161234001',
            'alamat' => 'Jl. Sei Batang Hari No. 18, Babura Sunggal, Kota Medan',
            'headline' => 'Full-Stack Web & Mobile Developer',
            'ringkasan_profil' => 'Lulusan D3 Teknik Informatika USU dengan dedikasi tinggi dalam pengembangan solusi berbasis web dan mobile. Terbiasa membangun arsitektur backend scalable dengan Laravel, mobile apps dengan Flutter, serta terbiasa bekerja dengan metodologi Agile dan kolaborasi tim via Git.',
            'keahlian' => 'Laravel, Flutter, MySQL, Tailwind CSS, RESTful API, Git, Docker, PHP, Dart',
            'link_github' => 'https://github.com/rezaaplvv',
            'link_linkedin' => 'https://linkedin.com/in/reza-pratama-usu',
            'link_portofolio_web' => 'https://rezapratama.dev',
            'file_cv' => $dummyCvPath,
        ]);

        PortofolioProyek::create([
            'pelamar_id' => $pelamar1->id,
            'judul_proyek' => 'Sistem Informasi Rekam Medis Klinik Terpadu',
            'kategori' => 'Web Application',
            'tech_stack' => 'Laravel 11, Tailwind CSS, MySQL, Alpine.js',
            'deskripsi' => 'Aplikasi web manajemen data rekam medis pasien klinik dengan fitur pencatatan riwayat diagnosis, antrean digital realtime, serta pelaporan otomatis format PDF.',
            'link_github' => 'https://github.com/rezaaplvv/rekam-medis-klinik',
            'link_demo' => 'https://rekammedis-demo.usu.ac.id',
        ]);

        PortofolioProyek::create([
            'pelamar_id' => $pelamar1->id,
            'judul_proyek' => 'USU Mobile Kampus Pintar',
            'kategori' => 'Mobile Application',
            'tech_stack' => 'Flutter, Dart, Firebase, REST API',
            'deskripsi' => 'Aplikasi mobile penunjang perkuliahan mahasiswa untuk melihat jadwal kuliah, notifikasi pengumuman fakultas vokasi, dan presensi berbasis GPS koordinat.',
            'link_github' => 'https://github.com/rezaaplvv/usu-mobile-campus',
            'link_demo' => 'https://play.google.com/store/apps/details?id=id.ac.usu.vokasi',
        ]);

        PortofolioProyek::create([
            'pelamar_id' => $pelamar1->id,
            'judul_proyek' => 'Monitoring Trafik Jaringan Lab Vokasi',
            'kategori' => 'Networking & IoT',
            'tech_stack' => 'Python, Flask, SNMP, Chart.js, Tailwind CSS',
            'deskripsi' => 'Dashboard monitoring utilisasi bandwidth dan status up/down switch serta access point pada Laboratorium Komputer Fakultas Vokasi USU.',
            'link_github' => 'https://github.com/rezaaplvv/network-lab-monitor',
            'link_demo' => null,
        ]);

        // Pelamar 2: Siti Rahma Harahap
        $userPelamar2 = User::create([
            'name' => 'Siti Rahma Harahap',
            'email' => 'siti.rahma@mahasiswa.usu.ac.id',
            'password' => Hash::make('password'),
            'role' => 'pelamar',
            'is_active' => true,
        ]);

        $pelamar2 = Pelamar::create([
            'user_id' => $userPelamar2->id,
            'nim' => '230501015',
            'angkatan' => '2023',
            'ipk' => 3.90,
            'no_telp' => '082161234002',
            'alamat' => 'Jl. Jamin Ginting KM 8, Padang Bulan, Kota Medan',
            'headline' => 'Frontend Engineer & UI/UX Specialist',
            'ringkasan_profil' => 'Lulusan berprestasi D3 TI USU yang fokus pada kenyamanan antarmuka pengguna, accessibility standar WCAG, serta interaktivitas web modern berbasis komponen responsif.',
            'keahlian' => 'Figma, Tailwind CSS, Vue.js, Alpine.js, JavaScript, HTML5, User Research',
            'link_github' => 'https://github.com/sitirahma-usu',
            'link_linkedin' => 'https://linkedin.com/in/sitirahma-harahap',
            'link_portofolio_web' => 'https://sitirahma.design',
            'file_cv' => $dummyCvPath,
        ]);

        PortofolioProyek::create([
            'pelamar_id' => $pelamar2->id,
            'judul_proyek' => 'Redesign Portal Akademik Fakultas Vokasi',
            'kategori' => 'UI/UX Design',
            'tech_stack' => 'Figma, Design System, Usability Testing',
            'deskripsi' => 'Riset mendalam dan redesain sistem informasi akademik mahasiswa dengan pengujian usability score mencapai 89 (kategori Excellent).',
            'link_github' => 'https://github.com/sitirahma-usu/vokasi-ui-case-study',
            'link_demo' => 'https://www.figma.com/@sitirahma/vokasi-portal',
        ]);

        PortofolioProyek::create([
            'pelamar_id' => $pelamar2->id,
            'judul_proyek' => 'E-Commerce Wastra Tenun Toba',
            'kategori' => 'Web Application',
            'tech_stack' => 'Vue.js, Tailwind CSS, Pinia, REST API',
            'deskripsi' => 'Platform katalog interaktif produk kerajinan kain ulos dan tenun tradisional Sumatera Utara untuk UMKM mitra binaan daerah.',
            'link_github' => 'https://github.com/sitirahma-usu/toba-artisan-store',
            'link_demo' => 'https://tobawastra.example.com',
        ]);

        // Pelamar 3: Dimas Aditya Nugraha
        $userPelamar3 = User::create([
            'name' => 'Dimas Aditya Nugraha',
            'email' => 'dimas.aditya@mahasiswa.usu.ac.id',
            'password' => Hash::make('password'),
            'role' => 'pelamar',
            'is_active' => true,
        ]);

        $pelamar3 = Pelamar::create([
            'user_id' => $userPelamar3->id,
            'nim' => '220501040',
            'angkatan' => '2022',
            'ipk' => 3.72,
            'no_telp' => '082161234003',
            'alamat' => 'Jl. Ringroad No. 99, Tanjung Sari, Kota Medan',
            'headline' => 'Backend & Cloud Infrastructure Engineer',
            'ringkasan_profil' => 'Pengembang backend dengan pemahaman kuat pada optimasi query database, containerization Docker, arsitektur microservices, dan implementasi CI/CD pipeline.',
            'keahlian' => 'PHP, Laravel, PostgreSQL, Docker, Redis, Linux Server, Git, REST API',
            'link_github' => 'https://github.com/dimasaditya-usu',
            'link_linkedin' => 'https://linkedin.com/in/dimasaditya-n',
            'link_portofolio_web' => null,
            'file_cv' => $dummyCvPath,
        ]);

        PortofolioProyek::create([
            'pelamar_id' => $pelamar3->id,
            'judul_proyek' => 'High-Throughput Payment Gateway Simulator',
            'kategori' => 'Web Application',
            'tech_stack' => 'Laravel, Redis, PostgreSQL, Docker',
            'deskripsi' => 'Simulator proses transaksi perbankan dengan antrean asynchronous menggunakan Redis queue dan isolasi container Docker.',
            'link_github' => 'https://github.com/dimasaditya-usu/payment-sim',
            'link_demo' => null,
        ]);

        PortofolioProyek::create([
            'pelamar_id' => $pelamar3->id,
            'judul_proyek' => 'API Gateway Manajemen Inventaris Lab Terdistribusi',
            'kategori' => 'Web Application',
            'tech_stack' => 'PHP, Lumen, JWT Authentication, MySQL',
            'deskripsi' => 'Layanan backend RESTful API terpusat untuk sinkronisasi peminjaman alat lab antar jurusan di lingkungan kampus.',
            'link_github' => 'https://github.com/dimasaditya-usu/inventory-api',
            'link_demo' => null,
        ]);

        // Pelamar 4: Fani Anggraeni Siregar
        $userPelamar4 = User::create([
            'name' => 'Fani Anggraeni Siregar',
            'email' => 'fani.anggraeni@mahasiswa.usu.ac.id',
            'password' => Hash::make('password'),
            'role' => 'pelamar',
            'is_active' => true,
        ]);

        $pelamar4 = Pelamar::create([
            'user_id' => $userPelamar4->id,
            'nim' => '230501028',
            'angkatan' => '2023',
            'ipk' => 3.80,
            'no_telp' => '082161234004',
            'alamat' => 'Jl. Gatot Subroto No. 56, Sei Sikambing, Kota Medan',
            'headline' => 'Data Analyst & Machine Learning Practitioner',
            'ringkasan_profil' => 'Lulusan D3 TI USU yang mahir dalam ekstraksi data, pembersihan dataset besar, analisis statistik prediktif, serta visualisasi dashboard bisnis interaktif.',
            'keahlian' => 'Python, MySQL, Tableau, Pandas, Scikit-Learn, Power BI, Tailwind CSS',
            'link_github' => 'https://github.com/fanianggraeni-usu',
            'link_linkedin' => 'https://linkedin.com/in/fani-anggraeni-siregar',
            'link_portofolio_web' => null,
            'file_cv' => $dummyCvPath,
        ]);

        PortofolioProyek::create([
            'pelamar_id' => $pelamar4->id,
            'judul_proyek' => 'Sistem Prediksi Kelulusan Mahasiswa Berbasis AI',
            'kategori' => 'Data & AI',
            'tech_stack' => 'Python, Scikit-Learn, Pandas, Streamlit',
            'deskripsi' => 'Model klasifikasi machine learning berbasis Random Forest untuk mengidentifikasi indikator kelulusan tepat waktu mahasiswa vokasi.',
            'link_github' => 'https://github.com/fanianggraeni-usu/student-graduation-ai',
            'link_demo' => 'https://graduation-ai.streamlit.app',
        ]);

        PortofolioProyek::create([
            'pelamar_id' => $pelamar4->id,
            'judul_proyek' => 'Sentimen Analisis Aspirasi Publik Kota Medan',
            'kategori' => 'Data & AI',
            'tech_stack' => 'Python, NLTK, FastApi, Chart.js',
            'deskripsi' => 'Analisis komparatif opini masyarakat pada kanal media sosial terkait transportasi publik dan infrastruktur perkotaan.',
            'link_github' => 'https://github.com/fanianggraeni-usu/medan-sentiment-analysis',
            'link_demo' => null,
        ]);

        // 4. Enam Lowongan Kerja Aktif
        $lowongan1 = Lowongan::create([
            'perusahaan_id' => $perusahaan1->id,
            'judul_lowongan' => 'Full-Stack Web Developer (Laravel)',
            'slug' => Str::slug('Full-Stack Web Developer Laravel PT Medan Solusi Teknologi').'-'.Str::random(4),
            'kategori_bidang' => 'Web Development',
            'tipe_pekerjaan' => 'Full-time',
            'sistem_kerja' => 'Hybrid',
            'lokasi' => 'Medan, Sumatera Utara',
            'rentang_gaji' => 'Rp 5.000.000 - Rp 7.500.000',
            'deskripsi_pekerjaan' => "Kami mencari lulusan D3 Teknik Informatika yang bersemangat untuk bergabung dengan tim core engineering kami. Tanggung jawab meliputi:\n- Mengembangkan fitur baru aplikasi web berbasis Laravel dan Tailwind CSS.\n- Merancang struktur skema database relasional MySQL dan optimasi query.\n- Melakukan integrasi REST API dengan sistem pihak ketiga.\n- Berkolaborasi secara teratur dengan tim UI/UX dan project manager.",
            'kualifikasi' => "1. Lulusan D3 Teknik Informatika USU atau setara.\n2. Menguasai PHP 8+, Framework Laravel, dan JavaScript modern.\n3. Terbiasa dengan Tailwind CSS dan pemodelan database MySQL.\n4. Memiliki portofolio proyek web yang aktif dan dapat didemokan.\n5. Nilai tambah jika memahami containerization (Docker) dan Git version control.",
            'batas_lamaran' => now()->addDays(30)->toDateString(),
            'status_aktif' => true,
        ]);

        $lowongan2 = Lowongan::create([
            'perusahaan_id' => $perusahaan1->id,
            'judul_lowongan' => 'Mobile Application Developer (Flutter)',
            'slug' => Str::slug('Mobile Application Developer Flutter PT Medan Solusi Teknologi').'-'.Str::random(4),
            'kategori_bidang' => 'Mobile Development',
            'tipe_pekerjaan' => 'Full-time',
            'sistem_kerja' => 'On-site',
            'lokasi' => 'Medan Baru, Kota Medan',
            'rentang_gaji' => 'Rp 4.500.000 - Rp 6.500.000',
            'deskripsi_pekerjaan' => 'Membangun aplikasi mobile multiplatform (Android & iOS) yang responsif dan berkinerja tinggi untuk kebutuhan klien perbankan daerah. Mengimplementasikan state management modern seperti Bloc atau Riverpod.',
            'kualifikasi' => "1. Lulusan D3 Teknik Informatika.\n2. Mahir menggunakan framework Flutter dan bahasa pemrograman Dart.\n3. Paham integrasi RESTful API dan state management.\n4. Memiliki proyek mobile yang pernah diuji coba atau dirilis ke Play Store/APK.",
            'batas_lamaran' => now()->addDays(25)->toDateString(),
            'status_aktif' => true,
        ]);

        $lowongan3 = Lowongan::create([
            'perusahaan_id' => $perusahaan2->id,
            'judul_lowongan' => 'UI/UX Designer',
            'slug' => Str::slug('UI UX Designer CV Sumatera Digital Kreatif').'-'.Str::random(4),
            'kategori_bidang' => 'UI/UX Design',
            'tipe_pekerjaan' => 'Internship',
            'sistem_kerja' => 'Remote',
            'lokasi' => 'Remote / Fleksibel',
            'rentang_gaji' => 'Rp 2.500.000 - Rp 3.500.000',
            'deskripsi_pekerjaan' => 'Membantu tim kreatif dalam merancang user journey, wireframing, high-fidelity mockup, dan interactive prototype untuk klien startup digital regional.',
            'kualifikasi' => "1. Lulusan D3 TI dengan minat kuat di bidang desain interaksi antarmuka.\n2. Menguasai software Figma, FigJam, dan pemahaman dasar HTML/Tailwind.\n3. Memiliki tautan studi kasus portofolio desain UI/UX yang dapat dipresentasikan.\n4. Komunikatif dan terbuka terhadap masukan revisi pengguna.",
            'batas_lamaran' => now()->addDays(20)->toDateString(),
            'status_aktif' => true,
        ]);

        $lowongan4 = Lowongan::create([
            'perusahaan_id' => $perusahaan2->id,
            'judul_lowongan' => 'IT Support & Database Administrator',
            'slug' => Str::slug('IT Support Database Administrator CV Sumatera Digital Kreatif').'-'.Str::random(4),
            'kategori_bidang' => 'Database & Support',
            'tipe_pekerjaan' => 'Full-time',
            'sistem_kerja' => 'On-site',
            'lokasi' => 'Medan Selayang, Kota Medan',
            'rentang_gaji' => 'Rp 4.000.000 - Rp 5.500.000',
            'deskripsi_pekerjaan' => 'Bertanggung jawab atas kelancaran infrastruktur TI internal kantor, manajemen backup berkala database MySQL perusahaan, serta troubleshooting perangkat staf.',
            'kualifikasi' => "1. Lulusan D3 Teknik Informatika USU.\n2. Memahami dasar instalasi server lokal, jaringan LAN/WLAN, dan query SQL.\n3. Disiplin, proaktif, dan memiliki kemampuan problem-solving yang cepat.",
            'batas_lamaran' => now()->addDays(15)->toDateString(),
            'status_aktif' => true,
        ]);

        $lowongan5 = Lowongan::create([
            'perusahaan_id' => $perusahaan3->id,
            'judul_lowongan' => 'Junior Network Engineer',
            'slug' => Str::slug('Junior Network Engineer PT Nusantara Cloud Nusantara').'-'.Str::random(4),
            'kategori_bidang' => 'Networking & Infrastructure',
            'tipe_pekerjaan' => 'Contract',
            'sistem_kerja' => 'Hybrid',
            'lokasi' => 'Medan & Sekitarnya',
            'rentang_gaji' => 'Rp 4.500.000 - Rp 6.000.000',
            'deskripsi_pekerjaan' => 'Melakukan konfigurasi router Mikrotik, Cisco switch, pemantauan status bandwidth, serta penanganan kendala konektivitas data center cabang Sumatera.',
            'kualifikasi' => "1. Lulusan D3 Teknik Informatika atau Teknik Komputer.\n2. Memiliki pemahaman TCP/IP, subnetting, VLAN, routing static/OSPF.\n3. Nilai tambah jika memiliki sertifikasi MTCNA atau CCNA.",
            'batas_lamaran' => now()->addDays(35)->toDateString(),
            'status_aktif' => true,
        ]);

        $lowongan6 = Lowongan::create([
            'perusahaan_id' => $perusahaan3->id,
            'judul_lowongan' => 'Backend Developer (API & Cloud)',
            'slug' => Str::slug('Backend Developer API Cloud PT Nusantara Cloud Nusantara').'-'.Str::random(4),
            'kategori_bidang' => 'Cloud & Backend',
            'tipe_pekerjaan' => 'Full-time',
            'sistem_kerja' => 'Remote',
            'lokasi' => 'Remote Indonesia',
            'rentang_gaji' => 'Rp 6.000.000 - Rp 8.500.000',
            'deskripsi_pekerjaan' => 'Mengembangkan microservice API berskala besar yang terhubung dengan layanan cloud orchestration. Menulis unit testing dan dokumentasi OpenAPI.',
            'kualifikasi' => "1. Lulusan D3 TI dengan pemahaman konsep software engineering yang kuat.\n2. Menguasai PHP/Laravel atau NodeJS/Go.\n3. Terbiasa dengan arsitektur REST, Docker, dan Redis caching.\n4. Siap bekerja secara remote dengan koordinasi asinkronus yang rapi.",
            'batas_lamaran' => now()->addDays(40)->toDateString(),
            'status_aktif' => true,
        ]);

        // 5. Delapan Data Transaksi Lamaran (Dengan variasi status)
        // Lamaran 1: Ahmad Reza -> Full-Stack Web Developer (PT Medan) [INTERVIEW]
        Lamaran::create([
            'kode_lamaran' => 'REC-2026-A101',
            'lowongan_id' => $lowongan1->id,
            'pelamar_id' => $pelamar1->id,
            'cv_snapshot' => $dummyCvPath,
            'github_snapshot' => $pelamar1->link_github,
            'surat_lamaran' => 'Dengan hormat, saya mengajukan lamaran sebagai Full-Stack Web Developer. Pengalaman saya membangun aplikasi web rekam medis dengan Laravel dan Tailwind sangat relevan dengan kebutuhan PT Medan Solusi Teknologi.',
            'status_lamaran' => 'interview',
            'jadwal_interview' => now()->addDays(3)->setTime(10, 0),
            'metode_interview' => 'Online',
            'link_atau_lokasi_interview' => 'https://meet.google.com/rec-usu-tech',
            'catatan_hrd' => 'Profil dan portofolio sangat menarik. Sesi interview teknis online akan diadakan via Google Meet. Harap siapkan laptop dan demonstrasi proyek.',
        ]);

        // Lamaran 2: Ahmad Reza -> Mobile Application Developer (PT Medan) [DITERIMA]
        Lamaran::create([
            'kode_lamaran' => 'REC-2026-A102',
            'lowongan_id' => $lowongan2->id,
            'pelamar_id' => $pelamar1->id,
            'cv_snapshot' => $dummyCvPath,
            'github_snapshot' => $pelamar1->link_github,
            'surat_lamaran' => 'Saya tertarik mengisi posisi Mobile Developer berbekal kemampuan Flutter yang telah saya buktikan pada aplikasi kampus pintar USU.',
            'status_lamaran' => 'diterima',
            'jadwal_interview' => now()->subDays(5)->setTime(14, 0),
            'metode_interview' => 'Online',
            'link_atau_lokasi_interview' => 'https://meet.google.com/rec-usu-mob',
            'catatan_hrd' => 'Selamat! Anda dinyatakan lolos seleksi akhir dan diterima bergabung. Tim HRD akan menghubungi untuk proses penandatanganan kontrak kerja.',
        ]);

        // Lamaran 3: Siti Rahma -> UI/UX Designer (CV Sumatera) [INTERVIEW]
        Lamaran::create([
            'kode_lamaran' => 'REC-2026-B201',
            'lowongan_id' => $lowongan3->id,
            'pelamar_id' => $pelamar2->id,
            'cv_snapshot' => $dummyCvPath,
            'github_snapshot' => $pelamar2->link_github,
            'surat_lamaran' => 'Portofolio UI/UX redesign portal akademik saya lampirkan sebagai bukti keahlian saya dalam menghasilkan antarmuka fungsional dan estetis.',
            'status_lamaran' => 'interview',
            'jadwal_interview' => now()->addDays(4)->setTime(14, 0),
            'metode_interview' => 'Online',
            'link_atau_lokasi_interview' => 'https://meet.google.com/sum-des-2026',
            'catatan_hrd' => 'Kandidat diundang ke sesi design presentation interview. Mohon menyiapkan file Figma untuk pembahasan case study.',
        ]);

        // Lamaran 4: Siti Rahma -> Full-Stack Web Developer (PT Medan) [DILIHAT]
        Lamaran::create([
            'kode_lamaran' => 'REC-2026-B202',
            'lowongan_id' => $lowongan1->id,
            'pelamar_id' => $pelamar2->id,
            'cv_snapshot' => $dummyCvPath,
            'github_snapshot' => $pelamar2->link_github,
            'surat_lamaran' => 'Saya mengajukan diri untuk berkontribusi pada sisi frontend dan interaksi web aplikasi di PT Medan Solusi Teknologi.',
            'status_lamaran' => 'dilihat',
            'jadwal_interview' => null,
            'metode_interview' => null,
            'link_atau_lokasi_interview' => null,
            'catatan_hrd' => 'Berkas dan portofolio kandidat sedang dalam proses penelaahan oleh tim Lead Engineer.',
        ]);

        // Lamaran 5: Dimas Aditya -> Backend Developer (PT Nusantara) [DILAMAR]
        Lamaran::create([
            'kode_lamaran' => 'REC-2026-C301',
            'lowongan_id' => $lowongan6->id,
            'pelamar_id' => $pelamar3->id,
            'cv_snapshot' => $dummyCvPath,
            'github_snapshot' => $pelamar3->link_github,
            'surat_lamaran' => 'Fokus saya pada arsitektur API berskala besar dan Docker menjadikan posisi Backend Developer ini sangat sesuai dengan keahlian teknis saya.',
            'status_lamaran' => 'dilamar',
            'jadwal_interview' => null,
            'metode_interview' => null,
            'link_atau_lokasi_interview' => null,
            'catatan_hrd' => 'Lamaran telah masuk ke sistem dan menunggu antrean review berkas.',
        ]);

        // Lamaran 6: Dimas Aditya -> Junior Network Engineer (PT Nusantara) [DITERIMA]
        Lamaran::create([
            'kode_lamaran' => 'REC-2026-C302',
            'lowongan_id' => $lowongan5->id,
            'pelamar_id' => $pelamar3->id,
            'cv_snapshot' => $dummyCvPath,
            'github_snapshot' => $pelamar3->link_github,
            'surat_lamaran' => 'Dengan sertifikasi jaringan dan pemahaman protokol routing, saya siap berkontribusi menjaga uptime infrastruktur data center.',
            'status_lamaran' => 'diterima',
            'jadwal_interview' => now()->subDays(3)->setTime(11, 0),
            'metode_interview' => 'Offline',
            'link_atau_lokasi_interview' => 'Kantor Cabang Medan, Jl. Adam Malik No. 8, Lantai 3',
            'catatan_hrd' => 'Kandidat dinilai sangat kompeten pada ujian praktek jaringan fisik dan routing. Selamat bergabung.',
        ]);

        // Lamaran 7: Fani Anggraeni -> IT Support & Database Administrator (CV Sumatera) [DITOLAK]
        Lamaran::create([
            'kode_lamaran' => 'REC-2026-D401',
            'lowongan_id' => $lowongan4->id,
            'pelamar_id' => $pelamar4->id,
            'cv_snapshot' => $dummyCvPath,
            'github_snapshot' => $pelamar4->link_github,
            'surat_lamaran' => 'Saya tertarik menerapkan pemahaman struktur data dan analisis query SQL untuk posisi IT Support & Database Administrator.',
            'status_lamaran' => 'ditolak',
            'jadwal_interview' => null,
            'metode_interview' => null,
            'link_atau_lokasi_interview' => null,
            'catatan_hrd' => 'Profil kandidat lebih condong ke bidang Data Science dan Analisis Bisnis dibanding operasional infrastruktur hardware. Data kandidat disimpan untuk peluang posisi lain yang relevan.',
        ]);

        // Lamaran 8: Fani Anggraeni -> Full-Stack Web Developer (PT Medan) [DILAMAR]
        Lamaran::create([
            'kode_lamaran' => 'REC-2026-D402',
            'lowongan_id' => $lowongan1->id,
            'pelamar_id' => $pelamar4->id,
            'cv_snapshot' => $dummyCvPath,
            'github_snapshot' => $pelamar4->link_github,
            'surat_lamaran' => 'Saya mengajukan diri untuk posisi pengembangan web dengan penekanan pada integrasi data dashboard dan visualisasi visual.',
            'status_lamaran' => 'dilamar',
            'jadwal_interview' => null,
            'metode_interview' => null,
            'link_atau_lokasi_interview' => null,
            'catatan_hrd' => null,
        ]);
    }
}
