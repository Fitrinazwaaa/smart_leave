<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konfirmasi Dispensasi</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/admin/data_siswa.css') }}" rel="stylesheet">
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
    <button class="back-button" onclick="window.location.href='{{ route('dashboard.admin') }}';">
        <i class="fas fa-arrow-left"></i>
    </button>
    <div class="logo">
        <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="Logo">
        <div>
            <h2>AKUN & DATA GURU SMK NEGERI 1 KAWALI</h2>
            <p class="sub-title">Kurikulum</p>
        </div>
    </div>
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
            <i class="bi bi-plus-lg"></i> Tambah Guru
          </button>
          <div class="dropdown" style="position: relative;">
            <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: white; color: black; border:none; padding: 12px 0; margin-left: -15px; cursor: pointer; display: flex; align-items: center;">
              <i class="bi bi-three-dots-vertical" style="font-size: 24px;"></i>
            </button>
            <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton" style="border-radius: 10px; overflow: hidden; min-width: 200px;">
              <!-- Opsi Import -->
              <li>
                <button class="dropdown-item d-flex align-items-center dropdown-hover" data-bs-toggle="modal" data-bs-target="#importModal" style="transition: background-color 0.3s;">
                  <i class="bi bi-upload me-2" style="font-size: 18px; color: #007bff;"></i>
                  <span>Import Excel</span>
                </button>
              </li>
              <!-- Divider -->
              <li>
                <hr class="dropdown-divider">
              </li>
              <!-- Opsi Export -->
              <li>
                <a class="dropdown-item d-flex align-items-center dropdown-hover" href="{{ route('export-siswa') }}" style="transition: background-color 0.3s;">
                  <i class="bi bi-download me-2" style="font-size: 18px; color: #28a745;"></i>
                  <span>Export Excel</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="modal fade" id="modalTambahGuru" tabindex="-1" aria-labelledby="modalTambahGuruLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Formulir Tambah Akun Guru</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.guru.store') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="nip" class="form-label">NIP/NUPTK</label>
                <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP" required minlength="3" maxlength="20">
              </div>
              <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required maxlength="100">
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
                <label for="tingkat" class="form-label">Tingkat</label>
                <select class="form-select" id="tingkat" name="tingkat" required>
                  <option value="">Pilih Tingkatan</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="program_keahlian" class="form-label">Program Keahlian</label>
                <select class="form-select" id="program_keahlian" name="program_keahlian" required>
                  <option value="">Pilih Program Keahlian</option>
                  @foreach($programKeahlian as $item)
                  <option value="{{ $item->program_keahlian }}">{{ $item->program_keahlian }}</option>
                  @endforeach
                </select>
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
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required minlength="10">
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
        <button class="accordion-trigger btn btn-dark w-100">Data & Akun Guru SMK NEGERI 1 KAWALI</button>
        <div class="accordion-content">
          <table class="table table-striped">
            <thead>
              <tr>
                <th><input type="checkbox"></th>
                <th>NIP/NUPTK</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Mata Pelajaran</th>
                <th>Tingkat</th>
                <th>Program Keahlian</th>
                <th>Hari Piket</th>
                <th>Password</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="checkbox"></td>
                <td>{{ $guru->nip }}</td>
                <td>{{ $guru->nama }}</td>
                <td>{{ $guru->jk }}</td>
                <td>{{ $guru->mata_pelajaran }}</td>
                <td>{{ $guru->tingkat }}</td>
                <td>{{ $guru->program_keahlian }}</td>
                <td>{{ $guru->hari_piket }}</td>
                <td>{{ $guru->password }}</td>
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