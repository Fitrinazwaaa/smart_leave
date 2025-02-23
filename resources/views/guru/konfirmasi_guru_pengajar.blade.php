<?php

use App\Models\AkunGuru;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Carbon::setLocale('id');
$nip = Auth::user()->nip;  // Mendapatkan nip dari user yang sedang login
$guru = AkunGuru::where('nip', $nip)->first();
// Ambil data pengguna dari tabel akun_guru berdasarkan NIP
$akunGuru = DB::table('akun_guru')->where('nip', $nip)->first();

if (!$guru) {
  // Jika guru tidak ditemukan, tampilkan error atau redirect
  return redirect()->route('login')->withErrors(['error' => 'Guru tidak ditemukan.']);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konfirmasi Dispensasi - Guru Matapelajaran</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJb3RrP6j1eg84BQ2erfFPLBaZrj1I1NE9FYkCOs5TtZUSSHjGZbmL8HjzqP" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* Global Style */
    html,
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      min-height: 100vh;
      overflow-x: hidden;
      overscroll-behavior: none;
      background: linear-gradient(to bottom, #ffffff, #f3f4f7);
      background-image: url('https://www.transparenttextures.com/patterns/asfalt-dark.png');
      background-attachment: fixed;
      /* Membuat latar belakang tetap */
    }

    /* Header Style */
    header {
      position: fixed;
      width: 100%;
      top: 0;
      display: flex;
      justify-content: flex-start;
      /* Align items to the start */
      align-items: center;
      /* Vertically center the content */
      padding: 15px;
      background: linear-gradient(90deg, #030248, #4b6cb7);
      color: white;
      z-index: 1000;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      border-bottom: 3px solid #dce400;
      transition: all 0.3s ease;
    }

    header:hover {
      box-shadow: 0 6px 14px rgba(0, 0, 0, 0.4);
    }

    /* Back Button Styling (Arrow only) */
    header .back-button {
      margin-left: 40px;
      margin-right: 20px;
      background-color: transparent;
      border: none;
      padding: 8px;
      font-size: 20px;
      color: white;
      cursor: pointer;
      transition: transform 0.3s ease, color 0.3s ease;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0;
      /* Ensure no space between button and icon */
    }

    header .back-button i {
      font-size: 20px;
      margin: 0;
      /* Ensure no extra space around the icon */
      transition: transform 0.3s ease, color 0.3s ease;
    }

    /* Hover effect */
    header .back-button:hover {
      transform: scale(1.1);
      color: #dce400;
      /* Change to gold color on hover */
    }

    /* Focus effect */
    header .back-button:focus {
      outline: none;
      transform: scale(1.1);
    }

    /* Logo Styling */
    header .logo {
      display: flex;
      align-items: center;
      /* Align logo vertically in the center */
      justify-content: center;
      /* Center content horizontally */
      gap: 16px;
    }

    header .logo img {
      width: 70px;
      height: 70px;
      padding: 5px;
      border-radius: 50%;
      border: 3px solid white;
    }

    header h2 {
      margin: 0;
      font-size: 24px;
      font-weight: bold;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
      line-height: 1.2;
      /* Adjust line height to improve vertical centering */
    }

    header .sub-title {
      margin: 0;
      font-size: 14px;
      color: #dce400;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }

    .container {
      max-width: 1200px;
      margin: 120px auto 0;
      padding: 30px;
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 5px 16px rgba(0, 0, 0, 0.1);
      margin-bottom: 15px;
      transition: transform 0.2s, box-shadow 0.2s;
      padding: 15px;
    }

    .card:hover {
      transform: scale(1.02);
      box-shadow: 0 5px 16px rgba(0, 0, 0, 0.3);
    }

    .row-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 15px;
    }

    .student-info {
      flex: 1;
      text-align: left;
    }

    .student-info .name {
      font-size: 18px;
      font-weight: bold;
      margin: 0;
      color: #343a40;
    }

    .student-info .class,
    .student-info .time-info {
      font-size: 13px;
      color: #6c757d;
      margin: 0;
    }

    .actions {
      display: flex;
      gap: 10px;
    }

    .btn-detail {
      background-color: #4b6cb7;
      color: white;
      border: none;
      transition: all 0.3s;
    }

    .btn-detail:hover {
      background-color: #434190;
      transform: translateY(-2px);
      color: white;
    }

    .btn-confirm {
      background-color: #38a169;
      color: white;
      border: none;
      transition: all 0.3s;
    }

    .btn-confirm:hover {
      background-color: #2f855a;
      transform: translateY(-2px);
      color: white;
    }

    /* Modal Styling */
    .modal-content {
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
      background-color: #4b6cb7;
      color: white;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }

    .modal-body p {
      font-size: 1rem;
      color: #555;
    }

    .modal-body i {
      margin-right: 8px;
      color: #4b6cb7;
    }

    .modal-body img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .modal-footer {
      background-color: #f8f9fa;
      border-bottom-left-radius: 15px;
      border-bottom-right-radius: 15px;
    }

    /* Mobile Specific Styling */
    @media (max-width: 768px) {

/* Header */
header {
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 8px;
  position: fixed;
}

header .back-button {
  position: absolute;
  top: 8px;
  left: 8px;
  margin: 0;
  font-size: 16px;
  width: 36px;
  height: 36px;
}

header .logo {
  flex-direction: column;
  gap: 8px;
}

header .logo img {
  width: 50px;
  height: 50px;
}

header h2 {
  font-size: 18px;
}

header .sub-title {
  font-size: 12px;
}

/* Container */
.container {
  margin: 140px auto 0;
  padding: 16px;
  border-radius: 8px;
}

.container h5 {
  font-size: 14px;
}

.container p,
.container button {
  font-size: 12px;
}

.container .modal-title {
  font-size: 14px;
}

.container img {
  max-width: 100%;
  height: auto;
}

.container .btn {
  padding: 6px;
  font-size: 13px;
}

/* Card */
.container .card {
  padding: 10px 12px;
  margin-bottom: 12px;
}

.container .card:hover {
  transform: none;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

/* Row Content */
.student-info {
  text-align: left;
}

.student-info .name {
  font-size: 12px;
}

.student-info .time-info {
  font-size: 10px;
}

/* Buttons */
.actions {
  flex-direction: row;
  gap: 6px;
}

.btn-detail,
.btn-confirm {
  padding: 6px 10px;
  font-size: 12px;
}

/* Modal */
.modal-content {
  padding: 16px;
}

.modal-header {
  padding: 12px;
}

.modal-body p {
  font-size: 12px;
}

.modal-body img {
  margin-top: 8px;
  border-radius: 8px;
}

.modal-footer {
  padding: 10px;
}

/* Semi-circle */
.semi-circle {
  width: 90%;
  height: 150px;
  margin: -75px auto 32px;
  border-radius: 50% / 50%;
}
}
  </style>

</head>

<body>
  <header>
    <button class="back-button" onclick="window.location.href='{{ route('dashboard.guru') }}';">
      <i class="fas fa-arrow-left"></i>
    </button>
    <div class="logo">
      <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="Logo">
      <div>
        <h2>DISPENSASI DIGITAL SMK NEGERI 1 KAWALI</h2>
        <p class="sub-title">{{ $guru->nama }}</p>
      </div>
    </div>
  </header>
  @if (session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif

  <div class="container">
    <h3 class="mb-4 text-center fw-bold">Konfirmasi Dispensasi Oleh Guru Matapelajaran</h3>

    @foreach ($dispen as $data)
    <div class="card">
      <div class="row-content">
        <!-- Informasi Siswa (Kiri) -->
        <div class="student-info">
          <p class="name"><i class="bi bi-person-circle"></i> {{ $data->nama }} - {{ $data->tingkatan }} {{ $data->konsentrasi_keahlian }}</p>
          <!-- <p class="class"><i class="bi bi-book"></i> {{ $data->tingkatan }} {{ $data->konsentrasi_keahlian }}</p> -->
          <p class="time-info" style="margin-left: 2px;"><i class="bi bi-clock" style="margin-right: 4px;"></i> {{ $data->created_at->format('d M Y, H:i') }}</p>
        </div>

        <!-- Tombol Aksi (Kanan) -->
        <div class="actions">
          <button class="btn btn-detail px-3" data-bs-toggle="modal" data-bs-target="#modal{{ $data->id_dispen }}" style="font-size: 13px;">
            <i class="bi bi-eye"></i> Detail
          </button>

          <form action="{{ route('konfirmasiMataPelajaran') }}" method="POST">
            @csrf
            <input type="hidden" name="id_dispen" value="{{ $data->id_dispen }}">
            <button type="submit" class="btn btn-confirm px-3" style="font-size: 13px;"><i class="bi bi-check-circle"></i> Konfirmasi</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Detail Dispensasi -->
    <div class="modal fade" id="modal{{ $data->id_dispen }}" tabindex="-1" aria-labelledby="modalLabel{{ $data->id_dispen }}" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-bold" id="modalLabel{{ $data->id_dispen }}"><i class="bi bi-info-circle"></i> Detail Dispensasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p><i class="bi bi-person"></i> <strong>Nama:</strong> {{ $data->nama }}</p>
            <p><i class="bi bi-hash"></i> <strong>NIS:</strong> {{ $data->nis }}</p>
            <p><i class="bi bi-mortarboard"></i> <strong>Kelas:</strong> {{ $data->tingkatan }} {{ $data->konsentrasi_keahlian }}</p>
            <p><i class="bi bi-clock"></i> <strong>Waktu Pengajuan:</strong> {{ $data->created_at->format('d M Y, H:i') }}</p>
            <p><i class="bi bi-chat-text"></i> <strong>Kategori:</strong> {{ $data->kategori }}</p>
            <p><i class="bi bi-chat-text"></i> <strong>Alasan:</strong> {{ $data->alasan }}</p>

            @if($data->bukti_foto)
            <p><i class="bi bi-camera"></i> <strong>Bukti Foto:</strong></p>
            <img src="{{ asset('storage/'.$data->bukti_foto) }}" alt="Bukti Dispensasi">
            @endif
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>

    @endforeach
  </div>

  <!-- Bootstrap and Bootstrap Icons CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybOveo3f8VgJUvP5Vyn6pd56rOH1diJfqa0ksL8/4Oh3nybs0" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0uW9YrkQ+Q+97Jmf6fF3j1vSxtIhQczb1Y88aV6YQw0W6qHm" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>