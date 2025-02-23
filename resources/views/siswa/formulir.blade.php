<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Dispensasi - SMK NEGERI 1 KAWALI</title>
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
            background-attachment: fixed;
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

        main {
            max-width: 1000px;
            /* Membatasi lebar konten */
            margin: 130px auto 30px;
            /* Menambahkan margin atas yang lebih besar dari header */
            padding: 30px;
            /* Padding di dalam kontainer */
            background-color: #ffffff;
            /* Warna latar belakang putih */
            border-radius: 12px;
            /* Sudut melengkung untuk estetika */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            /* Shadow lebih lembut dan profesional */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            /* Efek hover */
        }

        main:hover {
            transform: translateY(-5px);
            /* Sedikit efek hover untuk interaksi */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            /* Shadow lebih intens saat hover */
        }

        /* Responsivitas untuk layar kecil */
        @media (max-width: 768px) {
            main {
                margin: 150px 15px 30px;
                /* Menambahkan jarak atas lebih kecil pada layar kecil */
                padding: 20px;
                /* Mengurangi padding untuk layar kecil */
            }
        }
        @media (max-width: 768px) {
      header {
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 10px;
        position: fixed; /* Tambahkan relative untuk posisi child absolute */
      }
    
      header .back-button {
        position: absolute; /* Pindahkan button dengan posisi absolute */
        top: 10px; /* Jarak dari atas */
        left: 10px; /* Jarak dari kiri */
        margin: 0; /* Hilangkan margin default */
        font-size: 16px;
        width: 40px;
        height: 40px;
      }
    
      header .logo {
        flex-direction: column;
        gap: 10px;
      }
    
      header .logo img {
        width: 60px;
        height: 60px;
      }
    
      header h2 {
        font-size: 20px;
      }
    
      header .sub-title {
        font-size: 12px;
      }
    }
    </style>
</head>

<body>
    <header>
        <button class="back-button" onclick="window.location.href='{{ route('dashboard.siswa') }}';">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="logo">
            <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="Logo">
            <div>
                <h2>DISPENSASI SISWA SMK NEGERI 1 KAWALI</h2>
                <p class="sub-title">{{ $siswa->nama }}</p>
            </div>
        </div>
    </header>

    <main class="container">
        <h3 style="text-align: center; font-weight: bold;">Data Formulir Dispensasi</h3>

        <!-- Formulir Dispensasi -->
        <form action="{{ route('dispensasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Data Siswa -->
            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" class="form-control" id="nis" name="nis" value="{{ $siswa->nis }}" readonly>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $siswa->nama }}" readonly>
            </div>

            <div class="mb-3">
                <label for="jk" class="form-label">Jenis Kelamin</label>
                <input type="text" class="form-control" id="jk" name="jk" value="{{ $siswa->jk }}" readonly>
            </div>

            <div class="mb-3">
                <label for="tingkatan" class="form-label">Tingkatan</label>
                <input type="text" class="form-control" id="tingkatan" name="tingkatan" value="{{ $siswa->tingkatan }}" readonly>
            </div>

            <div class="mb-3">
                <label for="konsentrasi_keahlian" class="form-label">Konsentrasi Keahlian</label>
                <input type="text" class="form-control" id="konsentrasi_keahlian" name="konsentrasi_keahlian" value="{{ $siswa->konsentrasi_keahlian }}" readonly>
            </div>

            <div class="mb-3">
                <label for="program_keahlian" class="form-label">Program Keahlian</label>
                <input type="text" class="form-control" id="program_keahlian" name="program_keahlian" value="{{ $siswa->program_keahlian }}" readonly>
            </div>
