<?php

use App\Models\AkunGuru;
use App\Models\AkunSiswa;
use App\Models\Dispensasi;
use App\Models\Konfirmasi;
use App\Models\PiketGuru;
use Illuminate\Support\Facades\Auth;

// Ambil NIS siswa yang login
$nis = Auth::user()->nis;

// Ambil data siswa berdasarkan NIS
$siswa = AkunSiswa::where('nis', $nis)->first();

// Ambil dispensasi terbaru berdasarkan NIS
$latestDispensasi = Dispensasi::where('nis', $nis)
    ->latest('id_dispen')
    ->first();

// Cek apakah ada konfirmasi terkait dispensasi terbaru
$konfir = null;
if ($latestDispensasi) {
    $konfir = Konfirmasi::where('id_dispen', $latestDispensasi->id_dispen)
        ->first();
}

// Periksa kondisi untuk tombol "Siswa Kembali"
$canAccessSiswaKembali = false; // Default tidak bisa diakses
if (
    $latestDispensasi &&
    $latestDispensasi->kategori === 'keluar lingkungan sekolah' &&
    $latestDispensasi->bukti_foto === null &&
    $konfir &&
    $konfir->konfirmasi_1 !== null &&
    $konfir->konfirmasi_2 === null
) {
    $canAccessSiswaKembali = true; // Jika semua kondisi terpenuhi, bisa diakses
}

// Redirect jika siswa tidak ditemukan
if (!$siswa) {
    return redirect()->route('login')->withErrors(['error' => 'Siswa tidak ditemukan.']);
}

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
    <title>Dispensasi Siswa SMK NEGERI 1 KAWALI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="{{ asset('css/siswa_dashboard.css') }}" rel="stylesheet" type="text/css">

    <script>
        // Lokasi sekolah (latitude dan longitude)
        const schoolLocation = {
            latitude: -7.186491, // Ganti dengan koordinat latitude sekolah
            longitude: 108.362271 // Ganti dengan koordinat longitude sekolah
        };

        // Fungsi untuk menghitung jarak menggunakan Haversine Formula
        function getDistanceFromLatLonInMeters(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // Radius bumi dalam meter
            const φ1 = lat1 * Math.PI / 180;
            const φ2 = lat2 * Math.PI / 180;
            const Δφ = (lat2 - lat1) * Math.PI / 180;
            const Δλ = (lon2 - lon1) * Math.PI / 180;

            const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return R * c; // Jarak dalam meter
        }

        document.addEventListener('DOMContentLoaded', () => {
            const siswaKembaliButton = document.getElementById('siswaKembaliButton');

            if (siswaKembaliButton) {
                // Periksa lokasi pengguna
                function checkLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(position => {
                            const userLatitude = position.coords.latitude;
                            const userLongitude = position.coords.longitude;

                            // Hitung jarak pengguna ke lokasi sekolah
                            const distance = getDistanceFromLatLonInMeters(
                                userLatitude,
                                userLongitude,
                                schoolLocation.latitude,
                                schoolLocation.longitude
                            );

                            // Jika jarak lebih dari 500 meter, nonaktifkan tombol
                            if (distance > 500) {
                                siswaKembaliButton.onclick = () => alert('Anda berada di luar lokasi sekolah. Fitur ini tidak dapat diakses.');
                                siswaKembaliButton.classList.add('disabled'); // Tambahkan class disabled (jika ada style tambahan)
                            } else {
                                // Jika di dalam lokasi, arahkan ke halaman
                                siswaKembaliButton.onclick = () => {
                                    window.location.href = siswaKembaliButton.dataset.url;
                                };
                            }
                        }, error => {
                            alert('Gagal mendapatkan lokasi. Harap izinkan akses lokasi pada browser Anda.');
                        });
                    } else {
                        alert('Browser Anda tidak mendukung fitur lokasi.');
                    }
                }

                // Jalankan pemeriksaan lokasi saat halaman dimuat
                checkLocation();
            }
        });


        // Aktifkan kamera
        function activateCamera() {
            const video = document.getElementById('camera');
            const preview = document.getElementById('preview');
            const captureButton = document.getElementById('captureButton');
            const photoInput = document.getElementById('photoInput');
            const submitPhotoButton = document.getElementById('submitPhotoButton');

            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    video.srcObject = stream;
                })
                .catch(error => {
                    console.error('Error accessing camera: ', error);
                });

            // Ambil foto
            captureButton.addEventListener('click', () => {
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Convert canvas ke file data URL
                const dataUrl = canvas.toDataURL('image/jpeg');

                // Tampilkan preview gambar
                preview.src = dataUrl;
                preview.style.display = 'block';

                // Convert data URL ke file dan masukkan ke input file
                fetch(dataUrl)
                    .then(res => res.blob())
                    .then(blob => {
                        const file = new File([blob], 'photo.jpg', {
                            type: 'image/jpeg'
                        });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        photoInput.files = dataTransfer.files;

                        // Tampilkan tombol unggah
                        submitPhotoButton.style.display = 'block';
                    });
            });
        }

        // Jalankan pemeriksaan lokasi saat halaman dimuat
        window.onload = checkLocation;
    </script>
    <!-- <style>
    .menu-item.disabled {
        pointer-events: none; /* Nonaktifkan klik */
        opacity: 0.5; /* Tampak pudar */
        cursor: not-allowed; /* Ubah kursor */
    }
