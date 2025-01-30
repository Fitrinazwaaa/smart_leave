<?php
// Ambil NIP dari pengguna yang sedang login

use App\Models\AkunGuru;
use App\Models\Dispensasi;
use App\Models\Konfirmasi;
use Illuminate\Support\Facades\Auth;

$nip = Auth::user()->nip;
$guru = AkunGuru::where('nip', $nip)->first();

// Jika guru tidak ditemukan, redirect ke halaman login dengan error
if (!$guru) {
    return redirect()->route('login')->withErrors(['error' => 'Guru tidak ditemukan.']);
}

// Variabel untuk menampung jumlah pengajuan yang memerlukan konfirmasi
$pengajuanPiket = 0;
$pengajuanPengajar = 0;
$pengajuanKurikulum = 0;

// Memeriksa apakah guru tersebut memiliki izin untuk mengonfirmasi pengajuan
if ($guru->jabatan == 'piket') {
    // Hitung jumlah pengajuan yang memerlukan konfirmasi untuk guru piket
    $pengajuanPiket = Dispensasi::join('konfirmasi', 'dispensasi.id_dispen', '=', 'konfirmasi.id_dispen')
        ->where('dispensasi.nip', $nip)
        ->whereNull('konfirmasi.konfirmasi_1')  // Belum terkonfirmasi oleh guru piket
        ->whereNull('konfirmasi.konfirmasi_2')  // Belum terkonfirmasi oleh pihak lain
        ->count();
}

if ($guru->mata_pelajaran) {
    // Hitung jumlah pengajuan yang memerlukan konfirmasi untuk guru pengajar
    $pengajuanPengajar = Dispensasi::join('konfirmasi', 'dispensasi.id_dispen', '=', 'konfirmasi.id_dispen')
        ->where('dispensasi.nip', $nip)
        ->whereNull('konfirmasi.konfirmasi_1')  // Belum terkonfirmasi oleh guru pengajar
        ->whereNull('konfirmasi.konfirmasi_2')  // Belum terkonfirmasi oleh pihak lain
        ->count();
}

if ($guru->jabatan == 'kurikulum') {
    // Hitung jumlah pengajuan yang memerlukan konfirmasi untuk kurikulum
    $pengajuanKurikulum = Konfirmasi::whereNull('konfirmasi.konfirmasi_2') // Belum terkonfirmasi oleh kurikulum
        ->whereNull('konfirmasi.konfirmasi_3') // Belum terkonfirmasi oleh pihak lain
        ->count(); 
}


$pengajuanDispen = Dispensasi::where('status', 'pending')->count(); // Asumsi status "pending" untuk dispensasi yang belum diproses

$notifications = Auth::user()->notifications ?? []; // Notifikasi default
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>dashboard guru</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" type="text/css">
  <script>
    function navigateTo(page) {
      alert(`Navigasi ke halaman: ${page}`);
    }
  </script>
</head>

