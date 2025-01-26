<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Dispensasi - SMK NEGERI 1 KAWALI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="{{ asset('css/form.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
    <header class="bg-primary text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo d-flex align-items-center">
                <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="Logo" width="50" class="me-2">
                <h2 class="mb-0">Formulir Dispensasi</h2>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </header>

    <main class="container mt-4">
        <h3 class="mb-4">Isi Formulir Dispensasi</h3>

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
                <select class="form-select" id="jk" name="jk" required>
                    <option value="" disabled selected>Pilih kategori</option>
                    <option value="P" {{ $siswa->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                    <option value="L" {{ $siswa->jk == 'L' ? 'selected' : '' }}>Laki - Laki</option>
                </select>
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

            <!-- Kategori Dispensasi -->
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori Dispensasi</label>
                <select class="form-select" id="kategori" name="kategori" required>
                    <option value="" disabled selected>Pilih kategori</option>
                    <option value="masuk kelas">Masuk Kelas</option>
                    <option value="keluar lingkungan sekolah">Keluar Lingkungan Sekolah</option>
                    <option value="mengikuti kegiatan">Mengikuti Kegiatan</option>
                </select>
            </div>

            <!-- Alasan Dispensasi -->
            <div class="mb-3">
                <label for="alasan" class="form-label">Alasan</label>
                <textarea class="form-control" id="alasan" name="alasan" rows="3" required></textarea>
            </div>

            <!-- Waktu Keluar -->
            <div class="mb-3">
                <label for="waktu_keluar" class="form-label">Waktu Keluar</label>
                <input type="datetime-local" class="form-control" id="waktu_keluar" name="waktu_keluar" required>
            </div>

            <!-- Foto Bukti (Optional) -->
            <div class="mb-3">
                <label for="bukti_foto" class="form-label">Bukti Foto (Opsional)</label>
                <input type="file" class="form-control" id="bukti_foto" name="bukti_foto">
            </div>

            <!-- Tombol Kirim Pengajuan -->
            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
        </form>
    </main>

    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center">
            <p>&copy; 2025 SMK Negeri 1 Kawali | All Rights Reserved</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
