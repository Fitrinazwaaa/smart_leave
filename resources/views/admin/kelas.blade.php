<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJb3RrP6j1eg84BQ2erfFPLBaZrj1I1NE9FYkCOs5TtZUSSHjGZbmL8HjzqP" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ asset('css/admin/kelas.css') }}" rel="stylesheet" type="text/css">
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

          // Search functionality
          const searchInput = document.getElementById("searchProgramKeahlian");
          searchInput.addEventListener("input", function () {
              const programKeahlianValue = searchInput.value.toLowerCase();
              const tableRows = document.querySelectorAll(".table tbody tr");

              // Show or hide rows based on search
              tableRows.forEach(row => {
                  const programKeahlianText = row.cells[1].textContent.toLowerCase();
                  const konsentrasiKeahlianText = row.cells[2].textContent.toLowerCase();

                  // Hide row if it doesn't match either of the fields
                  if (programKeahlianText.includes(programKeahlianValue) || konsentrasiKeahlianText.includes(programKeahlianValue)) {
                      row.style.display = "";
                  } else {
                      row.style.display = "none";
                  }
              });

              // Automatically open the accordion when typing in the search box
              const accordionItem = document.querySelector(".accordion-item");
              const accordionContent = accordionItem.querySelector(".accordion-content");
              if (!accordionItem.classList.contains("active")) {
                  accordionItem.classList.add("active");
                  accordionContent.classList.add("active");
              }
          });

          // Optionally, auto-open accordion when clicking on the search input
          const searchBox = document.getElementById("searchProgramKeahlian");
          searchBox.addEventListener("focus", () => {
              const accordionItem = document.querySelector(".accordion-item");
              const accordionContent = accordionItem.querySelector(".accordion-content");
              if (!accordionItem.classList.contains("active")) {
                  accordionItem.classList.add("active");
                  accordionContent.classList.add("active");
              }
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
                <input type="text" id="searchProgramKeahlian" placeholder="Cari Program atau Konsentrasi Keahlian" class="form-control">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
            
            <div class="buttons">
                <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
                    <i class="bi bi-plus-lg"></i> Tambah Kelas
                </button>
                <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
                    <i class="bi bi-plus-lg"></i> Export
                </button>
                <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
                    <i class="bi bi-plus-lg"></i> Import
                </button>
            </div>
        </div>

        <!-- Modal -->
    <div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-labelledby="modalTambahKelasLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKelasLabel">Formulir Tambah Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahKelas" method="POST" action="{{ route('kelas.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="program_keahlian" class="form-label">Program Keahlian</label>
                            <input type="text" class="form-control" id="program_keahlian" name="program_keahlian" placeholder="Masukkan Program Keahlian" required>
                        </div>
                        <div class="mb-3">
                            <label for="konsentrasi_keahlian" class="form-label">Konsentrasi Keahlian</label>
                            <input type="text" class="form-control" id="konsentrasi_keahlian" name="konsentrasi_keahlian" placeholder="Masukkan Program Keahlian" required>
                        </div>
                        <div class="mb-3">
                            <label for="jml_kelas" class="form-label">Banyak Kelas</label>
                            <input type="number" class="form-control" id="jml_kelas" name="jml_kelas" placeholder="Masukkan Jumlah Kelas" required>
                        </div>
                        <div id="konsentrasiKelasContainer"></div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpanKelas">Simpan</button>
                    </form>
                    <script>
                        document.getElementById('formTambahKelas').addEventListener('submit', function (event) {
                            event.preventDefault(); // Mencegah form untuk submit otomatis

                            const programKeahlian = document.getElementById('program_keahlian').value;
                            const konsentrasiKeahlian = document.getElementById('konsentrasi_keahlian').value;
                            const jmlKelas = parseInt(document.getElementById('jml_kelas').value);

                            // Validasi input
                            if (!programKeahlian || !konsentrasiKeahlian || isNaN(jmlKelas) || jmlKelas <= 0) {
                                alert('Pastikan semua data terisi dengan benar!');
                                return;
                            }

                            // Persiapkan data untuk dikirim
                            const dataToSend = [];
                            for (let i = 1; i <= jmlKelas; i++) {
                                dataToSend.push({
                                    program_keahlian: programKeahlian,
                                    konsentrasi_keahlian: `${konsentrasiKeahlian} ${i}`,
                                });
                            }

                            // Kirim data ke backend
                            fetch('{{ route("kelas.store") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({
                                    program_keahlian: programKeahlian,
                                    konsentrasi_keahlian: dataToSend.map(item => item.konsentrasi_keahlian),
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Kelas berhasil ditambahkan!');
                                    location.reload(); // Reload page
                                } else {
                                    alert('Terjadi kesalahan, coba lagi.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan pada proses pengiriman.');
                            });
                        });
                    </script>                    
                </div>
            </div>
        </div>
    </div>

    <div class="accordion">
        <div class="accordion-item">
            <button class="accordion-trigger btn btn-dark w-100">Kelas SMK Negeri 1 Kawali</button>
            <div class="accordion-content">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox"></th>
                                <th>Program Keahlian</th>
                                <th>Konsentrasi Keahlian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelas as $item)
                            <tr>
                                <td style="text-align: center;"><input type="checkbox"></td>
                                <td>{{ $item->program_keahlian }}</td>
                                <td>{{ $item->konsentrasi_keahlian }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