<body>
  <header>
    <div class="logo">
      <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="Logo">
      <div class="text-container">
        <h2>DISPENSASI DIGITAL SMK NEGERI 1 KAWALI</h2>
        <p class="sub-title">{{ $guru->nama }}</p>
      </div>
    </div>
    <!-- Form logout -->
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
      @csrf
      <button type="submit" class="logout">Logout</button>
    </form>
  </header>

  @if (!empty($notifications)) <!-- Check if notifications are not empty -->
  @foreach ($notifications as $notification)
  <div>
    <p>{{ $notification->data['nama_siswa'] }} mengajukan dispensasi.</p>
    <p>Kategori: {{ $notification->data['kategori'] }}</p>
    <p>Waktu Keluar: {{ $notification->data['waktu_keluar'] }}</p>
  </div>
  @endforeach
  @else
  <p>Tidak ada notifikasi untuk saat ini.</p> <!-- Default message when no notifications -->
  @endif

  <div class="semi-circle"></div>

  <div class="main-container">
  <div class="menu">
    <!-- Konfirmasi Guru Piket -->
    @if ($pengajuanPiket > 0 && $guru->jabatan == 'piket')
    <div class="menu-item" data-bs-toggle="tooltip" title="Lihat konfirmasi guru piket" onclick="window.location.href='{{ route('konfirGuruPiket') }}';">
        <i class="fas fa-user-graduate"></i>
        <span>Konfirmasi Guru Piket</span>
        <span class="badge bg-danger">{{ $pengajuanPiket }}</span>
    </div>
    @endif

    <!-- Konfirmasi Guru Pengajar -->
    @if ($pengajuanPengajar > 0 && $guru->mata_pelajaran)
    <div class="menu-item" data-bs-toggle="tooltip" title="Lihat konfirmasi guru pengajar" onclick="window.location.href='{{ route('konfirGuruMataPelajaran') }}';">
        <i class="fas fa-chalkboard-teacher"></i>
        <span>Konfirmasi Guru Pengajar</span>
        <span class="badge bg-danger">{{ $pengajuanPengajar }}</span>
    </div>
    @endif

    <!-- Konfirmasi Kurikulum -->
    @if ($pengajuanKurikulum > 0 && $guru->jabatan == 'kurikulum')
    <div class="menu-item" data-bs-toggle="tooltip" title="Lihat konfirmasi kurikulum" onclick="window.location.href='{{ route('konfirGuruKurikulum') }}';">
        <i class="fas fa-chalkboard-teacher"></i>
        <span>Konfirmasi Kurikulum</span>
        <span class="badge bg-danger">{{ $pengajuanKurikulum }}</span>
    </div>
    @endif
      
      <div class="menu-item" data-bs-toggle="tooltip" title="Lihat jadwal piket" onclick="navigateTo('jadwal_piket')">
        <i class="fas fa-calendar-check"></i>
        <span>Jadwal Piket</span>
      </div>
      <div class="menu-item" data-bs-toggle="tooltip" title="Lihat history dispensasi" onclick="navigateTo('history_dispen')">
        <i class="fas fa-file-alt"></i>
        <span>History Dispen</span>
      </div>
    </div>
      
    <!-- Notifikasi dan Statistik -->
    <div class="d-flex">
      <div class="notification-card">
        <h4>Notifikasi Pengajuan Dispensasi</h4>
        @if ($pengajuanDispen > 0)
        <div class="alert alert-info d-flex justify-content-between align-items-center">
          <div>
            <p><strong>{{ $pengajuanDispen }} Pengajuan Dispensasi Baru</strong></p>
          </div>
          <div>
            <button class="btn btn-success btn-sm" onclick="">
              Lihat Detail
            </button>
          </div>
        </div>
        @else
        <p>Tidak ada pengajuan dispensasi baru.</p>
        @endif
      </div>
      <div class="stats-card">
        <h3>Statistik Pengguna</h3>
        <p class="stat">450</p>
        <p>Siswa Terdaftar</p>
        <p class="stat">38</p>
        <p>Guru Aktif</p>
      </div>
    </div>

    <div class="info-cards">
      <div class="info-card">
        <h3>Data Siswa & Data Guru</h3>
        <div class="divider"></div>
        <p>Data ini dibutuhkan untuk login baik itu guru maupun siswa.</p>
        <p>Username guru menggunakan NIP</p>
        <p>Username siswa menggunakan nip</p>
        <p>Dengan password masing-masing</p>
      </div>

      <div class="info-card">
        <h3>Jadwal Piket Guru</h3>
        <div class="divider"></div>
        <p>Ini digunakan untuk mengetahui siapa saja guru yang bertugas melakukan piket sekolah.</p>
      </div>

      <div class="info-card">
        <h3>History Dispen Siswa</h3>
        <div class="divider"></div>
        <p>Kumpulan data siswa yang telah melakukan dispen dalam 1 tahun.</p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  </script>
</body>

</html>
