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
        <button class="logout" onclick="navigateTo('logout')">Kembali</button>
    </header>
    
    <main>
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
                <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
                  <i class="bi bi-plus-lg"></i> Tambah
                </button>
              </div>
              
              <!-- Modal untuk menambah akun siswa -->
              <div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-labelledby="modalTambahSiswaLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalTambahSiswaLabel">Formulir Tambah Akun Siswa</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <!-- Formulir Tambah Akun Siswa -->
                      <form>
                        <div class="mb-3">
                          <label for="nis" class="form-label">NIS</label>
                          <input type="text" class="form-control" id="nis" placeholder="Masukkan NIS" required>
                        </div>
                        <div class="mb-3">
                          <label for="nama" class="form-label">Nama</label>
                          <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama" required>
                        </div>
                        <div class="mb-3">
                          <label for="kelas" class="form-label">Kelas</label>
                          <input type="text" class="form-control" id="kelas" placeholder="Masukkan Kelas" required>
                        </div>
                        <div class="mb-3">
                          <label for="jk" class="form-label">Jenis Kelamin</label>
                          <select class="form-select" id="jk" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="password" class="form-label">Password</label>
                          <input type="password" class="form-control" id="password" placeholder="Masukkan Password" required>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </div>
                </div>
              </div>
            <button class="btn-custom">
              <i class="bi bi-arrow-up-circle"></i> Naik Tingkat
            </button>
            <button class="btn-custom">
              <i class="bi bi-grid"></i> Kelas
            </button>
            
          </div>
    </div>
    
    <div class="accordion">
        <div class="accordion-item">
          <button class="accordion-trigger btn btn-dark w-100">Tahun Angkatan 2022</button>
          <div class="accordion-content">
            <table>
              <thead>
                <tr>
                  <th><input type="checkbox"></th>
                  <th>NIS</th>
                  <th>Kelas</th>
                  <th>Nama</th>
                  <th>JK</th>
                  <th>Password</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input type="checkbox"></td>
                  <td>222310266</td>
                  <td>12 RPL 2</td>
                  <td>Fitri Najwa Fatimatu Jahro</td>
                  <td>P</td>
                  <td>000001</td>
                  <td><button class="edit btn btn-outline-secondary btn-sm">Edit</button></td>
                </tr>
                <tr>
                  <td><input type="checkbox"></td>
                  <td>222310267</td>
                  <td>12 RPL 2</td>
                  <td></td>
                  <td></td>
                  <td>000002</td>
                  <td><button class="edit btn btn-outline-secondary btn-sm">Edit</button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </div>
    
    <div class="accordion">
      <div class="accordion-item">
        <button class="accordion-trigger btn btn-dark w-100">Tahun Angkatan 2022</button>
        <div class="accordion-content">
          <table>
            <thead>
              <tr>
                <th><input type="checkbox"></th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Nama</th>
                <th>JK</th>
                <th>Password</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="checkbox"></td>
                <td>222310266</td>
                <td>12 RPL 2</td>
                <td>Fitri Najwa Fatimatu Jahro</td>
                <td>P</td>
                <td>000001</td>
                <td><button class="edit btn btn-outline-secondary btn-sm">Edit</button></td>
              </tr>
              <tr>
                <td><input type="checkbox"></td>
                <td>222310267</td>
                <td>12 RPL 2</td>
                <td></td>
                <td></td>
                <td>000002</td>
                <td><button class="edit btn btn-outline-secondary btn-sm">Edit</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="accordion">
      <div class="accordion-item">
        <button class="accordion-trigger btn btn-dark w-100">Tahun Angkatan 2022</button>
        <div class="accordion-content">
          <table>
            <thead>
              <tr>
                <th><input type="checkbox"></th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Nama</th>
                <th>JK</th>
                <th>Password</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="checkbox"></td>
                <td>222310266</td>
                <td>12 RPL 2</td>
                <td>Fitri Najwa Fatimatu Jahro</td>
                <td>P</td>
                <td>000001</td>
                <td><button class="edit btn btn-outline-secondary btn-sm">Edit</button></td>
              </tr>
              <tr>
                <td><input type="checkbox"></td>
                <td>222310267</td>
                <td>12 RPL 2</td>
                <td></td>
                <td></td>
                <td>000002</td>
                <td><button class="edit btn btn-outline-secondary btn-sm">Edit</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
  <!-- Bootstrap 5 JS and Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybOveo3f8VgJUvP5Vyn6pd56rOH1diJfqa0ksL8/4Oh3nybs0" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0uW9YrkQ+Q+97Jmf6fF3j1vSxtIhQczb1Y88aV6YQw0W6qHm" crossorigin="anonymous"></script>
</body>
</html>
