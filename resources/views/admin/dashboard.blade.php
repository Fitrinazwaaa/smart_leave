<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dispensasi Digital SMK N 1 Kawali</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="{{ asset('css/admin/dashboard.css') }}" rel="stylesheet" type="text/css">
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
    <!-- Form logout -->
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
      @csrf
      <button type="submit" class="logout">Logout</button>
    </form>
  </header>
  <div class="semi-circle"></div>
  <div class="main-container">
    <div class="menu">
      <div class="menu-item" data-bs-toggle="tooltip" title="Lihat data siswa" onclick="window.location.href='{{ route('kelasSiswa') }}';">
        <i class="fas fa-user-graduate"></i>
        <span>Data Siswa</span>
      </div>
      <div class="menu-item" data-bs-toggle="tooltip" title="Lihat data guru" onclick="window.location.href='{{ route('admin.guru.index') }}';">
        <i class="fas fa-chalkboard-teacher"></i>
        <span>Data Guru</span>
      </div>
      <div class="menu-item" data-bs-toggle="tooltip" title="Lihat history dispensasi" onclick="navigateTo('history_dispen')">
        <i class="fas fa-file-alt"></i>
        <span>History Dispen</span>
      </div>
      <div class="menu-item" data-bs-toggle="tooltip" title="Lihat data siswa" onclick="window.location.href='';">
        <!-- Menggunakan ikon pengaturan untuk menunjukkan admin -->
        <i class="fas fa-cogs"></i>
        <span>Akun Admin</span>
      </div>
    </div>
    <!-- Notifikasi dan Statistik -->
    <div class="d-flex">
      <div class="notification-card">
        <div class="accordion">
          <div class="accordion-content">
            <h3 style="font-weight: bold;">Jadwal Piket Guru</h3>
            <table>
              <thead>
                <tr>
                  <th>Senin</th>
                  <th>Selasa</th>
                  <th>Rabu</th>
                  <th>Kamis</th>
                  <th>Jumat</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>a</td>
                  <td>b</td>
                  <td>c</td>
                  <td>d</td>
                  <td>e</td>
                </tr>
                <tr>
                  <td>f</td>
                  <td>g</td>
                  <td>h</td>
                  <td>i</td>
                  <td>j</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
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
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  </script>
<!-- Bootstrap 5 JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybOveo3f8VgJUvP5Vyn6pd56rOH1diJfqa0ksL8/4Oh3nybs0" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0uW9YrkQ+Q+97Jmf6fF3j1vSxtIhQczb1Y88aV6YQw0W6qHm" crossorigin="anonymous"></script>
</body>

</html>