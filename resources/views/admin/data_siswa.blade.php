<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Dispensasi</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEJb3RrP6j1eg84BQ2erfFPLBaZrj1I1NE9FYkCOs5TtZUSSHjGZbmL8HjzqP" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
        <button class="back-button" onclick="window.location.href='{{ route('dashboard.admin') }}';">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="logo">
            <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="Logo">
            <div>
                <h2>AKUN & DATA SISWA SMK NEGERI 1 KAWALI</h2>
                <p class="sub-title">Kurikulum</p>
            </div>
        </div>
    </header>
    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus siswa yang dipilih?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>
    <main>
        <div style="display: flex; align-items: center; margin-bottom: 20px;">
            <!-- Searching -->
            <div class="search-container" style="margin-bottom: 0px;">
                <input type="text" id="searchInput" placeholder="Cari NIS, Nama, Kelas, Program Keahlian..."
                    onkeyup="searchTable()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
            <div class="buttons">
                <div class="buttons">
                    <!-- Tombol Hapus yang hanya muncul setelah memilih siswa -->
                    <button type="button" class="btn-custom" onclick="deleteSelected()"><i class="bi bi-trash"></i>
                        Hapus Terpilih</button>
                    <!-- Tombol untuk membuka modal -->
                    <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
                        <i class="bi bi-plus-lg"></i> Tambah Siswa
                    </button>
                    <!-- Form untuk hapus yang disembunyikan -->
                    <form id="deleteForm" action="{{ route('delete-siswa') }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <!-- Modal untuk menambah akun siswa -->
                <div class="modal fade" id="modalTambahSiswa" tabindex="-1" aria-labelledby="modalTambahSiswaLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahSiswaLabel">Formulir Tambah Data & Akun Siswa
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulir Tambah Akun Siswa -->
                                <form action="{{ route('akun-siswa.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nis" class="form-label">NIS</label>
                                        <input type="text" class="form-control" id="nis" name="nis"
                                            placeholder="Masukkan NIS" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="Masukkan Nama" required>
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
                                    <div class="mb-3">
                                        <label for="program_keahlian" class="form-label">Program Keahlian</label>
                                        <select class="form-select" id="program_keahlian" name="program_keahlian"
                                            required>
                                            <option value="">Pilih Program Keahlian</option>
                                            @foreach ($programKeahlian as $item)
                                                <option value="{{ $item->program_keahlian }}">
                                                    {{ $item->program_keahlian }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="konsentrasi_keahlian" class="form-label">Konsentrasi
                                            Keahlian</label>
                                        <select class="form-select" id="konsentrasi_keahlian"
                                            name="konsentrasi_keahlian" required disabled>
                                            <option value="">Pilih Konsentrasi Keahlian</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Masukkan Password" required>
                                    </div>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary"
                                        id="btnSimpanSiswa">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn-custom" href="javascript:void(0);" onclick="increaseTingkatan()">
                    <i class="bi bi-arrow-up-circle"></i> Naik Tingkat
                </button>
                <button class="btn-custom" onclick="window.location.href='{{ route('kelasKelas') }}';">
                    <i class="bi bi-grid"></i> Kelas
                </button>
                <div class="dropdown" style="position: relative;">
                    <button class="btn btn-secondary" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false"
                        style="background-color: white; color: black; border:none; padding: 12px 0; margin-left: -15px; cursor: pointer; display: flex; align-items: center;">
                        <i class="bi bi-three-dots-vertical" style="font-size: 24px;"></i>
                    </button>
                    <ul class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton"
                        style="border-radius: 10px; overflow: hidden; min-width: 200px;">
                        <!-- Opsi Import -->
                        <li>
                            <button class="dropdown-item d-flex align-items-center dropdown-hover"
                                data-bs-toggle="modal" data-bs-target="#importModal"
                                style="transition: background-color 0.3s;">
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
                            <a class="dropdown-item d-flex align-items-center dropdown-hover"
                                href="{{ route('export-siswa') }}" style="transition: background-color 0.3s;">
                                <i class="bi bi-download me-2" style="font-size: 18px; color: #28a745;"></i>
                                <span>Export Excel</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Modal Import -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Data Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('import-siswa') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="excelFile" class="form-label">Pilih File Excel:</label>
                                <input type="file" class="form-control" id="excelFile" name="excelFile"
                                    accept=".xls,.xlsx" required>
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
        @if (session('success'))
            <div id="popupAlert" class="alert alert-success alert-popup">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show error-message" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div id="noResultsMessage" class="alert alert-warning" style="display: none;">
            <strong>Data yang Anda cari tidak ditemukan!</strong>
        </div>
        <!-- Accordion untuk Data Siswa -->
        <div class="accordion">
            @foreach ($dataPerTingkatan as $tingkatan)
                @if (!empty($tingkatan['data']))
                    <div class="accordion-item">
                        <button class="accordion-trigger btn btn-dark w-100" aria-expanded="false">
                            Data & Akun Siswa Tingkat {{ $tingkatan['tingkatan'] }} SMK NEGERI 1 KAWALI
                            <span class="float-end"
                                style="font-weight: 500; margin-right: 20px; font-size: 11px; margin-top: 4px">
                                Jumlah Siswa: {{ count($tingkatan['data']) }}
                            </span>
                        </button>
                        <div class="accordion-content" style="overflow-y: auto; overflow-x: auto;">
                            <table class="table" id="siswaTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="select_all_{{ $tingkatan['tingkatan'] }}"
                                                class="select_all" data-tingkatan="{{ $tingkatan['tingkatan'] }}">
                                        </th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Program Keahlian</th>
                                        <th>Jenis Kelamin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tingkatan['data'] as $siswa)
                                        <tr class="searchable">
                                            <td style="text-align: center;">
                                                <input type="checkbox" name="hapus[]"
                                                    class="checkbox_ids checkbox_ids_{{ $tingkatan['tingkatan'] }}"
                                                    value="{{ $siswa['nis'] }}">
                                            </td>
                                            <td style="text-align: center">{{ $siswa['nis'] }}</td>
                                            <td>{{ $siswa['nama'] }}</td>
                                            <td style="text-align: center">{{ $siswa['tingkatan'] }}
                                                {{ $siswa['konsentrasi_keahlian'] }}</td>
                                            <td>{{ $siswa['program_keahlian'] }}</td>
                                            <td style="text-align: center">{{ $siswa['jk'] }}</td>
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

    {{-- SEARCHING - START --}}
    <script>
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const accordionItems = document.querySelectorAll('.accordion-item');

            let hasData = false;

            accordionItems.forEach(item => {
                const rows = item.querySelectorAll('#siswaTable tbody tr');
                const accordionContent = item.querySelector('.accordion-content');
                const accordionTrigger = item.querySelector('.accordion-trigger');
                let itemMatches = false;

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let rowText = '';

                    cells.forEach(cell => {
                        rowText += cell.textContent.toLowerCase() + ' ';
                    });

                    if (rowText.includes(filter)) {
                        row.style.display = ''; // Tampilkan baris
                        itemMatches = true;
                    } else {
                        row.style.display = 'none'; // Sembunyikan baris
                    }
                });

                if (itemMatches) {
                    item.style.display = ''; // Tampilkan item accordion
                    accordionContent.classList.add('active'); // Tambahkan kelas active untuk menampilkan konten
                    accordionTrigger.setAttribute('aria-expanded', 'true');
                    item.classList.add('active'); // Tambahkan kelas active untuk efek shadow
                    hasData = true;
                } else {
                    item.style.display = 'none'; // Sembunyikan item accordion
                    accordionContent.classList.remove('active'); // Hapus kelas active jika tidak cocok
                    accordionTrigger.setAttribute('aria-expanded', 'false');
                    item.classList.remove('active'); // Hapus kelas active untuk efek shadow
                }
            });

            const noResultsMessage = document.getElementById('noResultsMessage');
            if (hasData) {
                noResultsMessage.style.display = 'none';
            } else {
                noResultsMessage.style.display = 'block';
            }
        }
    </script>
    {{-- SEARCHING - END --}}

    {{-- WAKTU MUNCUL ALERT - START --}}
    <script>
        // Menutup pop-up alert secara otomatis setelah 4 detik
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                const alert = document.getElementById("popupAlert");
                if (alert) {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500); // Hapus elemen setelah animasi selesai
                }
            }, 4000); // 4000 ms = 4 detik
        });
    </script>
    {{-- WAKTU MUNCUL ALERT - END --}}

    {{-- NAIK TINGKAT - START --}}
    <script>
        function increaseTingkatan() {
            if (confirm("Apakah Anda yakin ingin menambah tingkatan untuk semua siswa?")) {
                // Redirect ke route untuk menambah tingkatan
                window.location.href = "{{ route('increaseTingkatan') }}";
            }
        }
    </script>
    {{-- NAIK TINGKAT - END --}}

    {{-- FORM PEMANGGILAN KELAS - START --}}
    <script>
        document.getElementById('program_keahlian').addEventListener('change', function() {
            const programKeahlian = this.value;
            const konsentrasiKeahlianSelect = document.getElementById('konsentrasi_keahlian');

            if (programKeahlian) {
                fetch(`{{ url('/admin/siswa/get-konsentrasi') }}?program_keahlian=${programKeahlian}`)
                    .then(response => response.json())
                    .then(data => {
                        konsentrasiKeahlianSelect.innerHTML =
                            '<option value="">Pilih Konsentrasi Keahlian</option>';
                        data.forEach(item => {
                            konsentrasiKeahlianSelect.innerHTML +=
                                `<option value="${item}">${item}</option>`;
                        });
                        konsentrasiKeahlianSelect.disabled = false;
                    })
                    .catch(err => console.error('Error:', err));
            } else {
                konsentrasiKeahlianSelect.innerHTML = '<option value="">Pilih Konsentrasi Keahlian</option>';
                konsentrasiKeahlianSelect.disabled = true;
            }
        });
    </script>
    {{-- FORM PEMANGGILAN KELAS - END --}}

    {{-- DELETE - START --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua checkbox "Select All"
            const selectAllCheckboxes = document.querySelectorAll('.select_all');

            // Loop setiap "Select All" checkbox
            selectAllCheckboxes.forEach(selectAllCheckbox => {
                selectAllCheckbox.addEventListener('change', function() {
                    const tingkatan = this.dataset
                        .tingkatan; // Ambil tingkatan dari atribut data-tingkatan
                    const checkboxes = document.querySelectorAll(
                        `.checkbox_ids_${tingkatan}`); // Checkbox individu di tingkatan ini

                    // Ubah status semua checkbox berdasarkan "Select All"
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });
            });

            // Tambahkan event listener untuk uncheck "Select All" jika satu checkbox diubah
            const allCheckboxes = document.querySelectorAll('.checkbox_ids');
            allCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const tingkatan = this.classList[1].split('_')[2]; // Ambil tingkatan dari class
                    const selectAll = document.getElementById(`select_all_${tingkatan}`);
                    const tingkatanCheckboxes = document.querySelectorAll(
                        `.checkbox_ids_${tingkatan}`);

                    // Jika semua checkbox dicentang, centang "Select All"; jika tidak, uncheck
                    selectAll.checked = Array.from(tingkatanCheckboxes).every(cb => cb.checked);
                });
            });

            // Fungsi untuk menghapus data yang dipilih
            window.deleteSelected = function() {
                // Ambil semua checkbox yang terpilih
                const checkedBoxes = document.querySelectorAll('input[name="hapus[]"]:checked');
                if (checkedBoxes.length === 0) {
                    alert('Tidak ada siswa yang dipilih untuk dihapus.');
                    return;
                }

                // Tampilkan modal konfirmasi
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                confirmModal.show();

                // Pastikan tombol konfirmasi hanya memiliki satu event listener
                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                confirmDeleteBtn.onclick = function() {
                    // Ambil semua NIS yang dipilih
                    const selectedValues = Array.from(checkedBoxes).map(cb => cb.value);

                    // Siapkan form dan kirim
                    const deleteForm = document.getElementById('deleteForm');
                    deleteForm.innerHTML = '@csrf @method('DELETE')'; // Reset isi form
                    selectedValues.forEach(value => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'hapus[]';
                        input.value = value;
                        deleteForm.appendChild(input);
                    });
                    deleteForm.submit(); // Kirim form penghapusan
                };
            };
        });
    </script>
    {{-- DELETE - END --}}
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
