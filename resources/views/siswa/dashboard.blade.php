<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dispensasi Digital SMK NEGERI 1 KAWALI</title>
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
          <div>
              <h2>DISPENSASI DIGITAL SMK NEGERI 1 KAWALI</h2>
              <p style="font-size: 16px;font-weight: 400;">Siswa</p>
          </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" class="logout">Logout</button>
        </form>
    </header>

    <div class="semi-circle"></div>

    <div class="main-container">
    <div class="menu">
  <div class="menu-item" data-bs-toggle="tooltip" title="Lihat akun siswa" onclick="navigateTo('akun_siswa')">
    <i class="fas fa-file-alt"></i>
    <span>Formulir</span>
  </div>
  <div class="menu-item" data-bs-toggle="tooltip" title="Lihat akun guru" onclick="navigateTo('akun_guru')">
    <i class="fas fa-check-circle"></i>
    <span>Konfirmasi</span>
  </div>
  <div class="menu-item" data-bs-toggle="tooltip" title="Lihat jadwal piket" onclick="navigateTo('jadwal_piket')">
    <i class="fas fa-file-pdf"></i>
    <span>Unduh PDF</span>
  </div>
  <div class="menu-item" data-bs-toggle="tooltip" title="Lihat history dispensasi" onclick="navigateTo('history_dispen')">
    <i class="fas fa-camera"></i>
    <span>Siswa Kembali</span>
  </div>
</div>


        <!-- Notifikasi dan Statistik -->
        <div class="d-flex">
          <div class="notification-card">
            <h4>Notifikasi Penting</h4>
            <p>Jadwal piket hari ini sudah diperbarui. Silakan cek informasi terbaru.</p>
            <button class="btn btn-warning" onclick="navigateTo('jadwal_piket')">Lihat Jadwal</button>
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
            <p>Username siswa menggunakan NIS</p>
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
      const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    </script>
</body>
</html>
