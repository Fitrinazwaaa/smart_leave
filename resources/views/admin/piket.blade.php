<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Piket</title>
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
        <button class="back-button" onclick="window.location.href='{{ route('dashboard.admin') }}';">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="logo">
            <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="Logo">
            <div>
                <h2>PIKET GURU SMK NEGERI 1 KAWALI</h2>
                <p class="sub-title">Kurikulum</p>
            </div>
        </div>
    </header>

    <script>
        // Shrink header on scroll
        window.addEventListener("scroll", function() {
            const header = document.querySelector("header");
            if (window.scrollY > 50) {
                header.classList.add("shrink");
            } else {
                header.classList.remove("shrink");
            }
        });
    </script>

    <div class="container">
        <!-- Header and Button Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0" style="font-weight: bold;">Manajemen Piket</h1>
            <div>
                <input type="radio" name="pekan" value="ganjil" id="pekanGanjil"> Pekan Ganjil
            </div>
            <div>
                <input type="radio" name="pekan" value="genap" id="pekanGenap"> Pekan Genap
            </div>
            <button id="btnHapusTerpilih" class="btn btn-danger">Hapus Terpilih</button>
        </div>

        <script>
            $(document).ready(function() {
                // Saat radio button pekan ganjil dipilih
                $('#pekanGanjil').change(function() {
                    if ($(this).prop('checked')) {
                        updatePekanStatus('ganjil'); // Kirim status pekan ganjil ke server
                    }
                });

                // Saat radio button pekan genap dipilih
                $('#pekanGenap').change(function() {
                    if ($(this).prop('checked')) {
                        updatePekanStatus('genap'); // Kirim status pekan genap ke server
                    }
                });

                // Fungsi untuk mengupdate status aktif berdasarkan pekan
                function updatePekanStatus(pekan) {
                    $.ajax({
                        url: '/admin/piket/update-pekan-status', // Ganti dengan URL endpoint yang sesuai
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // Pastikan csrf_token ditambahkan untuk keamanan
                            pekan: pekan
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('Status pekan berhasil diperbarui!');
                            } else {
                                alert('Gagal memperbarui status pekan!');
                            }
                        }
                    });
                }
            });
        </script>


        <script>
            $(document).ready(function() {
                // Menangani pemilihan radio button Pekan
                $('input[name="pekan"]').on('change', function() {
                    var pekanSelected = $(this).val();
                    filterTableByPekan(pekanSelected);
                });

                // Fungsi untuk memfilter tabel berdasarkan pekan yang dipilih
                function filterTableByPekan(pekan) {
                    $('#piketTable tbody tr').each(function() {
                        var rowPekan = $(this).find('td').eq(4).text().trim(); // Pekan ada di kolom ke-5 (index 4)
                        if (rowPekan === pekan || pekan === undefined) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }

                // Awalnya, tampilkan semua baris
                filterTableByPekan();
            });
        </script>

        <!-- Piket Table Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Daftar Piket</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="max-height: 320px;">
                    <table class="table table-bordered" id="piketTable">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Hari Piket</th>
                                <th>Pekan</th>
                                <th style="width: 20px;">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($piket as $item)
                            <tr>
                                <td class="text-center"><input type="checkbox" class="delete-checkbox" value="{{ $item->id }}"></td>
                                <td class="text-center">{{ $item->nip }}</td>
                                <td>{{ $item->nama }}</td>
                                <td class="text-center">{{ $item->hari_piket }}</td>
                                <td class="text-center">{{ $item->pekan }}</td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPiketModal" data-id="{{ $item->id }}" data-nip="{{ $item->nip }}" data-nama="{{ $item->nama }}" data-hari="{{ $item->hari_piket }}" data-pekan="{{ $item->pekan }}">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Select All checkbox functionality
                $('#selectAll').on('change', function() {
                    $('.delete-checkbox').prop('checked', this.checked);
                });

                // Delete selected piket
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
                                url: "{{ route('admin.piket.delete') }}",
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                data: {
                                    ids: ids
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire('Berhasil!', 'Data berhasil dihapus.', 'success')
                                            .then(() => location.reload());
                                    }
                                },
                                error: function() {
                                    Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>

        <!-- Form Tambah Piket Guru -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Tambah Piket Guru</h5>
            </div>
            <div class="card-body">
                <form id="formTambahPiket" method="POST" action="{{ route('admin.piket.store') }}">
                    @csrf <!-- Menambahkan token CSRF -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nip" class="form-label">NIP</label>
                            <select class="form-control" id="nip" name="nip" required>
                                <option value="">Pilih NIP</option>
                                <!-- NIP options will be populated here -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="hari_piket" class="form-label">Hari Piket</label>
                            <select class="form-control" id="hari_piket" name="hari_piket[]" required>
                                <option value="" disabled selected>Pilih Hari</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="pekan" class="form-label">Pekan</label>
                            <select class="form-control" id="pekan" name="pekan[]" required>
                                <option value="" disabled selected>Pilih Pekan</option>
                                <option value="ganjil">Ganjil</option>
                                <option value="genap">Genap</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Fetch NIP list and populate the dropdown
                $.ajax({
                    url: "{{ route('get.guru.list') }}",
                    method: 'GET',
                    success: function(response) {
                        response.forEach(function(guru) {
                            $('#nip').append('<option value="' + guru.nip + '">' + guru.nip + '</option>');
                        });
                    }
                });

                // When NIP is selected, fetch and display the corresponding Nama
                $('#nip').change(function() {
                    const nip = $(this).val();
                    if (nip) {
                        $.ajax({
                            url: "{{ route('get.nama.by.nip') }}",
                            method: 'GET',
                            data: {
                                nip: nip
                            },
                            success: function(response) {
                                $('#nama').val(response.nama); // Populate Nama field
                            },
                            error: function() {
                                $('#nama').val('NIP tidak ditemukan');
                            }
                        });
                    } else {
                        $('#nama').val('');
                    }
                });
            });
        </script>

        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Piket Guru</title>
            <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Token CSRF -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>

        <body>

            <!-- Modal Edit Piket -->
            <div class="modal fade" id="editPiketModal" tabindex="-1" aria-labelledby="editPiketModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPiketModalLabel">Edit Piket Guru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formEditPiket">
                                @csrf <!-- Laravel CSRF Token -->
                                <input type="hidden" id="edit_id" name="id">
                                <div class="mb-3">
                                    <label for="edit_nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="edit_nip" name="nip" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="edit_nama" name="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_hari_piket" class="form-label">Hari Piket</label>
                                    <select class="form-control" id="edit_hari_piket" name="hari_piket[]" required>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_pekan" class="form-label">Pekan</label>
                                    <select class="form-control" id="edit_pekan" name="pekan[]" required>
                                        <option value="ganjil">ganjil</option>
                                        <option value="genap">genap</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Spinner Loading -->
            <div id="loadingSpinner" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    // Setup token CSRF untuk semua AJAX request
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    // Klik tombol Edit
                    $('body').on('click', '.btn-warning', function() {
                        const row = $(this).closest('tr');
                        $('#edit_id').val(row.find('input.delete-checkbox').val());
                        $('#edit_nip').val(row.find('td:nth-child(2)').text().trim());
                        $('#edit_nama').val(row.find('td:nth-child(3)').text().trim());

                        let hariPiket = row.find('td:nth-child(4)').text().trim().split(', ');
                        let pekan = row.find('td:nth-child(5)').text().trim().split(', ');

                        $('#edit_hari_piket').val(hariPiket).trigger('change');
                        $('#edit_pekan').val(pekan).trigger('change');

                        $('#editPiketModal').modal('show');
                    });

                    // Submit Form Edit
                    $('#formEditPiket').submit(function(e) {
                        e.preventDefault();
                        $('#loadingSpinner').show();

                        const id = $('#edit_id').val();
                        $.ajax({
                            url: '/admin/piket/update/' + id,
                            method: 'POST',
                            data: $(this).serialize(),
                            success: function(response) {
                                $('#loadingSpinner').hide();
                                if (response.success) {
                                    Swal.fire('Berhasil!', response.message, 'success').then(() => location.reload());
                                } else {
                                    Swal.fire('Gagal!', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                $('#loadingSpinner').hide();
                                Swal.fire('Gagal!', 'Terjadi kesalahan: ' + xhr.responseJSON.message, 'error');
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