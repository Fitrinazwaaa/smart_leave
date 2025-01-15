<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dispensasi Digital SMK N 1 Kawali</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #ffffff;
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
      top: -400px;
      width: 915px;
      height: 611px;
      margin: 32px auto 64px;
      background-color: rgba(3, 2, 72, 0.9);
      border-radius: 457.5px / 305.5px;
      z-index: -9;
    }

    .main-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 16px;
      padding-top: 80px; /* Offset for fixed navbar */
    }

    .menu {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(90px, 1fr));
      gap: 32px;
      justify-content: center;
      align-items: center;
      margin-top: 50px;
    }

    .menu-item {
      width: 90px;
      height: 90px;
      background-color: rgba(255, 255, 255, 0.8);
      border: 3px solid #ffe900;
      border-radius: 8px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      transition: box-shadow 0.2s ease, transform 0.2s ease;
    }

    .menu-item .menu_tombol {
      all: unset;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 100%;
      height: 100%;
      border-radius: inherit;
      cursor: pointer;
    }

    .menu-item .menu_tombol:hover {
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
      transform: scale(1.05);
    }

    .menu-item .menu_tombol:active {
      transform: scale(1.1);
    }

    .menu-item i {
      font-size: 40px;
      margin-bottom: 8px;
    }

    .info-cards {
      display: flex;
      justify-content: space-between;
      gap: 32px;
      margin-top: 50px;
    }

    .info-card {
      width: 324px;
      background-color: rgba(3, 2, 72, 0.9);
      color: white;
      padding: 24px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: center;
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
        <h3>DISPENSASI DIGITAL SMK N 1 KAWALI</h3>
        <p style="font-size: 14px; margin-top: -12px">Fitri Najwa Fatimatu Jahro</p>
      </div>
    </div>
    <button class="logout" onclick="navigateTo('logout')">Keluar</button>
  </header>
<div class="semi-circle"></div>
  <div class="main-container">
    <div class="menu">
      <div class="menu-item">
        <div class="menu_tombol" onclick="navigateTo('akun_siswa')">
          <i class="fas fa-file-alt"></i>
          Akun Siswa
        </div>
      </div>
      <div class="menu-item">
        <div class="menu_tombol" onclick="navigateTo('akun_guru')">
          <i class="fas fa-users"></i>
          Akun Guru
        </div>
      </div>
      <div class="menu-item">
        <div class="menu_tombol" onclick="navigateTo('jadwal_piket')">
          <i class="fas fa-calendar-alt"></i>
          Jadwal Piket
        </div>
      </div>
      <div class="menu-item">
        <div class="menu_tombol" onclick="navigateTo('history_dispen')">
          <i class="fas fa-camera"></i>
          History Dispen
        </div>
      </div>
    </div>

    <div class="info-cards">
      <div class="info-card">
        <h3>Data Siswa & Data Guru</h3>
        <div class="divider"></div>
        <p>Data ini dibutuhkan untuk login baik itu guru maupun siswa.</p>
        <p>Username guru menggunakan NIP</p>
        <p>Username siswa menggunakan nis</p>
        <p>Dengan password nya masing masing</p>
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
</body>
</html>
