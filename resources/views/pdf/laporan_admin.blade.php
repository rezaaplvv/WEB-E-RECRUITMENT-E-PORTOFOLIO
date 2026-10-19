<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Eksekutif Prodi D3 Teknik Informatika USU</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #0f172a;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            color: #0f172a;
        }
        .header h2 {
            font-size: 13px;
            font-weight: bold;
            margin: 2px 0;
            color: #1e3a8a;
        }
        .header h3 {
            font-size: 12px;
            font-weight: bold;
            margin: 2px 0;
            text-transform: uppercase;
            color: #0f172a;
        }
        .header p {
            font-size: 9px;
            color: #64748b;
            margin: 2px 0 0 0;
        }
        .title-box {
            text-align: center;
            margin: 15px 0;
        }
        .title-box h4 {
            font-size: 13px;
            text-transform: uppercase;
            margin: 0;
            color: #0f172a;
            text-decoration: underline;
        }
        .title-box p {
            font-size: 10px;
            color: #475569;
            margin: 3px 0 0 0;
        }
        .stats-grid {
            width: 100%;
            margin-bottom: 20px;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
        }
        .stats-grid td {
            padding: 8px 12px;
            text-align: center;
            border: 1px solid #cbd5e1;
        }
        .stats-grid td span.number {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a8a;
            display: block;
        }
        .stats-grid td span.label {
            font-size: 9px;
            color: #475569;
            text-transform: uppercase;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            font-size: 10px;
        }
        table.data-table th {
            background-color: #f1f5f9;
            font-weight: bold;
            text-transform: uppercase;
            color: #334155;
            text-align: left;
        }
        .section-header {
            font-size: 11px;
            font-weight: bold;
            color: #0f172a;
            margin: 15px 0 5px 0;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 40px;
            width: 100%;
        }
        .footer td {
            vertical-align: top;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <!-- Academic Kop Surat -->
    <div class="header">
        <h1>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</h1>
        <h2>UNIVERSITAS SUMATERA UTARA &bull; FAKULTAS VOKASI</h2>
        <h3>PROGRAM STUDI D3 TEKNIK INFORMATIKA</h3>
        <p>Jl. Alumni No. 1 Gedung Vokasi Kampus USU Medan 20155 &bull; Laman: https://vokasi.usu.ac.id</p>
    </div>

    <!-- Title Box -->
    <div class="title-box">
        <h4>LAPORAN EKSEKUTIF PENYERAPAN & KEMITRAAN INDUSTRI LULUSAN</h4>
        <p>Tahun Akademik {{ date('Y') }}/{{ date('Y')+1 }} &bull; Periode Berjalan</p>
    </div>

    <!-- Metrics Summary -->
    <table class="stats-grid">
        <tr>
            <td style="width: 25%;">
                <span class="number">{{ $totalPelamar }}</span>
                <span class="label">Alumni Terdaftar</span>
            </td>
            <td style="width: 25%;">
                <span class="number">{{ $totalPerusahaan }}</span>
                <span class="label">Mitra Terverifikasi</span>
            </td>
            <td style="width: 25%;">
                <span class="number">{{ $totalDiterima }}</span>
                <span class="label">Alumni Diterima Kerja</span>
            </td>
            <td style="width: 25%; background-color: #ecfdf5;">
                <span class="number" style="color: #059669;">{{ $absorptionRate }}%</span>
                <span class="label" style="color: #065f46; font-weight: bold;">Rasio Serapan Kerja</span>
            </td>
        </tr>
    </table>

    <div class="section-header">A. Rekapitulasi Data Alumni Diterima Kerja / Magang Industri</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 15%;">Kode Lamaran</th>
                <th style="width: 20%;">Nama Alumni</th>
                <th style="width: 15%;">NIM / Angkatan</th>
                <th style="width: 22%;">Posisi Pekerjaan</th>
                <th style="width: 24%;">Perusahaan Penempatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penempatan as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-family: monospace; font-weight: bold;">{{ $row->kode_lamaran }}</td>
                    <td><strong>{{ $row->pelamar->user->name }}</strong></td>
                    <td>{{ $row->pelamar->nim }} (Angk. {{ $row->pelamar->angkatan }})</td>
                    <td>{{ $row->lowongan->judul_lowongan }}</td>
                    <td>
                        <strong>{{ $row->lowongan->perusahaan->nama_perusahaan }}</strong><br>
                        <small style="color: #64748b;">{{ $row->lowongan->perusahaan->kota }}</small>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #64748b; padding: 15px;">
                        Belum ada data penempatan kerja yang tercatat pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signature Section -->
    <table class="footer">
        <tr>
            <td style="width: 60%;">
                <p><strong>Catatan Program Studi:</strong></p>
                <p style="color: #64748b; font-size: 9px; line-height: 1.4;">
                    Laporan ini dihasilkan secara otomatis oleh Sistem Informasi E-Recruitment & E-Portofolio Program Studi D3 Teknik Informatika, Fakultas Vokasi USU sebagai dokumen pertanggungjawaban ketercapaian Indikator Kinerja Utama (IKU) Perguruan Tinggi.
                </p>
            </td>
            <td style="width: 40%; text-align: right;">
                <p style="margin: 0;">Medan, {{ now()->isoFormat('D MMMM Y') }}</p>
                <p style="margin: 2px 0 50px 0;"><strong>Ketua Program Studi D3 Teknik Informatika</strong></p>
                <p style="margin: 0; font-weight: bold; text-decoration: underline;">
                    Drs. Mahyuddin M.IT, Ph.D.
                </p>
                <p style="margin: 0; font-size: 9px; color: #64748b;">NIP. 19680521 199403 1 002</p>
            </td>
        </tr>
    </table>

</body>
</html>
