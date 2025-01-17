<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konfirmasi Dispensasi</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ asset('css/admin/data_siswa.css') }}" rel="stylesheet">
  <style>
    .dropdown-hover:hover {
      background-color: #f8f9fa;
      color: #000;
    }
    .dropdown-hover:hover i {
      color: #0056b3;
    }
    .dropdown-hover[href]:hover i {
      color: #1e7e34;
    }

  </style>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const triggers = document.querySelectorAll(".accordion-trigger");
      triggers.forEach((trigger) => {
        trigger.addEventListener("click", () => {
          const content = trigger.nextElementSibling;
          const parentItem = trigger.closest('.accordion-item');
          content.classList.toggle("active");
          parentItem.classList.toggle("active");
        });
      });
    });
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
        <button class="logout" onclick="window.location.href='{{ route('dashboard.admin') }}';">Kembali</button>
    </header>

    <main>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

      <div style="display: flex; align-items: center; margin-bottom: 20px;">
        <div class="search-container">
          <input type="text" placeholder="Cari">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
        </div>
        
        <div class="buttons">
          <div class="buttons">
            <!-- Tombol untuk membuka modal -->
            <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambahGuru">
              <i class="bi bi-trash"></i>
            </button>
            <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambahGuru">
              <i class="bi bi-plus-lg"></i> Tambah
            </button>
          </div>
        </div>
        

    <div class="modal fade" id="modalTambahGuru" tabindex="-1" aria-labelledby="modalTambahGuruLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Formulir Tambah Akun Guru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{ route('admin.guru.store') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="nip" class="form-label">NIP/NUPTK</label>
                <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP" required>
              </div>
              <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
              </div>
              <div class="mb-3">
                <label for="jk" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jk" name="jk" required>
                  <option value="">Pilih Jenis Kelamin</option>
                  <option value="L">Laki-Laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="mata_pelajaran" class="form-label">Mata Pelajaran</label>
                <input type="text" class="form-control" id="mata_pelajaran" name="mata_pelajaran" placeholder="Masukkan Mata Pelajaran" required>
              </div>
              <div class="mb-3">
                <label for="hari_piket" class="form-label">Hari Piket</label>
                <select class="form-select" id="hari_piket" name="hari_piket" required>
                  <option value="">Pilih Hari Piket</option>
                  <option value="Senin">Senin</option>
                  <option value="Selasa">Selasa</option>
                  <option value="Rabu">Rabu</option>
                  <option value="Kamis">Kamis</option>
                  <option value="Jumat">Jumat</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
              </div>
              <div class="text-end">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
        </div>

    <div class="accordion">
  @foreach ($dataGuru as $guru)
    <div class="accordion-item">
      <button class="accordion-trigger btn btn-dark w-100">Data & Akun Guru SMK N 1 Kawali</button>
      <div class="accordion-content">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>NIP/NUPTK</th>
              <th>Nama</th>
              <th>Jabatan</th>
              <th>Program Keahlian</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $guru->nip }}</td>
              <td>{{ $guru->nama }}</td>
              <td>{{ $guru->jabatan }}</td>
              <td>{{ $guru->program_keahlian }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  @endforeach
</div>


  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
