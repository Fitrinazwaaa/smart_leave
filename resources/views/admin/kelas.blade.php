<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Kelas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEJb3RrP6j1eg84BQ2erfFPLBaZrj1I1NE9FYkCOs5TtZUSSHjGZbmL8HjzqP" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin/kelas.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
        <button class="back-button" onclick="window.location.href='{{ route('kelasSiswa') }}';">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="logo">
            <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="Logo">
            <div>
                <h2>KELAS SMK NEGERI 1 KAWALI</h2>
                <p class="sub-title">Kurikulum</p>
            </div>
        </div>
    </header>

    <script>
        // Tambahkan event listener untuk perubahan scroll
        window.addEventListener("scroll", function () {
            const header = document.querySelector("header");
            if (window.scrollY > 50) {
                header.classList.add("shrink");
            } else {
                header.classList.remove("shrink");
            }
        });
    </script>
    
    <div class="container">
        <!-- Judul dan Tombol Aksi -->
        <div class="d-flex justify-content-between align-items-center mb-20">
            <h1 class="mb-4" style="font-weight: bold;">Manajemen Kelas</h1>
            <button id="btnHapusTerpilih" class="btn btn-danger" style="border-radius: 6px;">Hapus</button>
        </div>

        <!-- Tabel Data Kelas -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Daftar Kelas</h5>
            </div>
            <div class="card-body">
                <!-- Membungkus tabel dengan div yang memiliki scroll -->
                <div style="max-height: 320px; overflow-y: auto; overflow-x: auto;">
                    <table class="table table-bordered" id="kelasTable">
                        <thead style="position: sticky; top: 0; z-index: 2; background-color: #f8f9fa; color: #212529; border-top: 3px solid #dee2e6;">
                            <tr style="text-align: center; font-weight: bold;">
                                <th style="padding: 10px;"><input type="checkbox" id="selectAll"></th>
                                <th style="padding: 10px;">Program Keahlian</th>
                                <th style="padding: 10px;">Konsentrasi Keahlian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelas as $item)
                                <tr>
                                    <td style="text-align: center;"><input type="checkbox" class="delete-checkbox" value="{{ $item->id }}"></td>
                                    <td>{{ $item->program_keahlian }}</td>
                                    <td style="text-align: center;">{{ $item->konsentrasi_keahlian }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>            

        <!-- Form Tambah Kelas -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Tambah Kelas</h5>
            </div>
            <div class="card-body">
                <form id="formTambahKelas">
                    <div class="mb-3">
                        <label for="programKeahlian" class="form-label">Program Keahlian</label>
                        <input type="text" class="form-control" id="programKeahlian" name="program_keahlian"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="konsentrasiKeahlian" class="form-label">Konsentrasi Keahlian (<i
                                style="color: #030248; font-size: 12px;">contoh : RPL 1, RPL 2, RPL 3</i>)</label>
                        <input type="text" class="form-control" id="konsentrasiKeahlian" name="konsentrasi_keahlian"
                            required>
                    </div>
                    <!-- Menggunakan d-flex dan justify-content-end untuk meratakan tombol ke kanan -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>

            </div>
        </div>

        <!-- Spinner Loading -->
        <div id="loadingSpinner" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Pilih semua checkbox
            $('#selectAll').on('change', function() {
                $('.delete-checkbox').prop('checked', this.checked);
            });

            // Form tambah kelas
            $('#formTambahKelas').on('submit', function(e) {
                e.preventDefault();

                const programKeahlian = $('#programKeahlian').val();
                const konsentrasiKeahlian = $('#konsentrasiKeahlian').val().split(',');

                $.ajax({
                    url: '{{ route('kelas.store') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        program_keahlian: programKeahlian,
                        konsentrasi_keahlian: konsentrasiKeahlian,
                    },
                    beforeSend: function() {
                        $('#loadingSpinner').show();
                    },
                    success: function(response) {
                        $('#loadingSpinner').hide();
                        if (response.success) {
                            Swal.fire('Berhasil!', 'Data kelas berhasil ditambahkan.',
                                    'success')
                                .then(() => location.reload());
                        }
                    },
                    error: function(xhr) {
                        $('#loadingSpinner').hide();
                        Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                    }
                });
            });

            // Hapus kelas terpilih
            $('#btnHapusTerpilih').on('click', function() {
                const ids = $('.delete-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (ids.length === 0) {
                    Swal.fire('Peringatan!', 'Pilih data yang ingin dihapus.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('kelas.destroy') }}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                ids: ids
                            },
                            beforeSend: function() {
                                $('#loadingSpinner').show();
                            },
                            success: function(response) {
                                $('#loadingSpinner').hide();
                                if (response.success) {
                                    Swal.fire('Berhasil!', 'Data berhasil dihapus.',
                                            'success')
                                        .then(() => location.reload());
                                }
                            },
                            error: function() {
                                $('#loadingSpinner').hide();
                                Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
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
