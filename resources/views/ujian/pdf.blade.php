<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Asesmen Individu Mahasiswa Disabilitas</title>
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
    <h4>Asesmen Kebutuhan Ujian Mahasiswa Disabilitas</h4>
    <h4>Universitas Gadjah Mada</h4>

    <div class="section">
        <p style="margin: 2px 0;"><span>Nama</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $asesmen_ujian->nama }}</p>
        <p style="margin: 2px 0;"><span>Jenis kelamin</span>&nbsp;&nbsp;: {{ $asesmen_ujian->jenis_kelamin ?? '-' }}</p>
        <p style="margin: 2px 0;">
            <span>Tanggal lahir</span>&nbsp;&nbsp;&nbsp;: 
            {{ $asesmen_ujian->tanggal_lahir ? \Carbon\Carbon::parse($asesmen_ujian->tanggal_lahir)->format('d/m/Y') : '-' }}
        </p>
        <p style="margin: 2px 0;"><span>Disabilitas</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $asesmen_ujian->ragam_disabilitas ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>Fakultas</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $asesmen_ujian->fakultas ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>Prodi</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $asesmen_ujian->prodi ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>NIM</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $asesmen_ujian->nim }}</p>
    </div>

    <div class="section">
        <p style="margin: 2px 0;"><b>Keperluan Perpanjangan Waktu:</b></p>
        <p style="margin: 2px 0; text-align: justify;">{{ $asesmen_ujian->keperluan_perpanjangan ?? '-' }}</p>
    </div>

    <div class="section">
        <p style="margin: 2px 0;"><b>Preferensi Format Soal Ujian:</b></p>
        <p style="margin: 2px 0; text-align: justify;">{{ $asesmen_ujian->preferensi_format ?? '-' }}</p>
    </div>

    <div class="section">
        <p style="margin: 2px 0;"><b>Keperluan Pendampingan saat Ujian:</b></p>
        <p style="margin: 2px 0; text-align: justify;">{{ $asesmen_ujian->keperluan_pendampingan ?? '-' }}</p>
    </div>
    
    <div class="section">
        <p style="margin: 2px 0;"><b>Penyesuaian Lain yang Diperlukan:</b></p>
        <p style="margin: 2px 0; text-align: justify;">{{ $asesmen_ujian->penyesuaian_lain ?? '-' }}</p>
    </div>

    <div class="section">
        <p style="margin: 30px 0 0 0;">Wuri Handayani, Ph.D</p>
        <p style="margin: 2px 0;">Ketua Unit Layanan Disabilitas</p>
    </div>
</body>
</html>