</style> -->

</head>

<body>
    <header>
        <div class="logo">
            <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="Logo">
            <div class="text-container">
                <h2>DISPENSASI SISWA SMK NEGERI 1 KAWALI</h2>
                <p class="sub-title">{{ $siswa->nama }}</p>
            </div>
        </div>
        <!-- Form logout -->
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    </header>

    @if ($errors->any())
    <div id="popupAlert" class="alert alert-danger"
        style="z-index: 9999; margin-top: 105px; margin-bottom: -400px; opacity: 1; transition: opacity 0.5s ease-in-out;">
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                const alert = document.getElementById("popupAlert");
                if (alert) {
                    alert.style.opacity = '0'; // Mulai transisi opacity
                    setTimeout(() => {
                        if (alert) alert.remove(); // Hapus setelah transisi selesai
                    }, 500); // 500ms = durasi transisi CSS
                }
            }, 4000); // Tampil selama 4 detik sebelum menghilang
        });
    </script>

    <div class="semi-circle"></div>

    <div class="main-container">
        <div class="menu">
            <div class="menu-item" data-bs-toggle="tooltip" title="Lihat formulir dispen" onclick="window.location.href='{{ route('dispensasi.index') }}';">
                <i class="fas fa-file-alt"></i>
                <span>Formulir</span>
            </div>
            <div class="menu-item" data-bs-toggle="tooltip" title="Lihat konfirmasi" onclick="window.location.href='{{ route('konfirm.index') }}';">
                <i class="fas fa-check-circle"></i>
                <span>Konfirmasi</span>
            </div>
            <div class="menu-item"
                data-bs-toggle="tooltip"
                title="{{ $konfir && $konfir->konfirmasi_3 ? 'Unduh hasil dispen' : 'Tidak dapat diunduh sebelum semua konfirmasi selesai' }}"
                onclick="{{ $konfir && $konfir->konfirmasi_3 ? 'confirmDownload()' : '' }}"
                style="{{ $konfir && $konfir->konfirmasi_3 ? '' : 'pointer-events: none; opacity: 0.5;' }}">
                <i class="fas fa-file-pdf"></i>
                <span>Unduh Dispensasi</span>
            </div>

            <script>
                function confirmDownload() {
                    let confirmation = confirm("Apakah Anda yakin ingin mengunduh PDF dispensasi?");
                    if (confirmation) {
                        alert("PDF akan segera diunduh...");
                        window.location.href = "{{ route('dispensasi.pdfDownload') }}";
                    }
                }
            </script>
            @if ($latestDispensasi && $latestDispensasi->kategori === 'keluar lingkungan sekolah')
            <div class="menu-item"
                id="siswaKembaliButton"
                data-url="{{ $canAccessSiswaKembali ? route('dispensasi.camera', ['nis' => $siswa->nis]) : '#' }}"
                style="{{ $canAccessSiswaKembali ? '' : 'pointer-events: none; opacity: 0.5;' }}">
                <i class="fas fa-camera"></i>
                <span>Siswa Kembali</span>
            </div>
            @endif
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const siswaKembaliButton = document.getElementById('siswaKembaliButton');
                    if (siswaKembaliButton && siswaKembaliButton.style.pointerEvents === 'none') {
                        siswaKembaliButton.onclick = () => alert('Anda tidak dapat mengakses fitur ini. Pastikan semua persyaratan terpenuhi.');
                    }
                });
            </script>
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
</body>

</html>