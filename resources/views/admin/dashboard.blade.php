<?php

use App\Models\PiketGuru;
use App\Models\AkunSiswa;
use App\Models\AkunGuru;
use App\Models\Dispensasi;

$piketGuru = PiketGuru::all();
$totalSiswa = AkunSiswa::count(); // Hitung jumlah siswa
$totalGuru = AkunGuru::count(); // Hitung jumlah guru

// Menghitung jumlah dispensasi berdasarkan kategori
$jumlahKeluarLingkungan = Dispensasi::where('kategori', 'Keluar Lingkungan Sekolah')->count();
$jumlahMengikutiKegiatan = Dispensasi::where('kategori', 'Mengikuti Kegiatan')->count();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispensasi Digital SMK NEGERI 1 KAWALI</title>
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
            <div class="text-container">
                <h2>DISPENSASI DIGITAL SMK NEGERI 1 KAWALI</h2>
                <p class="sub-title">Kurikulum</p>
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
            <div class="menu-item" data-bs-toggle="tooltip" title="Lihat data guru" onclick="window.location.href='{{ route('admin.piket') }}';">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Guru Piket</span>
            </div>
            <div class="menu-item" data-bs-toggle="tooltip" title="Lihat history dispensasi" onclick="window.location.href='{{ route('historyAdmin') }}';">
                <i class="fas fa-file-alt"></i>
                <span>History Dispen</span>
            </div>
            <div class="menu-item" data-bs-toggle="tooltip" title="Lihat data siswa"
                onclick="window.location.href='{{ route('akun-kurikulum.index') }}';">
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
                        <h3 style="font-weight: bold;">Pekan Gajil</h3>
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
                                @php
                                $maxRows = max(
                                $piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Senin')->count(),
                                $piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Selasa')->count(),
                                $piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Rabu')->count(),
                                $piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Kamis')->count(),
                                $piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Jumat')->count(),
                                );
                                @endphp

                                @for ($i = 0; $i < $maxRows; $i++)
                                    <tr>
                                    <td>{{ optional($piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Senin')->values()->get($i))->nama ?? '' }}</td>
                                    <td>{{ optional($piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Selasa')->values()->get($i))->nama ?? '' }}</td>
                                    <td>{{ optional($piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Rabu')->values()->get($i))->nama ?? '' }}</td>
                                    <td>{{ optional($piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Kamis')->values()->get($i))->nama ?? '' }}</td>
                                    <td>{{ optional($piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Jumat')->values()->get($i))->nama ?? '' }}</td>
                                    </tr>
                                    @endfor
                            </tbody>
                        </table>
                    </div>
                    <div class="accordion-content" style="margin-top: 15px;">
                        <h3 style="font-weight: bold;">Pekan Genap</h3>
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
                                @php
                                $maxRows = max(
                                $piketGuru->where('pekan', 'genap')->where('hari_piket', 'Senin')->count(),
                                $piketGuru->where('pekan', 'genap')->where('hari_piket', 'Selasa')->count(),
                                $piketGuru->where('pekan', 'genap')->where('hari_piket', 'Rabu')->count(),
                                $piketGuru->where('pekan', 'genap')->where('hari_piket', 'Kamis')->count(),
                                $piketGuru->where('pekan', 'genap')->where('hari_piket', 'Jumat')->count(),
                                );
                                @endphp

                                @for ($i = 0; $i < $maxRows; $i++)
                                    <tr>
                                    <td>{{ optional($piketGuru->where('pekan', 'genap')->where('hari_piket', 'Senin')->values()->get($i))->nama ?? '' }}</td>
                                    <td>{{ optional($piketGuru->where('pekan', 'genap')->where('hari_piket', 'Selasa')->values()->get($i))->nama ?? '' }}</td>
                                    <td>{{ optional($piketGuru->where('pekan', 'genap')->where('hari_piket', 'Rabu')->values()->get($i))->nama ?? '' }}</td>
                                    <td>{{ optional($piketGuru->where('pekan', 'genap')->where('hari_piket', 'Kamis')->values()->get($i))->nama ?? '' }}</td>
                                    <td>{{ optional($piketGuru->where('pekan', 'genap')->where('hari_piket', 'Jumat')->values()->get($i))->nama ?? '' }}</td>
                                    </tr>
                                    @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex">
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
                <script>
                    // Menampilkan data ke elemen HTML
                    document.getElementById('stat-keluar-lingkungan').textContent = "<?php echo $jumlahKeluarLingkungan; ?>";
                    document.getElementById('stat-mengikuti-kegiatan').textContent = "<?php echo $jumlahMengikutiKegiatan; ?>";
                </script>
                <div class="stats-card" style="margin-top: -20px;">
                    <h3>Statistik Pengguna</h3>
                    <p class="stat">{{ $totalSiswa }}</p>
                    <p>Siswa Terdaftar</p>
                    <p class="stat">{{ $totalGuru }}</p>
                    <p>Guru Aktif</p>
                </div>
            </div>
        </div>
        <div class="info-cards">
            <div class="info-card">
                <h3>Data Siswa & Data Guru</h3>
                <div class="divider"></div>
                <p style="text-align: center;">Data ini dibutuhkan untuk login baik itu guru maupun siswa.</p>
                <p style="text-align: center;">Username guru menggunakan NIP</p>
                <p style="text-align: center;">Username siswa menggunakan NIS</p>
                <p style="text-align: center;">Dengan password masing-masing</p>
            </div>
            <div class="info-card">
                <h3>Jadwal Piket Guru</h3>
                <div class="divider"></div>
                <p style="text-align: center;">Ini digunakan untuk mengetahui siapa saja guru yang bertugas melakukan piket sekolah.</p>
            </div>
            <div class="info-card">
                <h3>History Dispen Siswa</h3>
                <div class="divider"></div>
                <p style="text-align: center;">Kumpulan data siswa yang telah melakukan dispen dalam 1 tahun.</p>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9gybOveo3f8VgJUvP5Vyn6pd56rOH1diJfqa0ksL8/4Oh3nybs0" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-pzjw8f+ua7Kw1TIq0uW9YrkQ+Q+97Jmf6fF3j1vSxtIhQczb1Y88aV6YQw0W6qHm" crossorigin="anonymous">
    </script>
</body>

</html>