<?php
use App\Models\AkunGuru;
$totalGuru = AkunGuru::count(); // Hitung jumlah guru
?>
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
    <style>
        .modal-header {
            background-color: #030248;
            color: white;
        }

        .modal-title {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .btn-close {
            filter: invert(100%);
        }

        .modal-footer {
            background-color: #030248;
        }

        .btn-primary {
            background-color: #030248;
            border-color: #030248;
        }

        .btn-primary:hover {
            background-color: #05037b;
            border-color: #05037b;
        }

        .form-control:focus {
            border-color: #030248;
            box-shadow: 0 0 5px rgba(3, 2, 72, 0.8);
        }

        .modal-content {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
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
    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.guru.import') }}" method="POST" enctype="multipart/form-data">
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
    <main>
        <div style="display: flex; align-items: center; margin-bottom: 20px;">
            <div class="search-container">
                <input type="text" placeholder="Cari">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
            <div class="buttons">
                <div class="buttons">
                    <!-- Tombol Hapus yang hanya muncul setelah memilih siswa -->
                    <button type="button" class="btn-custom" onclick="deleteSelected()">
                        <i class="bi bi-trash"></i> Hapus Terpilih
                    </button>
                    <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambahGuru">
                        <i class="bi bi-plus-lg"></i> Tambah Guru
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
                                    href="{{ route('admin.guru.export') }}"
                                    style="transition: background-color 0.3s;">
                                    <i class="bi bi-download me-2" style="font-size: 18px; color: #28a745;"></i>
                                    <span>Export Excel</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Form untuk hapus yang disembunyikan -->
                    <form id="deleteForm" action="{{ route('delete-guru') }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
            <!-- Modal untuk menambah akun guru -->
            <div class="modal fade" id="modalTambahGuru" tabindex="-1" aria-labelledby="modalTambahGuruLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahGuruLabel">Formulir Tambah Akun Guru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.guru.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nip" class="form-label">NIP/NUPTK</label>
                                    <input type="text" class="form-control" id="nip" name="nip"
                                        placeholder="Masukkan NIP" required minlength="3" maxlength="20">
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Masukkan Nama" required maxlength="100">
                                </div>
                                <div class="mb-3">
                                    <label for="jk" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" id="jk" name="jk" required>
                                        <option value="" disabled>Pilih</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <select class="form-select" id="jabatan" name="jabatan" required>
                                        <option value="" disabled>piih</option>
                                        <option value="kurikulum">Kurikulum</option>
                                        <option value="-">Tidak Ada</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="mata_pelajaran" class="form-label">Mata Pelajaran</label>
                                    <input type="text" class="form-control" id="mata_pelajaran"
                                        name="mata_pelajaran" placeholder="Masukkan Mata Pelajaran" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tingkat" class="form-label">Tingkat</label>
                                    <select class="form-select" id="tingkat" name="tingkat" required>
                                        <option value="" disabled>Pilih</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="program_keahlian" class="form-label">Program Keahlian</label>
                                    <select class="form-select" id="program_keahlian" name="program_keahlian" required>
                                        <option value="" disabled>Pilih</option>
                                        @foreach ($programKeahlian as $item)
                                            <option value="{{ $item->program_keahlian }}">{{ $item->program_keahlian }}</option>
                                        @endforeach
                                        <option value="NULL">Tidak Memilih</option> <!-- Opsi Kosong yang bisa dipilih -->
                                    </select>
                                </div>                                
                                <div class="mb-3">
                                    <label for="hari_piket" class="form-label">Hari Piket</label>
                                    <select class="form-select" id="hari_piket" name="hari_piket" required>
                                        <option value="" disabled>Pilih Hari Piket</option>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                        <option value="-">Tidak ada jadwal</option> <!-- Opsi Kosong yang bisa dipilih -->
                                    </select>
                                </div>                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Masukkan Password" required minlength="6">
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
    <!-- Bagian untuk pengecekan data guru -->
    @if($dataGuru->isNotEmpty()) <!-- Jika data guru tidak kosong -->
        <div class="accordion">
            <div class="accordion-item">
                <button class="accordion-trigger btn btn-dark w-100">DATA & AKUN GURU SMK NEGERI 1 KAWALI <span class="float-end"
                    style="font-weight: 500; margin-right: 20px; font-size: 11px; margin-top: 4px">
                    Jumlah Guru: {{ $totalGuru }}
                </span></button>
                <div class="accordion-content">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select_all" class="select_all"></th>
                                <th>NIP/NUPTK</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Mata Pelajaran</th>
                                <th>Tingkat</th>
                                <th>Program Keahlian</th>
                                <th>Hari Piket</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataGuru as $guru)
                                <tr>
                                    <td><input type="checkbox" name="hapus[]" class="checkbox_ids" value="{{ $guru->nip }}"></td>
                                    <td>{{ $guru->nip }}</td>
                                    <td>{{ $guru->nama }}</td>
                                    <td>{{ $guru->jk }}</td>
                                    <td>{{ $guru->mata_pelajaran }}</td>
                                    <td>{{ $guru->tingkat }}</td>
                                    <td>{{ $guru->program_keahlian }}</td>
                                    <td>{{ is_null($guru->hari_piket) ? '-' : $guru->hari_piket }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                    
                </div>
            </div>
        </div>
    @endif
    </main>
    {{-- DELETE - START --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select_all');
            const allCheckboxes = document.querySelectorAll('.checkbox_ids');

            // Event listener for "Select All"
            selectAllCheckbox.addEventListener('change', function() {
                allCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Event listener for individual checkboxes
            allCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    selectAllCheckbox.checked = Array.from(allCheckboxes).every(cb => cb.checked);
                });
            });

            // Function to delete selected data
            window.deleteSelected = function() {
                const checkedBoxes = document.querySelectorAll('input[name="hapus[]"]:checked');
                if (checkedBoxes.length === 0) {
                    alert('Tidak ada guru yang dipilih untuk dihapus.');
                    return;
                }

                if (confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')) {
                    // Membuat form dinamis untuk mengirim data
                    const deleteForm = document.createElement('form');
                    deleteForm.method = 'POST';
                    deleteForm.action = "{{ route('delete-guru') }}"; // Ganti dengan rute backend Anda

                    // Tambahkan token CSRF
                    const csrfTokenInput = document.createElement('input');
                    csrfTokenInput.type = 'hidden';
                    csrfTokenInput.name = '_token';
                    csrfTokenInput.value = "{{ csrf_token() }}";
                    deleteForm.appendChild(csrfTokenInput);

                    // Tambahkan metode penghapusan
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    deleteForm.appendChild(methodInput);

                    // Tambahkan data NIP guru yang dipilih
                    checkedBoxes.forEach(box => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'hapus[]';
                        input.value = box.value;
                        deleteForm.appendChild(input);
                    });

                    // Tambahkan form ke dalam body dan kirim
                    document.body.appendChild(deleteForm);
                    deleteForm.submit();
                }
            };
        });
    </script>

    {{-- DELETE - END --}}

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9gybOveo3f8VgJUvP5Vyn6pd56rOH1diJfqa0ksL8/4Oh3nybs0" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-pzjw8f+ua7Kw1TIq0uW9YrkQ+Q+97Jmf6fF3j1vSxtIhQczb1Y88aV6YQw0W6qHm" crossorigin="anonymous">
    </script>
</body>

</html>
