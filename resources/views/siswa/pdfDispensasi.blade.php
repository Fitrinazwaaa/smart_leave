<?php
$path = storage_path('app/public/img/Coat_of_arms_of_West_Java.svg.png');
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Izin</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        margin-right: 45px;
    }

    .container {
        width: 100%;
        margin: auto;
        border: 2px solid black;
        padding: 4px 20px 20px 20px;
        line-height: 1.6;
        height: 450px;
    }

    .header {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        /* Agar elemen tetap di kiri */
    }

    .header img {
        /* margin-right: 15px;  */
        margin-bottom: -800px;
        margin-left: 110px;
    }

    .header .text {
        display: flex;
        flex-direction: column;
        text-align: center;
        /* Membuat teks rata kanan */
        margin-left: 60px;
        /* Mendorong teks ke kanan */
        margin-top: -19px;
    }

    .header p {
        margin: 2px;
    }

    .header .title {
        font-size: 14px;
        font-weight: bold;
    }

    .line {
        border-bottom: 2px solid black;
        margin: 10px 0;
    }

    .content {
        margin-top: 10px;
    }

    label {
        display: inline-block;
        width: 150px;
        /* Sesuaikan lebar sesuai kebutuhan */
        text-align: left;
        /* Menyelaraskan teks ke kiri */
        margin-left: 35px;
    }

    .titik_dua {
        display: inline-block;
        width: 20px;
        /* Menambahkan ruang untuk titik dua */
        text-align: center;
        /* Memastikan titik dua ada di tengah */
    }

    span {
        display: inline-block;
        text-align: left;
    }

    .checkbox {
        display: inline-block;
        width: 12px;
        height: 12px;
        border: 1px solid black;
        margin-right: 5px;
    }

    .signature-container {
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
        text-align: center;
        align-items: center;
    }

    .signature p {
        margin: 5px 0;
    }

    .dibuat {
        text-align: right;
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div class="container" style=" margin-bottom: 20px;">
        <div class="header">
            <img src="<?= $base64 ?>" alt="Logo Sekolah" width="70px">
            <div class="text">
                <p>PEMERINTAH DAERAH PROVINSI JAWA BARAT</p>
                <p style="margin-top: -7px; margin-bottom: -2px;">DINAS PENDIDIKAN</p>
                <h2 style="margin-top: -7px;margin-bottom: -5px; font-weight: bold;">SMK NEGERI 1 KAWALI</h2>
                <p style="font-size: 10px;font-weight: normal;"><i>Jalan Talagasari No. 35 Tlp. (0265) 2797676 Kawali 46253 Kab.Ciamis</i></p>
                <p style="font-size: 10px;font-weight: normal;margin-top: -7px;"><i>Email: smkn1kawali@gmail.com | Website: www.smkn1kawali.sch.id</i></p>
            </div>
        </div>

        <div class="line" style="margin-top: 4px;"></div>

        @foreach ($dispensasi as $data)
        <div class="content">
            <p style="margin-top: -8px;">Kepala SMK Negeri 1 Kawali memberikan izin kepada:</p>
            <p style="margin-top: -8px;"><label>Nama</label><span class="titik_dua">:</span> <span>{{ $data->nama }}</span></p>
            <p style="margin-top: -11px;"><label>NIS</label><span class="titik_dua">:</span> <span>{{ Auth::user()->nis }}</span></p>
            <p style="margin-top: -11px;"><label>Kelas</label><span class="titik_dua">:</span> <span>{{ $data->tingkat }} {{ $data->konsentrasi_keahlian }}</span></p>
            <p style="margin-top: -11px;"><label>Program Keahlian</label><span class="titik_dua">:</span> <span>{{ $data->program_keahlian }}</span></p>
            <p style="margin-top: -11px;"><label>Untuk</label><span class="titik_dua">:</span> <span>{{ $data->kategori }}</span></p>
            <p style="margin-top: -11px;"><label>Mata Pelajaran</label><span class="titik_dua">:</span> <span>{{ $data->mata_pelajaran }}</span></p>
            <p style="margin-top: -11px;"><label>Waktu</label><span class="titik_dua">:</span> <span>{{ \Carbon\Carbon::parse($data->waktu_keluar)->format('d-m-Y, H:i:s') }}</span></p>
            <p style="margin-top: -11px;"><label>Alasan</label><span class="titik_dua">:</span> <span>{{ $data->alasan }}</span></p>
            <p style="margin-top: -11px;">Demikian surat izin ini dibuat agar yang berkepentingan mengetahui dan maklum adanya.</p>
        </div>
        @foreach($data->konfirmasi as $konfirm)
        <div class="signature-container">
            <div class="signature_1" style="width: 30%; text-align: center;">
                <p>Diketahui,</p>
                <p style="margin-top: -15px;">Wakabid Kurikulum</p>
                <br><br>
                <span>{{ $konfirm->nama_wakabid }}</span>
                <p style="margin-top: -15px;">________________________</p>
                <p style="margin-top: -15px">NIP : {{ $konfirm->konfirmasi_3 }}</p>
                <img src="{{ public_path('img/Terkonfirmasi.png') }}" class="image" width="130px" style="margin-top: -105px; z-index: -20; transform: rotate(-30deg); opacity: 0.5;">
            </div>
            <div class="signature_2" style="text-align: center; margin: -180px auto; width: fit-content;">
                <p>Disetujui,</p>
                <p style="margin-top: -15px;">Guru Mata Pelajaran</p>
                <br><br>
                <span>{{ $konfirm->nama_guru }}</span>
                <p style="margin-top: -15px;">________________________</p>
                <p style="margin-top: -15px">NIP : {{ $konfirm->konfirmasi_2 }}</p>
                <img src="{{ public_path('img/Terkonfirmasi.png') }}" class="image" width="130px" style="margin-top: -105px; z-index: -20; transform: rotate(-30deg); opacity: 0.5;">
            </div>
            <div class="signature_3" style="float: right; text-align: center; margin-top: -35px; margin-right: -20px;">
                <p style="margin-top: 26px;">Kawali, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l d F Y') }}</p>
                <p style="margin-top: -15px;">a.n. Kepala Sekolah</p>
                <p style="margin-top: -15px;">Petugas Piket</p>
                <br><br>
                <span>{{ $konfirm->nama_petugas }}</span>
                <p style="margin-top: -11px;">________________________</p>
                <p style="margin-top: -15px">NIP : {{ $konfirm->konfirmasi_1 }}</p>
                <img src="{{ public_path('img/Terkonfirmasi.png') }}" class="image" width="250px" style="margin-top: -140px; z-index: -20; transform: rotate(-30deg); opacity: 0.5;">
            </div>
        </div>
        @endforeach
        @endforeach
    </div>
    <div class="container" style="margin-top: 35px;">
        <div class="header">
            <img src="<?= $base64 ?>" alt="Logo Sekolah" width="70px">
            <div class="text">
                <p>PEMERINTAH DAERAH PROVINSI JAWA BARAT</p>
                <p style="margin-top: -7px; margin-bottom: -2px;">DINAS PENDIDIKAN</p>
                <h2 style="margin-top: -7px;margin-bottom: -5px; font-weight: bold;">SMK NEGERI 1 KAWALI</h2>
                <p style="font-size: 10px;font-weight: normal;"><i>Jalan Talagasari No. 35 Tlp. (0265) 2797676 Kawali 46253 Kab.Ciamis</i></p>
                <p style="font-size: 10px;font-weight: normal;margin-top: -7px;"><i>Email: smkn1kawali@gmail.com | Website: www.smkn1kawali.sch.id</i></p>
            </div>
        </div>

        <div class="line" style="margin-top: 4px;"></div>

        @foreach ($dispensasi as $data)
        <div class="content">
            <p style="margin-top: -8px;">Kepala SMK Negeri 1 Kawali memberikan izin kepada:</p>
            <p style="margin-top: -8px;"><label>Nama</label><span class="titik_dua">:</span> <span>{{ $data->nama }}</span></p>
            <p style="margin-top: -11px;"><label>NIS</label><span class="titik_dua">:</span> <span>{{ Auth::user()->nis }}</span></p>
            <p style="margin-top: -11px;"><label>Kelas</label><span class="titik_dua">:</span> <span>{{ $data->tingkatan }} {{ $data->konsentrasi_keahlian }}</span></p>
            <p style="margin-top: -11px;"><label>Program Keahlian</label><span class="titik_dua">:</span> <span>{{ $data->program_keahlian }}</span></p>
            <p style="margin-top: -11px;"><label>Untuk</label><span class="titik_dua">:</span> <span>{{ $data->kategori }}</span></p>
            <p style="margin-top: -11px;"><label>Mata Pelajaran</label><span class="titik_dua">:</span> <span>{{ $data->mata_pelajaran }}</span></p>
            <p style="margin-top: -11px;"><label>Waktu</label><span class="titik_dua">:</span> <span>{{ \Carbon\Carbon::parse($data->waktu_keluar)->format('d-m-Y, H:i:s') }}</span></p>
            <p style="margin-top: -11px;"><label>Alasan</label><span class="titik_dua">:</span> <span>{{ $data->alasan }}</span></p>
            <p style="margin-top: -11px;">Demikian surat izin ini dibuat agar yang berkepentingan mengetahui dan maklum adanya.</p>
        </div>
        @foreach($data->konfirmasi as $konfirm)
        <div class="signature-container">
            <div class="signature_1" style="width: 30%; text-align: center;">
                <p>Diketahui,</p>
                <p style="margin-top: -15px;">Wakabid Kurikulum</p>
                <br><br>
                <span style="z-index: 1000;">{{ $konfirm->nama_wakabid }}</span>
                <p style="margin-top: -15px;">________________________</p>
                <p style="margin-top: -15px">NIP : {{ $konfirm->konfirmasi_3 }}</p>
                <img src="{{ public_path('img/Terkonfirmasi.png') }}" class="image" width="130px" style="margin-top: -105px; z-index: -20; transform: rotate(-30deg); opacity: 0.5;">
            </div>
            <div class="signature_2" style="text-align: center; margin: -180px auto; width: fit-content;">
                <p>Disetujui,</p>
                <p style="margin-top: -15px;">Guru Mata Pelajaran</p>
                <br><br>
                <span style="z-index: 1000;">{{ $konfirm->nama_guru }}</span>
                <p style="margin-top: -15px;">________________________</p>
                <p style="margin-top: -15px">NIP : {{ $konfirm->konfirmasi_2 }}</p>
                <img src="{{ public_path('img/Terkonfirmasi.png') }}" class="image" width="130px" style="margin-top: -105px; z-index: -20; transform: rotate(-30deg); opacity: 0.5;">
            </div>
            <div class="signature_3" style="float: right; text-align: center; margin-top: -35px; margin-right: -20px;">
                <p style="margin-top: 26px;">Kawali, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l d F Y') }}</p>
                <p style="margin-top: -15px;">a.n. Kepala Sekolah</p>
                <p style="margin-top: -15px;">Petugas Piket</p>
                <br><br>
                <span style="z-index: 1000;">{{ $konfirm->nama_petugas }}</span>
                <p style="margin-top: -11px;">________________________</p>
                <p style="margin-top: -15px">NIP : {{ $konfirm->konfirmasi_1 }}</p>
                <img src="{{ public_path('img/Terkonfirmasi.png') }}" class="image" width="250px" style="margin-top: -140px; z-index: -20; transform: rotate(-30deg); opacity: 0.5;">
            </div>
        </div>
        @endforeach
        @endforeach
    </div>
</body>

</html>