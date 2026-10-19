<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekrutmen - {{ $perusahaan->nama_perusahaan }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.4;
            margin: 0;
            padding: 15px;
        }
        .header {
            border-bottom: 2px solid #1e293b;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            margin: 0;
        }
        .company-info {
            font-size: 10px;
            color: #475569;
            margin: 2px 0 0 0;
        }
        .title-box {
            text-align: center;
            margin: 15px 0;
        }
        .title-box h2 {
            font-size: 13px;
            text-transform: uppercase;
            margin: 0;
            color: #1e3a8a;
        }
        .title-box p {
            font-size: 9px;
            color: #64748b;
            margin: 2px 0 0 0;
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
        .status-badge {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
        }
        .footer {
            margin-top: 30px;
            width: 100%;
        }
        .footer td {
            vertical-align: top;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <!-- Corporate Letterhead -->
    <div class="header">
        <h1 class="company-name">{{ $perusahaan->nama_perusahaan }}</h1>
        <p class="company-info">{{ $perusahaan->bidang_industri }} &bull; {{ $perusahaan->alamat }}, {{ $perusahaan->kota }}</p>
        <p class="company-info">Telp: {{ $perusahaan->no_telp }} &bull; Email: {{ $perusahaan->email_hrd }} @if($perusahaan->website) &bull; Web: {{ $perusahaan->website }} @endif</p>
    </div>

    <!-- Title Box -->
    <div class="title-box">
        <h2>LAPORAN REKAPITULASI SELEKSI REKRUTMEN TALENTA</h2>
        <p>Program Studi D3 Teknik Informatika - Fakultas Vokasi Universitas Sumatera Utara</p>
        <p>Dicetak Pada: {{ now()->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB</p>
    </div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 14%;">Kode Registrasi</th>
                <th style="width: 18%;">Nama Kandidat</th>
                <th style="width: 14%;">NIM / IPK</th>
                <th style="width: 20%;">Posisi Lowongan</th>
                <th style="width: 12%;">Tanggal Lamar</th>
                <th style="width: 18%;">Status / Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lamaran as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td style="font-family: monospace; font-weight: bold;">{{ $row->kode_lamaran }}</td>
                    <td><strong>{{ $row->pelamar->user->name }}</strong></td>
                    <td>{{ $row->pelamar->nim }} (IPK {{ number_format($row->pelamar->ipk, 2) }})</td>
                    <td>{{ $row->lowongan->judul_lowongan }}</td>
                    <td>{{ $row->created_at->format('d/m/Y') }}</td>
                    <td>
                        <span class="status-badge">{{ $row->status_label }}</span>
                        @if($row->status_lamaran === 'interview' && $row->jadwal_interview)
                            <br><small style="color: #d97706;">{{ $row->jadwal_interview->format('d/m/y H:i') }} ({{ $row->metode_interview }})</small>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #64748b; padding: 20px;">
                        Tidak ada riwayat berkas lamaran yang tercatat.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signature Block -->
    <table class="footer">
        <tr>
            <td style="width: 60%;">
                <p><strong>Catatan Instansi:</strong></p>
                <p style="color: #64748b; font-size: 9px;">
                    Laporan ini disusun secara elektronik melalui integrasi platform E-Recruitment D3 Teknik Informatika USU untuk keperluan rekapitulasi internal dan evaluasi penyerapan kerja lulusan.
                </p>
            </td>
            <td style="width: 40%; text-align: right;">
                <p style="margin: 0;">{{ $perusahaan->kota }}, {{ now()->isoFormat('D MMMM Y') }}</p>
                <p style="margin: 3px 0 50px 0;"><strong>Divisi Rekrutmen & HRD</strong></p>
                <p style="margin: 0; font-weight: bold; text-decoration: underline;">
                    {{ $perusahaan->nama_perusahaan }}
                </p>
                <p style="margin: 0; font-size: 9px; color: #64748b;">Mitra Industri Resmi D3 TI USU</p>
            </td>
        </tr>
    </table>

</body>
</html>
