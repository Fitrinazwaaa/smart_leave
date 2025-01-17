<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konfirmasi Dispensasi</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJb3RrP6j1eg84BQ2erfFPLBaZrj1I1NE9FYkCOs5TtZUSSHjGZbmL8HjzqP" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ asset('css/admin/data_siswa.css') }}" rel="stylesheet" type="text/css">
  <style>
      /* Hover effect for dropdown items */
  .dropdown-hover:hover {
    background-color: #f8f9fa; /* Light gray on hover */
    color: #000; /* Black text on hover */
  }

  /* Icon hover effect */
  .dropdown-hover:hover i {
    color: #0056b3; /* Slightly darker blue for Import */
  }

  /* Export hover effect for icon */
  .dropdown-hover[href]:hover i {
    color: #1e7e34; /* Slightly darker green for Export */
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
            <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambahGuru">
              <i class="bi bi-trash"></i>
            </button>
            <!-- Tombol untuk membuka modal -->
            <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
              <i class="bi bi-plus-lg"></i> Tambah
            </button>
          </div>
            
          <!-- Modal untuk menambah akun siswa -->
          <div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-labelledby="modalTambahSiswaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalTambahSiswaLabel">Formulir Tambah Akun Siswa</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <div class="modal-body">
                  <!-- Formulir Tambah Akun Siswa -->
                  <form action="{{ route('akun-siswa.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" placeholder="Masukkan NIS" required>
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
                        <label for="tingkatan" class="form-label">Tingkatan</label>
                        <select class="form-select" id="tingkatan" name="tingkatan" required>
                            <option value="">Pilih Tingkatan</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="tingkatan" class="form-label">Tingkatan</label>
                        <input type="text" class="form-control" id="tingkatan" name="tingkatan" placeholder="Masukkan Tingkatan" required>
                    </div> -->
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
                        <label for="konsentrasi_keahlian" class="form-label">Konsentrasi Keahlian</label>
                        <select class="form-select" id="konsentrasi_keahlian" name="konsentrasi_keahlian" disabled required>
                            <option value="">Pilih Konsentrasi Keahlian</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
                    </div>

                    <div id="konsentrasiSiswaContainer"></div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpanSiswa">Simpan</button>                  </form>

                  <script>
                      document.getElementById('program_keahlian').addEventListener('change', function() {
                          const programKeahlian = this.value;
                          const konsentrasiKeahlianSelect = document.getElementById('konsentrasi_keahlian');

                          if (programKeahlian) {
                              fetch(`{{ url('/get-konsentrasi') }}?program_keahlian=${programKeahlian}`)
                                  .then(response => response.json())
                                  .then(data => {
                                      konsentrasiKeahlianSelect.innerHTML = '<option value="">Pilih Konsentrasi Keahlian</option>';
                                      data.forEach(item => {
                                          konsentrasiKeahlianSelect.innerHTML += `<option value="${item}">${item}</option>`;
                                      });
                                      konsentrasiKeahlianSelect.disabled = false;
                                  });
                          } else {
                              konsentrasiKeahlianSelect.innerHTML = '<option value="">Pilih Konsentrasi Keahlian</option>';
                              konsentrasiKeahlianSelect.disabled = true;
                          }
                      });
                  </script>

                </div>
              </div>
            </div>
          </div>
          <button class="btn-custom">
            <i class="bi bi-arrow-up-circle"></i> Naik Tingkat
          </button>
          <button class="btn-custom" onclick="window.location.href='{{ route('kelasKelas') }}';">
            <i class="bi bi-grid"></i> Kelas
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
      <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="importModalLabel">Import Data Siswa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ route('import-siswa') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="mb-3">
                <label for="excelFile" class="form-label">Pilih File Excel:</label>
                <input type="file" class="form-control" id="excelFile" name="excelFile" accept=".xls,.xlsx" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Import</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
      <!-- Rendering dynamic accordion items based on data availability -->
      <div class="accordion">
      @foreach ($dataPerTingkatan as $tingkatan)
    @if (!empty($tingkatan['data']))
    <div class="accordion-item">
      <button class="accordion-trigger btn btn-dark w-100">Data & Akun Siswa Tingkat {{ $tingkatan['tingkatan'] }} SMK N 1 Kawali</button>
      <div class="accordion-content">
        <table class="table">
          <thead>
            <tr>
              <th><input type="checkbox"></th>
              <th>NIS</th>
              <th>Nama</th>
              <th>Kelas</th>
              <th>Program Keahlian</th>
              <th>JK</th>
              <th>Password</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tingkatan['data'] as $siswa)
            <tr>
              <td><input type="checkbox"></td>
              <td>{{ $siswa['nis'] }}</td>
              <td>{{ $siswa['nama'] }}</td>
              <td>{{ $siswa['tingkatan'] }} {{ $siswa['konsentrasi_keahlian'] }}</td>
              <td>{{ $siswa['program_keahlian'] }}</td>
              <td>{{ $siswa['jk'] }}</td>
              <td>{{ $siswa['password'] }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif
@endforeach

      </div>
      
  </main>
  <!-- Bootstrap 5 JS and Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybOveo3f8VgJUvP5Vyn6pd56rOH1diJfqa0ksL8/4Oh3nybs0" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0uW9YrkQ+Q+97Jmf6fF3j1vSxtIhQczb1Y88aV6YQw0W6qHm" crossorigin="anonymous"></script>
</body>
</html>
