<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Undangan Interview - {{ $lamaran->kode_lamaran }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #1e293b;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 15px;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
            color: #0f172a;
        }
        .header h2 {
            font-size: 13px;
            margin: 3px 0;
            font-weight: normal;
            color: #334155;
        }
        .header p {
            font-size: 10px;
            margin: 0;
            color: #64748b;
        }
        .title-box {
            text-align: center;
            margin: 20px 0;
            padding: 8px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
        }
        .title-box h3 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
            color: #1e3a8a;
        }
        .title-box span {
            font-size: 11px;
            font-family: monospace;
            font-weight: bold;
            color: #475569;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        table.info-table td {
            padding: 5px 8px;
            vertical-align: top;
        }
        table.info-table td.label {
            width: 28%;
            font-weight: bold;
            color: #334155;
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
        }
        table.info-table td.value {
            border: 1px solid #e2e8f0;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin: 15px 0 6px 0;
            color: #1e293b;
            border-left: 3px solid #2563eb;
            padding-left: 8px;
        }
        .notes-box {
            background-color: #f8fafc;
            border: 1px dashed #94a3b8;
            padding: 10px;
            font-size: 11px;
            margin-top: 15px;
        }
        .footer {
            margin-top: 35px;
            width: 100%;
        }
        .footer td {
            vertical-align: top;
            font-size: 11px;
        }
        .barcode-box {
            border: 1px solid #cbd5e1;
            padding: 8px;
            display: inline-block;
            font-family: monospace;
            background-color: #f8fafc;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <!-- Header Letterhead USU -->
    <div class="header">
        <h1>UNIVERSITAS SUMATERA UTARA</h1>
        <h2>FAKULTAS VOKASI &bull; PROGRAM STUDI D3 TEKNIK INFORMATIKA</h2>
        <p>Sistem E-Recruitment & E-Portofolio Talenta Kampus Pintar | Jl. Alumni No. 1 Medan 20155</p>
    </div>

    <!-- Title Box -->
    <div class="title-box">
        <h3>SURAT BUKTI PANGGILAN WAWANCARA KERJA (E-INTERVIEW)</h3>
        <span>Nomor Registrasi: {{ $lamaran->kode_lamaran }}</span>
    </div>

    <p style="margin-bottom: 12px;">
        Berdasarkan hasil penelaahan berkas portofolio dan kualifikasi oleh Tim Rekrutmen Perusahaan Mitra, berikut disampaikan undangan resmi pelaksanaan sesi wawancara:
    </p>

    <!-- Applicant Identity Table -->
    <div class="section-title">A. IDENTITAS KANDIDAT / MAHASISWA</div>
    <table class="info-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="value"><strong>{{ $lamaran->pelamar->user->name }}</strong></td>
        </tr>
        <tr>
            <td class="label">NIM / Angkatan</td>
            <td class="value">{{ $lamaran->pelamar->nim }} &bull; Angkatan {{ $lamaran->pelamar->angkatan }} (IPK: {{ number_format($lamaran->pelamar->ipk, 2) }})</td>
        </tr>
        <tr>
            <td class="label">Program Studi</td>
            <td class="value">D3 Teknik Informatika, Fakultas Vokasi USU</td>
        </tr>
        <tr>
            <td class="label">Kontak / Email</td>
            <td class="value">{{ $lamaran->pelamar->no_telp }} &bull; {{ $lamaran->pelamar->user->email }}</td>
        </tr>
        <tr>
            <td class="label">Tautan Repositori GitHub</td>
            <td class="value">{{ $lamaran->github_snapshot }}</td>
        </tr>
    </table>

    <!-- Position & Company Table -->
    <div class="section-title">B. INFORMASI POSISI & INSTANSI MITRA</div>
    <table class="info-table">
        <tr>
            <td class="label">Posisi Lowongan</td>
            <td class="value"><strong>{{ $lamaran->lowongan->judul_lowongan }}</strong></td>
        </tr>
        <tr>
            <td class="label">Perusahaan Penyelenggara</td>
            <td class="value">{{ $lamaran->lowongan->perusahaan->nama_perusahaan }}</td>
        </tr>
        <tr>
            <td class="label">Bidang Industri</td>
            <td class="value">{{ $lamaran->lowongan->perusahaan->bidang_industri }}</td>
        </tr>
        <tr>
            <td class="label">Lokasi Penempatan</td>
            <td class="value">{{ $lamaran->lowongan->lokasi }} ({{ $lamaran->lowongan->sistem_kerja }})</td>
        </tr>
    </table>

    <!-- Interview Schedule Table -->
    <div class="section-title">C. JADWAL & TEKNIS PELAKSANAAN INTERVIEW</div>
    <table class="info-table">
        <tr>
            <td class="label">Hari & Tanggal</td>
            <td class="value"><strong>{{ $lamaran->jadwal_interview?->isoFormat('dddd, D MMMM Y') ?? 'Konfirmasi Menyusul' }}</strong></td>
        </tr>
        <tr>
            <td class="label">Waktu / Jam</td>
            <td class="value"><strong>{{ $lamaran->jadwal_interview?->format('H:i') ?? '--:--' }} WIB</strong></td>
        </tr>
        <tr>
            <td class="label">Metode Pelaksanaan</td>
            <td class="value">{{ $lamaran->metode_interview ?? 'Online (Daring)' }}</td>
        </tr>
        <tr>
            <td class="label">Lokasi / Tautan Meeting</td>
            <td class="value">{{ $lamaran->link_atau_lokasi_interview ?? 'Tautan akan diperbarui oleh HRD' }}</td>
        </tr>
    </table>

    @if($lamaran->catatan_hrd)
        <div class="notes-box">
            <strong>Catatan / Ketentuan dari Tim HRD:</strong><br>
            {{ $lamaran->catatan_hrd }}
        </div>
    @endif

    <!-- Signatures & Verification -->
    <table class="footer">
        <tr>
            <td style="width: 50%;">
                <div class="barcode-box">
                    <strong>KODE VERIFIKASI RESMI</strong><br>
                    {{ $lamaran->kode_lamaran }}<br>
                    <span>Dicetak: {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
                </div>
                <p style="font-size: 9px; color: #64748b; margin-top: 5px;">
                    Dokumen ini sah dikeluarkan melalui Sistem E-Recruitment & Portofolio D3 TI USU tanpa tanda tangan basah.
                </p>
            </td>
            <td style="width: 50%; text-align: right;">
                <p style="margin: 0;">Medan, {{ now()->isoFormat('D MMMM Y') }}</p>
                <p style="margin: 3px 0 45px 0;"><strong>Tim Rekrutmen Mitra Industri</strong></p>
                <p style="margin: 0; font-weight: bold; text-decoration: underline;">
                    {{ $lamaran->lowongan->perusahaan->nama_perusahaan }}
                </p>
                <p style="margin: 0; font-size: 10px; color: #64748b;">Divisi Human Resources & Talent Acquisition</p>
            </td>
        </tr>
    </table>

</body>
</html>
