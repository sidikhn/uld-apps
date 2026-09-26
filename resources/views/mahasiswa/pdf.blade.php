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
    <h4>Asesmen Individu Mahasiswa Disabilitas</h4>
    <h4>Universitas Gadjah Mada</h4>

    <div class="section">
        <p style="margin: 2px 0;"><span>Nama</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $mahasiswa->nama }}</p>
        <p style="margin: 2px 0;"><span>Jenis kelamin</span>&nbsp;&nbsp;: {{ $mahasiswa->jenis_kelamin ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>Disabilitas</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ is_array($mahasiswa->ragam_disabilitas) ? implode(', ', $mahasiswa->ragam_disabilitas) : ($mahasiswa->ragam_disabilitas ?? '-') }}@if($mahasiswa->subragam_formatted && $mahasiswa->subragam_formatted !== '-') ({{ $mahasiswa->subragam_formatted }})@endif</p>
        <p style="margin: 2px 0;">
            <span>Tanggal lahir</span>&nbsp;&nbsp;&nbsp;: 
            {{ $mahasiswa->tanggal_lahir ? \Carbon\Carbon::parse($mahasiswa->tanggal_lahir)->format('d/m/Y') : '-' }}
        </p>
        <p style="margin: 2px 0;"><span>Fakultas</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $mahasiswa->fakultas ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>Prodi</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $mahasiswa->prodi ?? '-' }}</p>
        <p style="margin: 2px 0;"><span>NIM</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $mahasiswa->nim }}</p>
        <p style="margin: 2px 0;"><span>Tahun Asesmen</span>&nbsp;&nbsp;&nbsp;: {{ $mahasiswa->tahun_asesmen ?? '-' }}</p>
    </div>

    <div class="section">
        <p style="margin: 2px 0;"><b>Kondisi disabilitas:</b></p>
        <p style="margin: 2px 0; text-align: justify;">{{ $mahasiswa->detail_disabilitas ?? '-' }}</p>
    </div>

    <div class="section">
        <p style="margin: 2px 0;"><b>Kesulitan yang dialami saat belajar:</b></p>
        <p style="margin: 2px 0; text-align: justify;">{{ $mahasiswa->kendala ?? '-' }}</p>
    </div>

    <div class="section">
        <p style="margin: 2px 0;"><b>Kebutuhan/fasilitasi penyesuaian akomodasi layak yang diperlukan:</b></p>
        <p style="margin: 2px 0; text-align: justify;">{{ $mahasiswa->akomodasi ?? '-' }}</p>
    </div>

    @if($mahasiswa->surat_keterangan_link)
        <div class="section">
            <p style="margin: 2px 0;"><b>Surat Keterangan Disabilitas:</b></p>
            {{-- <p style="margin: 2px 0;">{{ $mahasiswa->surat_keterangan_link ?? '-' }}</p> --}}
            <p style="margin: 2px 0;">
                <a href="{{ $mahasiswa->surat_keterangan_link }}" target="_blank">
                    {{ $mahasiswa->surat_keterangan_link }}
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
