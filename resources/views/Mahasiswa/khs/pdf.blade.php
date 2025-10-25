<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KHS - {{ $mahasiswa->nim }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.2;
            padding: 20px;
        }

        .header {
            margin-bottom: 15px;
            padding-bottom: 10px;
            position: relative;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .logo-section {
            display: table-cell;
            width: 80px;
            vertical-align: top;
            padding-right: 15px;
        }

        .logo-section img {
            width: 70px;
            height: auto;
        }

        .text-section {
            display: table-cell;
            text-align: center;
            vertical-align: top;
        }

        .kop-kementerian {
            font-size: 9pt;
            font-weight: bold;
            color: #000;
            margin-bottom: 3px;
            text-transform: uppercase;
        }

        .kop-institusi {
            font-size: 12pt;
            font-weight: bold;
            color: #0B6623;
            margin-bottom: 3px;
        }

        .kop-alamat {
            font-size: 8pt;
            color: #333;
            line-height: 1.3;
            margin-bottom: 8px;
        }

        .header-divider {
            border-bottom: 2px solid #0B6623;
            margin: 10px 0;
            clear: both;
        }

        .document-title {
            font-size: 13pt;
            font-weight: bold;
            color: #0B6623;
            margin-top: 10px;
            margin-bottom: 10px;
            text-transform: uppercase;
            text-align: center;
        }

        .info-section {
            margin-bottom: 12px;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            width: 130px;
            padding: 2px 0;
            font-weight: bold;
            color: #333;
            font-size: 9pt;
        }

        .info-separator {
            display: table-cell;
            width: 15px;
            padding: 2px 0;
        }

        .info-value {
            display: table-cell;
            padding: 2px 0;
            color: #555;
            font-size: 9pt;
        }

        .summary-box {
            background-color: #f8f9fa;
            border: 1px solid #0B6623;
            border-radius: 4px;
            padding: 8px;
            margin-bottom: 12px;
        }

        .summary-title {
            font-size: 10pt;
            font-weight: bold;
            color: #0B6623;
            margin-bottom: 8px;
        }

        .summary-grid {
            display: table;
            width: 100%;
        }

        .summary-row {
            display: table-row;
        }

        .summary-cell {
            display: table-cell;
            width: 25%;
            padding: 4px;
            text-align: center;
        }

        .summary-label {
            font-size: 8pt;
            color: #666;
            margin-bottom: 3px;
        }

        .summary-value {
            font-size: 12pt;
            font-weight: bold;
            color: #0B6623;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table thead {
            background-color: #0B6623;
            color: white;
        }

        table thead th {
            padding: 6px 4px;
            text-align: left;
            font-size: 8pt;
            font-weight: bold;
        }

        table tbody td {
            padding: 4px;
            border-bottom: 1px solid #ddd;
            font-size: 8pt;
        }

        table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table tfoot td {
            padding: 6px 4px;
            font-weight: bold;
            background-color: #f0f0f0;
            border-top: 2px solid #0B6623;
            font-size: 8pt;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        .signature-section {
            width: 100%;
            text-align: right;
            margin-top: 15px;
            padding-right: 100px;
        }

        .signature-box {
            margin-top: 50px;
            border-bottom: 1px solid #333;
            padding-bottom: 3px;
            display: inline-block;
            min-width: 180px;
        }

        .date-print {
            font-size: 7pt;
            color: #666;
            text-align: right;
            margin-top: 10px;
        }

        .badge-nilai {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 7pt;
        }

        .nilai-a, .nilai-a-plus { background-color: #d4edda; color: #155724; }
        .nilai-a-minus { background-color: #d1ecf1; color: #0c5460; }
        .nilai-b, .nilai-b-plus { background-color: #cfe2ff; color: #084298; }
        .nilai-b-minus { background-color: #e7f1ff; color: #052c65; }
        .nilai-c, .nilai-c-plus { background-color: #fff3cd; color: #856404; }
        .nilai-c-minus { background-color: #fff8e1; color: #6c5400; }
        .nilai-d { background-color: #ffebee; color: #c62828; }
        .nilai-e { background-color: #f3e5f5; color: #6a1b9a; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo-section">
                <img src="{{ public_path('images/stai-raya-logo.png') }}" alt="Logo STAI RAYA">
            </div>
            <div class="text-section">
                <div class="kop-institusi" style="font-size: 11pt; font-weight: bold; margin-bottom: 2px;">
                    SEKOLAH TINGGI AGAMA ISLAM<br>
                    RADEN ABDULLAH YAQIN (STAI RAYA)
                </div>
                <div style="font-size: 10pt; font-weight: bold; color: #000; margin-bottom: 5px;">
                    MLOKOREJO - JEMBER
                </div>
                <div class="kop-alamat" style="font-size: 7.5pt;">
                    Alamat : Jl. KH. Abdullah Yaqin No. 1-5 Mlokorejo Jember &nbsp; Telp : 085258963834<br>
                    Email : stairayajember@gmail.com Website : https://ponpes-mloko.net
                </div>
            </div>
        </div>
        <div class="header-divider"></div>
        <div class="document-title">
            Kartu Hasil Studi (KHS)
        </div>
    </div>

    <div class="info-section">
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">NIM</div>
                <div class="info-separator">:</div>
                <div class="info-value">{{ $mahasiswa->nim }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nama Mahasiswa</div>
                <div class="info-separator">:</div>
                <div class="info-value">{{ $mahasiswa->nama_lengkap }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Program Studi</div>
                <div class="info-separator">:</div>
                <div class="info-value">{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Semester</div>
                <div class="info-separator">:</div>
                <div class="info-value">{{ $khs->semester }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tahun Ajaran</div>
                <div class="info-separator">:</div>
                <div class="info-value">{{ $khs->tahun_ajaran ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="summary-box">
        <div class="summary-title">Ringkasan Hasil Studi</div>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">
                    <div class="summary-label">Total SKS</div>
                    <div class="summary-value">{{ $khs->total_sks ?? 0 }}</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">IP Semester (IPS)</div>
                    <div class="summary-value">{{ number_format($khs->ips ?? 0, 2) }}</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">IP Kumulatif (IPK)</div>
                    <div class="summary-value">{{ number_format($khs->ipk ?? 0, 2) }}</div>
                </div>
                <div class="summary-cell">
                    <div class="summary-label">Status</div>
                    <div class="summary-value" style="font-size: 10pt;">
                        @if($khs->ips >= 3.0)
                            BAIK
                        @elseif($khs->ips >= 2.5)
                            CUKUP
                        @else
                            KURANG
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Kode MK</th>
                <th style="width: 40%;">Mata Kuliah</th>
                <th style="width: 8%;" class="text-center">SKS</th>
                <th style="width: 10%;" class="text-center">Nilai Angka</th>
                <th style="width: 12%;" class="text-center">Nilai Huruf</th>
                <th style="width: 10%;" class="text-center">Nilai Indeks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($khs->details as $index => $detail)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $detail->mataKuliah->kode_matakuliah ?? '-' }}</td>
                    <td>{{ $detail->mataKuliah->nama_matakuliah ?? '-' }}</td>
                    <td class="text-center">{{ $detail->sks ?? 0 }}</td>
                    <td class="text-center">{{ number_format($detail->nilai_angka ?? 0, 2) }}</td>
                    <td class="text-center">
                        <span class="badge-nilai nilai-{{ strtolower(str_replace(['+', '-'], ['-plus', '-minus'], $detail->nilai_huruf ?? 'e')) }}">
                            {{ $detail->nilai_huruf ?? '-' }}
                        </span>
                    </td>
                    <td class="text-center">{{ number_format($detail->nilai_indeks ?? 0, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Total SKS</strong></td>
                <td class="text-center"><strong>{{ $khs->total_sks ?? 0 }}</strong></td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div class="signature-section">
            <div>Jember, {{ date('d F Y') }}</div>
            <div style="margin-top: 8px; font-weight: bold; font-size: 9pt;">Ketua Program Studi</div>
            <div class="signature-box"></div>
            <div style="margin-top: 3px; font-weight: bold; font-size: 9pt;">
                @if($mahasiswa->prodi && $mahasiswa->prodi->ketua_prodi)
                    {{ $mahasiswa->prodi->ketua_prodi }}
                @else
                    (...........................)
                @endif
            </div>
            @if($mahasiswa->prodi && $mahasiswa->prodi->nidn_ketua_prodi)
                <div style="margin-top: 2px; font-size: 8pt; color: #555;">
                    NIDN: {{ $mahasiswa->prodi->nidn_ketua_prodi }}
                </div>
            @endif
        </div>

        <div class="date-print">
            Dicetak pada: {{ date('d F Y H:i:s') }}
        </div>
    </div>
</body>
</html>
