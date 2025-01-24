<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun Kurikulum</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            background: #030248;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .card {
            background: #ffffff;
            color: #030248;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .card-header {
            background: #030248;
            color: white;
            text-align: center;
            font-size: 1.6rem;
            font-weight: bold;
            padding: 20px;
            border-radius: 15px 15px 0 0;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 500;
            color: #030248;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 15px;
            padding: 12px;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #030248;
            box-shadow: 0 0 5px rgba(3, 2, 72, 0.5);
            outline: none;
        }

        .btn-primary {
            background: #030248;
            border: none;
            padding: 12px 18px;
            font-size: 1rem;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
            border-radius: 10px;
            width: 100%;
            transition: background 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background: #020140;
        }

        .alert {
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #842029;
        }

        @media (max-width: 768px) {
            .card {
                padding: 15px;
                width: 90%;
            }

            .card-header {
                font-size: 1.4rem;
                padding: 15px;
            }

            .form-control {
                padding: 10px;
                font-size: 0.9rem;
            }

            .btn-primary {
                padding: 12px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            Pengaturan Akun Kurikulum
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="accountForm" action="{{ url('/admin/pengaturan/update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ auth()->id() }}">
                
                <div class="form-group mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control"
                        value="{{ old('username', auth()->user()->username) }}" required>
                </div>
            
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password Baru (opsional)</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
            
                <div class="form-group mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control">
                </div>
            
                <button type="submit" class="btn btn-primary">Perbarui Akun</button>
            </form>            
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#accountForm').submit(function (e) {
                e.preventDefault();  // Prevent form submission for manual handling
    
                var form = $(this);
                var data = form.serialize();
                $('#loadingSpinner').show();
    
                // Use AJAX to submit the form
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: data,
                    success: function (response) {
                        $('#loadingSpinner').hide();
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data akun berhasil diperbarui.',
                            icon: 'success',
                            timer: 4000,  // Notifikasi akan hilang setelah 4 detik
                            timerProgressBar: true,
                            willClose: () => {
                                location.reload();  // Reload the page or redirect if needed
                            }
                        });
                    },
                    error: function (response) {
                        $('#loadingSpinner').hide();
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat memperbarui akun.',
                            icon: 'error',
                            timer: 4000,  // Notifikasi akan hilang setelah 4 detik
                            timerProgressBar: true
                        });
                    }
                });
            });
        });
    </script>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.js"></script>
</body>
</html>
