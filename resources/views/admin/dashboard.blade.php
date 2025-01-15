<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dispensasi Digital SMK N 1 Kawali</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom, #ffffff 70%, #030248);
      min-height: 100vh;
    }

    header {
      position: fixed;
      width: 100%;
      top: 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 6px;
      background-color: #030248;
      color: white;
      z-index: 1000;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    header .logo {
      margin-left: 40px;
      display: flex;
      align-items: center;
      gap: 16px;
    }

    header .logo img {
      width: 62px;
      height: 62px;
    }
    
    header h2{
      margin-top: 15px;
      margin-bottom: -1px;
      font-size: 23px;
      font-weight: bold;
    }

    header .logout {
      margin-right: 40px;
      background-color: #d32f2f;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 4px;
      cursor: pointer;
    }

    .semi-circle {
      width: 915px;
      height: 611px;
      margin: -290px auto 64px;
      background-color: rgba(3, 2, 72, 0.9);
      border-radius: 457.5px / 305.5px;
      z-index: -9;
    }

    .main-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 16px;
      padding-top: 80px; /* Offset untuk navbar yang tetap */
    }

    .menu {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: -330px;
    }

    .menu-item {
      width: 110px;
      height: 110px;
      background-color: rgba(255, 255, 255, 0.9);
      border: 3px solid #ffe900;
      border-radius: 10px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }

    .menu-item:hover {
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      transform: scale(1.1);
      background-color: #ffe900;
    }

    .menu-item i {
      font-size: 48px;
      margin-bottom: 8px;
      color: #030248;
      transition: color 0.3s ease;
    }

    .menu-item:hover i {
      color: black; /* Ubah warna ikon menjadi hitam saat dihover */
    }

    .menu-item span {
      margin-top: 8px;
      color: #030248;
      transition: color 0.3s ease;
    }

    .menu-item:hover span {
      color: black; /* Ubah warna teks menjadi hitam saat dihover */
    }

    /* Notifikasi dan Statistik */
    .d-flex {
    margin-top: 100px;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 32px;
    }

    .notification-card,
    .stats-card {
      padding: 24px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: center;
      flex: 1 1 45%;
      max-width: 45%;
    }

    /* Notifikasi Card */
    .notification-card {
      background-color: #ffeb3b;
      color: #030248;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .notification-card h4 {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 12px;
    }

    .notification-card p {
      font-size: 14px;
      margin-bottom: 16px;
    }

    .notification-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    /* Statistik Card */
    .stats-card {
      background-color: rgba(3, 2, 72, 0.9);
      color: white;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stats-card h3 {
      font-size: 20px;
      margin-bottom: 12px;
    }

    .stats-card .stat {
      font-size: 30px;
      font-weight: bold;
      margin-bottom: 8px;
    }

    .stats-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    .info-cards {
      display: flex;
      justify-content: space-between;
      gap: 32px;
      margin-top: 50px;
      margin-bottom: 60px;
    }

    .info-card {
      width: 324px;
      background-color: rgba(3, 2, 72, 0.9);
      color: white;
      padding: 24px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .info-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    .info-card h3 {
      margin-bottom: 16px;
      font-size: 18px;
      font-weight: bold;
    }

    .info-card .divider {
      width: 60%;
      height: 1px;
      background-color: white;
      margin: 0 auto 16px;
    }

    .info-card p {
      margin: 0 0 8px;
      font-size: 14px;
      text-align: left;
    }
  </style>
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
            <h2>DISPENSASI DIGITAL SMK N 1 KAWALI</h2>
            <p style="font-size: 16px;font-weight: 400;">Kurikulum</p>
        </div>
        </div>
        <button class="logout" onclick="navigateTo('logout')">Keluar</button>
    </header>

    <div class="semi-circle"></div>

    <div class="main-container">
        <div class="menu">
          <div class="menu-item" data-bs-toggle="tooltip" title="Lihat akun siswa" onclick="navigateTo('akun_siswa')">
            <i class="fas fa-user-graduate"></i>
            <span>Akun Siswa</span>
          </div>
          <div class="menu-item" data-bs-toggle="tooltip" title="Lihat akun guru" onclick="navigateTo('akun_guru')">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Akun Guru</span>
          </div>
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
