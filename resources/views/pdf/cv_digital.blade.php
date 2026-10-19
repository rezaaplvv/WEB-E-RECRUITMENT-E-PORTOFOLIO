<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CV Digital Mahasiswa - {{ $pelamar->user->name }}</title>
    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            line-height: 1.45;
            font-size: 11pt;
            margin: 0;
            padding: 0;
        }
        .kop-table {
            width: 100%;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .kop-text-main {
            font-size: 13pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .kop-text-sub {
            font-size: 11pt;
            font-weight: bold;
            color: #2563eb;
            margin: 2px 0;
        }
        .kop-text-desc {
            font-size: 8pt;
            color: #64748b;
            margin: 0;
        }
        .header-cv {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 14px 16px;
            margin-bottom: 18px;
        }
        .candidate-name {
            font-size: 16pt;
            font-weight: bold;
            color: #0f172a;
            margin: 0 0 4px 0;
        }
        .candidate-headline {
            font-size: 10pt;
            color: #2563eb;
            font-weight: bold;
            margin: 0 0 8px 0;
        }
        .info-table {
            width: 100%;
            font-size: 9pt;
            color: #334155;
        }
        .info-table td {
            padding: 2px 0;
            vertical-align: top;
        }
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 1.5px solid #cbd5e1;
            padding-bottom: 4px;
            margin-top: 16px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .summary-text {
            font-size: 9.5pt;
            color: #334155;
            text-align: justify;
            margin: 0 0 10px 0;
        }
        .badge-skill {
            display: inline-block;
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            border-radius: 3px;
            padding: 3px 6px;
            font-size: 8.5pt;
            font-weight: bold;
            margin-right: 4px;
            margin-bottom: 5px;
        }
        .project-card {
            border-left: 3px solid #2563eb;
            padding-left: 10px;
            margin-bottom: 12px;
        }
        .project-title {
            font-size: 10pt;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
        }
        .project-meta {
            font-size: 8.5pt;
            color: #64748b;
            margin: 2px 0 4px 0;
        }
        .project-desc {
            font-size: 9pt;
            color: #334155;
            margin: 0 0 4px 0;
        }
        .project-link {
            font-size: 8pt;
            color: #2563eb;
            text-decoration: none;
        }
        .footer-note {
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px dashed #cbd5e1;
            font-size: 8pt;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Kop Resmi Program Studi -->
    <table class="kop-table">
        <tr>
            <td style="width: 75%;">
                <div class="kop-text-main">Universitas Sumatera Utara</div>
                <div class="kop-text-sub">Fakultas Vokasi &bull; Program Studi D3 Teknik Informatika</div>
                <div class="kop-text-desc">Portal E-Recruitment & Showcase Portofolio Digital Mahasiswa &bull; Kampus Padang Bulan, Medan 20155</div>
            </td>
            <td style="width: 25%; text-align: right; vertical-align: middle;">
                <div style="display: inline-block; background-color: #0f172a; color: #ffffff; padding: 6px 10px; border-radius: 4px; font-size: 8pt; font-weight: bold; text-align: center;">
                    RESUME RESMI D3 TI
                </div>
            </td>
        </tr>
    </table>

    <!-- Profil Identitas Kandidat -->
    <div class="header-cv">
        <h1 class="candidate-name">{{ $pelamar->user->name }}</h1>
        <div class="candidate-headline">{{ $pelamar->headline ?? 'Lulusan D3 Teknik Informatika USU' }}</div>

        <table class="info-table">
            <tr>
                <td style="width: 15%; font-weight: bold;">NIM</td>
                <td style="width: 35%;">: {{ $pelamar->nim }}</td>
                <td style="width: 15%; font-weight: bold;">Email</td>
                <td style="width: 35%;">: {{ $pelamar->user->email }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Angkatan / IPK</td>
                <td style="color: #047857; font-weight: bold;">: {{ $pelamar->angkatan }} / {{ number_format($pelamar->ipk, 2) }} (Skala 4.00)</td>
                <td style="font-weight: bold;">No. Telepon</td>
                <td>: {{ $pelamar->no_telp }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">GitHub</td>
                <td>: {{ $pelamar->link_github ?? '-' }}</td>
                <td style="font-weight: bold;">Domisili</td>
                <td>: {{ $pelamar->alamat }}</td>
            </tr>
        </table>
    </div>

    <!-- Ringkasan Profesional -->
    <div class="section-title">Ringkasan Profil & Kompetensi</div>
    <p class="summary-text">
        {{ $pelamar->ringkasan_profil ?? 'Lulusan Program Studi D3 Teknik Informatika Fakultas Vokasi Universitas Sumatera Utara berintegritas tinggi dengan kompetensi teruji di bidang rekayasa perangkat lunak, sistem informasi, dan teknologi komputasi industri.' }}
    </p>

    <!-- Keahlian Teknis -->
    <div class="section-title">Keahlian Teknis & Tools</div>
    <div style="margin-bottom: 12px;">
        @foreach($pelamar->skills_array as $skill)
            <span class="badge-skill">{{ $skill }}</span>
        @endforeach
    </div>

    <!-- Portofolio Proyek Unggulan -->
    <div class="section-title">Showcase Karya & Portofolio Proyek</div>
    @forelse($pelamar->portofolio as $proyek)
        <div class="project-card">
            <div class="project-title">{{ $proyek->judul_proyek }}</div>
            <div class="project-meta">
                <strong>Kategori:</strong> {{ $proyek->kategori }} &bull; 
                <strong>Tech Stack:</strong> {{ $proyek->tech_stack }}
            </div>
            <div class="project-desc">{{ $proyek->deskripsi }}</div>
            <div>
                @if($proyek->link_github)
                    <span class="project-link">Repository: {{ $proyek->link_github }}</span>
                @endif
                @if($proyek->link_demo)
                    &bull; <span class="project-link">Demo: {{ $proyek->link_demo }}</span>
                @endif
            </div>
        </div>
    @empty
        <p style="font-size: 9pt; color: #64748b; font-style: italic;">Belum ada portofolio proyek yang ditambahkan.</p>
    @endforelse

    <!-- Footer Otentisitas -->
    <div class="footer-note">
        Dokumen ini diterbitkan secara otomatis melalui Sistem E-Recruitment & E-Portofolio Program Studi D3 Teknik Informatika, Fakultas Vokasi, Universitas Sumatera Utara pada {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB.
    </div>
</body>
</html>
