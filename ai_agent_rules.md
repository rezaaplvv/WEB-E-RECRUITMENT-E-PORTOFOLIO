# Antigravity AI Agent Rules - E-Recruitment & E-Portofolio Project

## 1. Project Context

Kamu adalah AI Developer Senior yang bertugas membangun aplikasi web "E-Recruitment & E-Portofolio (Job Portal Khusus Lulusan TI)" menggunakan **Laravel (PHP)** dan **Tailwind CSS**.

## 2. Core Directives (ABSOLUTE RULES)

* **NO EMOJIS:** Dilarang keras menggunakan emoji di seluruh antarmuka web, kode, maupun pesan *commit*.

* **USE ICONS:** Gunakan library ikon SVG (seperti Heroicons, Lucide, atau FontAwesome) untuk elemen visual (contoh: ikon *dashboard*, tombol aksi, penanda status).

* **MINIMALIST & PROFESSIONAL DESIGN:** Desain UI/UX harus terlihat elegan, bersih, minimalis, dan profesional (khas portal korporat/LinkedIn). Gunakan palet warna netral (putih, abu-abu) dengan satu warna primer (misalnya biru korporat atau hitam) untuk aksen dan tombol. Perhatikan *whitespace* (margin/padding).

* **CONTINUOUS GITHUB SYNC:** Setiap kali ada perubahan kode yang berfungsi secara logis (selesai membuat satu fitur, memperbaiki *bug*, atau memperbarui tampilan), **WAJIB** langsung melakukan  git add. ,`git commit` dan `git push` ke *repository* sekaligus agar tidak 3x klik submit

## 3. Git Workflow & Commit Standards

* Selalu periksa `git status` sebelum melakukan *commit*.

* Gunakan format *Conventional Commits*:

  * `feat:` untuk fitur baru (contoh: `feat: add login multi-role`)

  * `fix:` untuk perbaikan bug (contoh: `fix: upload cv pdf error`)

  * `ui:` untuk perubahan tampilan Tailwind (contoh: `ui: redesign landing page cards`)

  * `chore:` untuk urusan konfigurasi (contoh: `chore: setup laravel breeze`)

## 4. Backend & Laravel Conventions

* **Database Naming:** Gunakan *snake_case* dan bahasa Indonesia untuk nama tabel/kolom sesuai rancangan (tabel: `users`, `perusahaan`, `pelamar`, `lowongan`, `lamaran`).

* **MVC Pattern:** Patuhi struktur MVC Laravel. Gunakan *Resource Controllers* untuk operasi CRUD.

* **Validation:** Selalu gunakan validasi untuk setiap input form.

* **File Uploads:** Pastikan *file* CV PDF dan Logo Perusahaan disimpan di direktori `storage/app/public` dan jalankan `php artisan storage:link`. Validasi ekstensi (hanya .pdf untuk CV, .jpg/.png untuk logo) dan ukuran maksimal file (misal 2MB).

* **Middleware & Auth:** Terapkan pembatasan akses (*Middleware*) yang ketat berdasarkan Role (Admin, Perusahaan, Pelamar).

## 5. Frontend & Tailwind Guidelines

* **Blade Components:** Ekstrak elemen UI yang sering diulang (seperti *buttons*, *cards*, *modals*, *form inputs*) menjadi Laravel Blade Components (`resources/views/components`).

* **Responsiveness:** Pastikan setiap halaman responsif (berfungsi baik di ukuran layar *mobile*, *tablet*, dan *desktop*) menggunakan utilitas bawaan Tailwind (`sm:`, `md:`, `lg:`).

* **Status Badges:** Gunakan *badge* warna-warni minimalis untuk menandakan status lamaran (misal: abu-abu untuk 'Dilamar', biru untuk 'Dilihat', kuning untuk 'Interview', hijau untuk 'Diterima', merah untuk 'Ditolak').

## 6. Execution Steps (For AI Agent)

Jika diminta untuk memulai pengembangan, ikuti urutan berikut:

1. Setup instalasi Laravel, Tailwind CSS, dan Git init. (Push)

2. Buat Migrations, Models, dan relasi Database. (Push)

3. Setup Authentication dan Middleware Multi-Role. (Push)

4. Buat halaman Landing Page dan layout Dashboard dasar. (Push)

5. Implementasi CRUD Lowongan & Profil Perusahaan/Pelamar. (Push)

6. Implementasi fitur transaksional: Apply Lamaran & Tracking Status. (Push)

7. Buat fitur Cetak Laporan PDF. (Push)