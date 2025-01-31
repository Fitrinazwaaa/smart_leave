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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Konfirmasi Guru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJb3RrP6j1eg84BQ2erfFPLBaZrj1I1NE9FYkCOs5TtZUSSHjGZbmL8HjzqP" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
    .container{
      max-width: 1280px;
  margin: 130px auto 0;
  padding: 30px;
  background-color: #ffffff;
  border-radius: 10px;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 5px 16px rgba(0, 0, 0, 0.2);
      margin-bottom: 20px;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
      transform: scale(1.02);
      box-shadow: 0 5px 16px rgba(0, 0, 0, 0.3);
    }

    .card-body {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .student-info {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .student-info .name {
      font-size: 1.2rem;
      font-weight: bold;
      margin: 0;
    }

    .student-info .class {
      font-size: 0.95rem;
      color: #6c757d;
      margin: 0;
    }

    .actions button {
      background-color: #4b6cb7;
      color: white;
      min-width: 110px;
      transition: background-color 0.2s, transform 0.2s;
    }
    
    .actions .btn:hover {
      background-color: #4b6cb7;
      color: white;
      transform: translateY(-2px);
    }

    .actions .detail {
      background-color: #007bff;
      color: #fff;
      border: none;
    }

    .actions .detail:hover {
      background-color: #0056b3;
    }

    .actions .confirm {
      background-color: #28a745;
      color: #fff;
      border: none;
    }

    .actions .confirm:hover {
      background-color: #218838;
    }

    .actions .confirm:disabled {
      background-color: #d6d8db;
      color: #6c757d;
      cursor: not-allowed;
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
    <h1 class="mb-4 text-center">Konfirmasi Dispensasi - Guru Piket</h1>
    @foreach ($dispen as $data)
  <!-- Guru Piket Card -->
  <div class="card">
    <div class="card-body">
      <div class="d-flex align-items-center gap-3">
        <div class="student-info">
          <p class="name">{{ $data->nama }} ({{ $data->nis }})</p>
          <p class="class">{{ $data->tingkat }} {{ $data->konsentrasi_keahlian }}</p>
        </div>
      </div>
      <div class="actions d-flex gap-2">
        <button class="btn" >Detail</button>
        <!-- Form Konfirmasi -->
        <form action="{{ route('konfirmasiPiket') }}" method="POST">
          @csrf
          <input type="hidden" name="id_dispen" value="{{ $data->id_dispen }}">
          <div class="actions d-flex gap-2">
            <button type="submit" class="btn">Konfirmasi</button>
          </div>
        </form>
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
</body>

</html>