<hr>        <h3 style="text-align: center; font-weight: bold;">Isi Formulir Dispensasi</h3>
<br>
            <!-- Mata Pelajaran yang tidak di ikuti -->
            <div class="mb-3">
                <label for="mata_pelajaran" class="form-label">Mata Pelajaran Yang Tidak Diikuti</label>
                <select class="form-control" id="mata_pelajaran" name="mata_pelajaran" required>
                    <option value="" disabled selected>Pilih Mata Pelajaran</option>
                    @foreach($mataPelajaran as $mataPelajaranItem)
                    <option value="{{ $mataPelajaranItem->mata_pelajaran }}">{{ $mataPelajaranItem->mata_pelajaran }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Nama Pengajar -->
            <div class="mb-3">
                <label for="nama_pengajar" class="form-label">Nama Pengajar</label>
                <select class="form-select" id="nama_pengajar" name="nama_pengajar" required>
                    <option value="" disabled selected>Pilih Nama Pengajar</option>
                </select>
            </div>

            <!-- Input tersembunyi untuk menyimpan NIP -->
            <input type="hidden" id="nip" name="nip">

            <!-- Kategori Dispensasi -->
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori Dispensasi</label>
                <select class="form-select" id="kategori" name="kategori" required>
                    <option value="" disabled selected>Pilih kategori</option>
                    <option value="keluar lingkungan sekolah">Keluar Lingkungan Sekolah</option>
                    <option value="mengikuti kegiatan">Mengikuti Kegiatan</option>
                </select>
            </div>

            <!-- Alasan Dispensasi -->
            <div class="mb-3">
                <label for="alasan" class="form-label">Alasan</label>
                <input class="form-control" id="alasan" name="alasan" rows="3" required></input>
            </div>

            <!-- Waktu Keluar -->
            <div class="mb-3">
                <label for="waktu_keluar" class="form-label">Waktu Keluar</label>
                <input type="datetime-local" class="form-control" id="waktu_keluar" name="waktu_keluar" required>
            </div>

            <!-- Foto Bukti (Optional) -->
            <div class="mb-3">
                <label for="bukti_foto" class="form-label">Bukti Foto</label>
                <input type="file" class="form-control" id="bukti_foto" name="bukti_foto">
            </div>

            <!-- Tombol Kirim Pengajuan -->
            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
        </form>
    </main>
    <script>
        document.getElementById('mata_pelajaran').addEventListener('change', function() {
            var mataPelajaran = this.value;

            if (mataPelajaran) {
                fetch(`/siswa/get-pengajar/${mataPelajaran}`)
                    .then(response => response.json())
                    .then(data => {
                        var namaPengajarSelect = document.getElementById('nama_pengajar');
                        namaPengajarSelect.innerHTML = '<option value="" disabled selected>Pilih Nama Pengajar</option>';

                        data.forEach(function(pengajar) {
                            var option = document.createElement('option');
                            option.value = pengajar.nip;
                            option.textContent = pengajar.nama;
                            namaPengajarSelect.appendChild(option);
                        });

                        // Menambahkan event listener untuk menangani pemilihan nama pengajar
                        namaPengajarSelect.addEventListener('change', function() {
                            var nip = this.value;
                            document.getElementById('nip').value = nip; // Menyimpan nip yang terpilih ke input tersembunyi
                        });
                    })
                    .catch(error => console.log('Error:', error));
            }
        });
    </script>
<script>
    // Event listener untuk dropdown kategori
    document.getElementById('kategori').addEventListener('change', function () {
        var buktiFotoDiv = document.querySelector('.mb-3 input#bukti_foto').parentNode; // Div pembungkus bukti foto
        if (this.value === 'mengikuti kegiatan') {
            buktiFotoDiv.style.display = 'block'; // Tampilkan jika kategori "mengikuti kegiatan"
        } else {
            buktiFotoDiv.style.display = 'none'; // Sembunyikan untuk kategori lain
        }
    });

    // Pastikan bukti foto disembunyikan secara default saat halaman pertama kali dimuat
    document.addEventListener('DOMContentLoaded', function () {
        var kategoriDropdown = document.getElementById('kategori');
        var buktiFotoDiv = document.querySelector('.mb-3 input#bukti_foto').parentNode;
        if (kategoriDropdown.value !== 'mengikuti kegiatan') {
            buktiFotoDiv.style.display = 'none';
        }
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybOveo3f8VgJUvP5Vyn6pd56rOH1diJfqa0ksL8/4Oh3nybs0" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0uW9YrkQ+Q+97Jmf6fF3j1vSxtIhQczb1Y88aV6YQw0W6qHm" crossorigin="anonymous"></script>
</body>

</html>