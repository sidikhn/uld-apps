<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Dosen dan Tenaga Kependidikan Disabilitas</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12pt; margin-left: 50px; margin-right: 45px;}
        h2, h3, h4 { text-align: center; margin: 0; }
        .section { margin-top: 20px; }
        .label { font-weight: bold; display: inline-block; width: 150px; }
        .value { display: inline-block; }
        .signature { margin-top: 50px; text-align: right; }
        .logo { text-align: center; margin-bottom: 10px; }
        .logo img { width: 330px; }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ public_path('images/logoBaru.png') }}" alt="Logo UGM">
    </div>
    <h4>Data Dosen/Tenaga Kependidikan Disabilitas</h4>
    <h4>Universitas Gadjah Mada</h4>

    <div class="section">
        <p style="margin: 2px 0;"><span>Nama</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $tendik->nama }}</p>
        <p style="margin: 2px 0;"><span>Alamat</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $tendik->alamat ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>No. KTP</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $tendik->no_ktp ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>Email</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $tendik->email ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>No HP</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $tendik->no_hp ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>Ragam disabilitas</span>&nbsp;: {{ is_array($tendik->ragam_disabilitas) ? implode(', ', $tendik->ragam_disabilitas) : ($tendik->ragam_disabilitas ?? '-') }}</p>
        <p style="margin: 2px 0;">
            <span>Tanggal lahir</span>&nbsp;&nbsp;&nbsp;: 
            {{ $tendik->tanggal_lahir ? \Carbon\Carbon::parse($tendik->tanggal_lahir)->format('d/m/Y') : '-' }}
        </p>
        <p style="margin: 2px 0;"><span>NIP/NIKA</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $tendik->nip_nika ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>Jenis pegawai</span>&nbsp;&nbsp;&nbsp;&nbsp;: {{ $tendik->jenis_pegawai ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>Kategori</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $tendik->kategori_pegawai ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>Unit kerja</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $tendik->unit_kerja ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>Pangkat/Golongan</span>&nbsp;: {{ $tendik->pangkat_golongan ?? '-' }}</p>
    </div>

    <div class="section">
        <p style="margin: 2px 0;"><b>Kondisi disabilitas:</b></p>
        <p style="margin: 2px 0; text-align: justify;">{{ $tendik->detail_disabilitas ?? '-' }}</p>
    </div>

    <div class="section">
        <p style="margin: 2px 0;"><b>Alat bantu yang digunakan:</b></p>
        <p style="margin: 2px 0; text-align: justify;">{{ $tendik->alat_bantu ?? '-' }}</p>
    </div>

    <div class="section">
        <p style="margin: 2px 0;"><b>Kondisi disabilitas:</b></p>
        <p style="margin: 2px 0; text-align: justify;">{{ $tendik->detail_disabilitas ?? '-' }}</p>
    </div>

    <div class="section">
        <p style="margin: 2px 0;"><b>Kesulitan yang dialami saat mengajar:</b></p>
        <p style="margin: 2px 0; text-align: justify;">{{ $tendik->kendala ?? '-' }}</p>
    </div>

    <div class="section">
        <p style="margin: 2px 0;"><b>Kebutuhan/fasilitasi penyesuaian akomodasi layak yang diperlukan:</b></p>
        <p style="margin: 2px 0; text-align: justify;">{{ $tendik->akomodasi ?? '-' }}</p>
    </div>

    @if($tendik->surat_keterangan_link)
        <div class="section">
            <p style="margin: 2px 0;"><b>Surat Keterangan Disabilitas:</b></p>
            {{-- <p style="margin: 2px 0;">{{ $tendik->surat_keterangan_link ?? '-' }}</p> --}}
            <p style="margin: 2px 0;">
                <a href="{{ $tendik->surat_keterangan_link }}" target="_blank">
                    {{ $tendik->surat_keterangan_link }}
                </a>
            </p>
        </div>
    @endif

    <div class="section">
        <p style="margin: 20px 0 0 0;">Wuri Handayani, Ph.D</p>
        <p style="margin: 2px 0;">Ketua Unit Layanan Disabilitas</p>
    </div>
</body>
</html>
