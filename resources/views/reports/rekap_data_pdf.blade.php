<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Data {{ $title }} - ULD UGM</title>
    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
            size: A4 landscape;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9pt;
            color: #1e293b;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header {
            border-bottom: 2px solid #1B4E71;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: middle;
            border: none;
            padding: 0;
        }
        .logo-img {
            height: 48px;
        }
        .header-text {
            text-align: right;
        }
        .header-text h1 {
            font-size: 15pt;
            font-weight: bold;
            color: #1B4E71;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header-text p {
            font-size: 8.5pt;
            color: #64748b;
            margin: 0;
        }
        .meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 14px;
            font-size: 8.5pt;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
        }
        .meta-table td {
            border: none;
            padding: 2px 4px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        table.data-table th {
            background-color: #1B4E71;
            color: #ffffff;
            font-weight: 600;
            text-align: left;
            padding: 8px 6px;
            font-size: 8pt;
            border: 1px solid #1B4E71;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        table.data-table td {
            padding: 6px 6px;
            border: 1px solid #cbd5e1;
            font-size: 8pt;
            vertical-align: top;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 5px;
            font-size: 7.5pt;
            font-weight: 600;
            border-radius: 4px;
            background-color: #e0f2fe;
            color: #0369a1;
            font-family: monospace;
        }
        .tag-disabilitas {
            display: inline-block;
            padding: 1px 4px;
            font-size: 7.5pt;
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 3px;
            margin-bottom: 2px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20px;
            font-size: 8pt;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 4px;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-table td {
            border: none;
            padding: 0;
        }
    </style>
</head>
<body>

    {{-- HEADER KOP LAPORAN --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 50%;">
                    @if(file_exists(public_path('images/logoBaru.png')))
                        <img src="{{ public_path('images/logoBaru.png') }}" class="logo-img" alt="Logo UGM">
                    @endif
                </td>
                <td style="width: 50%;" class="header-text">
                    <h1>REKAPITULASI DATA {{ strtoupper($title) }}</h1>
                    <p>Unit Layanan Disabilitas (ULD) — Universitas Gadjah Mada</p>
                </td>
            </tr>
        </table>
    </div>

    {{-- INFORMASI REKAP --}}
    <div class="meta-box">
        <table class="meta-table">
            <tr>
                <td style="width: 18%; font-weight: bold; color: #475569;">Kategori Data:</td>
                <td style="width: 32%;">{{ $title }}</td>
                <td style="width: 20%; font-weight: bold; color: #475569;">Waktu Ekspor:</td>
                <td style="width: 30%;">{{ now()->translatedFormat('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td style="font-weight: bold; color: #475569;">Total Mahasiswa:</td>
                <td><b>{{ count($items) }} Orang</b></td>
                <td style="font-weight: bold; color: #475569;">Dicetak Oleh:</td>
                <td>{{ auth()->user()->name ?? 'Administrator' }} ({{ auth()->user()->email ?? '-' }})</td>
            </tr>
        </table>
    </div>

    {{-- TABEL DATA UTAMA --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">No</th>
                <th style="width: 14%;">No. Induk ULD</th>
                <th style="width: 18%;">Nama & NIM</th>
                <th style="width: 18%;">Fakultas / Program Studi</th>
                <th style="width: 16%;">Ragam & Subragam</th>
                <th style="width: 14%;">Alat Bantu</th>
                <th style="width: 16%;">Kebutuhan Akomodasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
                @php
                    $ragam = is_array($item->ragam_disabilitas) ? implode(', ', $item->ragam_disabilitas) : ($item->ragam_disabilitas ?? '-');
                    $subragamFormatted = method_exists($item, 'getSubragamFormattedAttribute') ? $item->subragam_formatted : '-';
                @endphp
                <tr>
                    <td style="text-align: center; color: #64748b;">{{ $index + 1 }}</td>
                    <td>
                        @if($item->nomor_induk_uld)
                            <span class="badge">{{ $item->nomor_induk_uld }}</span>
                        @else
                            <span style="color: #94a3b8;">-</span>
                        @endif
                    </td>
                    <td>
                        <b style="color: #0f172a;">{{ $item->nama }}</b>
                        @if(($item->status ?? '') === 'meninggal')
                            <span style="font-size: 6.5pt; font-weight: bold; background: #334155; color: #ffffff; padding: 1px 4px; border-radius: 2px;">MENINGGAL DUNIA</span>
                        @elseif(($item->status ?? '') === 'cuti')
                            <span style="font-size: 6.5pt; font-weight: bold; background: #fef3c7; color: #92400e; padding: 1px 4px; border-radius: 2px;">CUTI</span>
                        @elseif(($item->status ?? '') === 'mengundurkan_diri')
                            <span style="font-size: 6.5pt; font-weight: bold; background: #ffe4e6; color: #9f1239; padding: 1px 4px; border-radius: 2px;">KELUAR</span>
                        @endif
                        <br>
                        <span style="color: #475569; font-size: 7.5pt;">NIM: {{ $item->nim }}</span><br>
                        <span style="color: #64748b; font-size: 7pt;">Jenjang: {{ $item->pendidikan ?? 'S1' }} ({{ $item->angkatan ?? '-' }})</span>
                    </td>
                    <td>
                        <b>{{ $item->fakultas ?? '-' }}</b><br>
                        <span style="color: #64748b; font-size: 7.5pt;">{{ $item->prodi ?? '-' }}</span>
                    </td>
                    <td>
                        <div class="tag-disabilitas">{{ $ragam }}</div>
                        @if($subragamFormatted && $subragamFormatted !== '-')
                            <br><span style="color: #475569; font-size: 7pt;">Sub: {{ $subragamFormatted }}</span>
                        @endif
                    </td>
                    <td style="font-size: 7.5pt;">
                        {{ $item->alat_bantu ?: '-' }}
                    </td>
                    <td style="font-size: 7pt; color: #334155;">
                        {{ Str::limit($item->akomodasi ?: '-', 120) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #94a3b8;">
                        Tidak ada data yang tersedia untuk dicetak.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER HALAMAN --}}
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td style="width: 50%;">Unit Layanan Disabilitas UGM | Dokumen Rahasia Akademik</td>
                <td style="width: 50%; text-align: right;">Sistem Informasi ULD UGM</td>
            </tr>
        </table>
    </div>

</body>
</html>
