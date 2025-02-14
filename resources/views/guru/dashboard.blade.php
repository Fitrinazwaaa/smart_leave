<?php

use App\Models\AkunGuru;
use App\Models\Dispensasi;
use App\Models\Konfirmasi;
use App\Models\PiketGuru;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Atur locale Carbon ke Bahasa Indonesia
Carbon::setLocale('id');
$nip = Auth::user()->nip;  // Mendapatkan nip dari user yang sedang login
// Ambil hari saat ini dalam format Bahasa Indonesia
$hariIni = Carbon::now()->translatedFormat('l');
// Cek apakah guru yang login sedang memiliki jadwal piket
$jadwalPiket = PiketGuru::where('nip', $nip)
  ->where('hari_piket', $hariIni)
  ->where('aktif', 1)  // Pastikan hanya yang aktif yang dipilih
  ->first();  // Ambil data pertama yang ditemukan

// Ambil data dispensasi yang harus dikonfirmasi oleh guru mata pelajaran yang sesuai dengan NIP guru yang login
$dispen = Dispensasi::whereHas('konfirmasi', function ($query) {
  $query->whereNotNull('konfirmasi_1')->whereNull('konfirmasi_2');
})->where('nip', $nip) // Tambahkan filter NIP sesuai dengan guru yang login
  ->get();

// Ambil data guru
$guru = AkunGuru::where('nip', $nip)->first();
// Ambil data pengguna dari tabel akun_guru berdasarkan NIP
$akunGuru = DB::table('akun_guru')->where('nip', $nip)->first();

if (!$guru) {
  // Jika guru tidak ditemukan, tampilkan error atau redirect
  return redirect()->route('login')->withErrors(['error' => 'Guru tidak ditemukan.']);
}

// Menghitung pengajuan dispensasi dengan pengecekan konfirmasi_1, konfirmasi_2, dan konfirmasi_3
$pengajuanDispenKonfirmasi1Null = Konfirmasi::whereNull('konfirmasi_1')->count();

// Menghitung pengajuan dispensasi dengan pengecekan konfirmasi_2, hanya jika konfirmasi_1 tidak null
$pengajuanDispenKonfirmasi2Null = Konfirmasi::where('kategori', 'mengikuti kegiatan')
    ->whereNotNull('konfirmasi_1')
    ->whereNull('konfirmasi_2')
    ->whereHas('dispensasi', function ($query) use ($nip) {
        $query->where('nip', $nip); // Filter berdasarkan nip dari tabel dispensasi
    })
    ->count();
// Menghitung pengajuan dispensasi dengan pengecekan konfirmasi_3, hanya jika konfirmasi_1 dan konfirmasi_2 tidak null
$pengajuanDispenKonfirmasi3Null = Konfirmasi::whereNotNull('konfirmasi_1')->whereNotNull('konfirmasi_2')->whereNull('konfirmasi_3')->count();

// Mengambil notifikasi pengguna
$notifications = Auth::user()->notifications ?? []; // Ensure to provide a default empty array if null

// Cek apakah tombol konfirmasi guru piket perlu ditampilkan
$tampilkanKonfirmasiPiket = false;
if ($jadwalPiket) {
  $tampilkanKonfirmasiPiket = true;  // Tombol konfirmasi hanya akan tampil jika jadwal piket ada
}

// Cek apakah jabatan pengguna adalah 'kurikulum'
$isKurikulum = $akunGuru && $akunGuru->jabatan === 'kurikulum'; // Verifikasi jabatan kurikulum
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
      @if ($tampilkanKonfirmasiPiket) <!-- Check if the button should be displayed -->
      <div class="menu-item" data-bs-toggle="tooltip" title="Lihat konfirmasi guru piket" onclick="window.location.href='{{ route('konfirGuruPiket') }}';">
        <i class="fas fa-user-graduate"></i>
        <span>Konfirmasi Guru Piket</span>
        @if ($pengajuanDispenKonfirmasi1Null > 0)
        <span class="badge bg-danger">{{ $pengajuanDispenKonfirmasi1Null }}</span>
        @endif
      </div>
      @endif

      @if ($dispen->isNotEmpty()) <!-- Check if there are dispensations that need confirmation -->
      <div class="menu-item" data-bs-toggle="tooltip" title="Lihat konfirmasi guru pengajar"  onclick="window.location.href='{{ route('konfirGuruMataPelajaran') }}';">
        <i class="fas fa-chalkboard-teacher"></i>
        <span>Konfirmasi Guru Pengajar</span>
        @if ($pengajuanDispenKonfirmasi2Null > 0)
        <span class="badge bg-danger">{{ $pengajuanDispenKonfirmasi2Null }}</span>
        @endif
      </div>
      @endif

      @if ($isKurikulum) <!-- Check if user has the 'kurikulum' role -->
      <div class="menu-item" data-bs-toggle="tooltip" title="Lihat konfirmasi kurikulum" onclick="window.location.href='{{ route('konfirGuruKurikulum') }}';">
        <i class="fas fa-chalkboard-teacher"></i>
        <span>Konfirmasi Kurikulum</span>
        @if ($pengajuanDispenKonfirmasi3Null > 0)
        <span class="badge bg-danger">{{ $pengajuanDispenKonfirmasi3Null }}</span>
        @endif
      </div>
      @endif

      <div class="menu-item" data-bs-toggle="tooltip" title="Lihat jadwal piket" onclick="window.location.href='{{ route('jadwal_piket') }}';">
        <i class="fas fa-calendar-check"></i>
        <span>Jadwal Piket</span>
      </div>
      <div class="menu-item" data-bs-toggle="tooltip" title="Lihat history dispensasi" onclick="window.location.href='{{ route('historyGuru') }}';">
        <i class="fas fa-file-alt"></i>
        <span>History Dispen</span>
      </div>
    </div>

    <!-- Notifikasi dan Statistik -->
    <div class="d-flex">
      <div class="notification-card">
        <h4>Notifikasi Pengajuan Dispensasi</h4>
        @if ($pengajuanDispenKonfirmasi1Null > 0 || $pengajuanDispenKonfirmasi2Null > 0 || $pengajuanDispenKonfirmasi3Null > 0)
        <div class="alert alert-info d-flex justify-content-between align-items-center">
          <div>
            <p><strong>{{ $pengajuanDispenKonfirmasi1Null + $pengajuanDispenKonfirmasi2Null + $pengajuanDispenKonfirmasi3Null }} Pengajuan Dispensasi Baru</strong></p>
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
        <h3>Statistik Dispensasi Siswa</h3>
        <div class="stat-item">
          <p class="stat" id="stat-keluar-lingkungan">0</p>
          <p>Keluar Lingkungan Sekolah</p>
        </div>
        <div class="stat-item">
          <p class="stat" id="stat-mengikuti-kegiatan">0</p>
          <p>Mengikuti Kegiatan</p>
        </div>
      </div>

      <?php
      // Menghitung jumlah dispensasi berdasarkan kategori
      $jumlahKeluarLingkungan = Dispensasi::where('kategori', 'Keluar Lingkungan Sekolah')->count();
      $jumlahMengikutiKegiatan = Dispensasi::where('kategori', 'Mengikuti Kegiatan')->count();
      ?>

      <script>
        // Menampilkan data ke elemen HTML
        document.getElementById('stat-keluar-lingkungan').textContent = "<?php echo $jumlahKeluarLingkungan; ?>";
        document.getElementById('stat-mengikuti-kegiatan').textContent = "<?php echo $jumlahMengikutiKegiatan; ?>";
      </script>

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