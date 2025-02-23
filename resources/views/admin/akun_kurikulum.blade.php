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
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJb3RrP6j1eg84BQ2erfFPLBaZrj1I1NE9FYkCOs5TtZUSSHjGZbmL8HjzqP" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Global Style */
        html,
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            overscroll-behavior: none;
            background: #030248;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        /* Header Style */
        header {
            position: fixed;
            width: 100%;
            top: 0;
            display: flex;
            justify-content: flex-start;
            /* Align items to the start */
            align-items: center;
            /* Vertically center the content */
            padding: 15px;
            background: linear-gradient(90deg, #030248, #4b6cb7);
            color: white;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            border-bottom: 3px solid #dce400;
            transition: all 0.3s ease;
        }

        header:hover {
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.4);
        }

        /* Back Button Styling (Arrow only) */
        header .back-button {
            margin-left: 40px;
            margin-right: 20px;
            background-color: transparent;
            border: none;
            padding: 8px;
            font-size: 20px;
            color: white;
            cursor: pointer;
            transition: transform 0.3s ease, color 0.3s ease;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0;
            /* Ensure no space between button and icon */
        }

        header .back-button i {
            font-size: 20px;
            margin: 0;
            /* Ensure no extra space around the icon */
            transition: transform 0.3s ease, color 0.3s ease;
        }

        /* Hover effect */
        header .back-button:hover {
            transform: scale(1.1);
            color: #dce400;
            /* Change to gold color on hover */
        }

        /* Focus effect */
        header .back-button:focus {
            outline: none;
            transform: scale(1.1);
        }

        /* Logo Styling */
        header .logo {
            display: flex;
            align-items: center;
            /* Align logo vertically in the center */
            justify-content: center;
            /* Center content horizontally */
            gap: 16px;
        }

        header .logo img {
            width: 70px;
            height: 70px;
            padding: 5px;
            border-radius: 50%;
            border: 3px solid white;
        }

        header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
            /* Adjust line height to improve vertical centering */
        }

        header .sub-title {
            margin: 0;
            font-size: 14px;
            color: #dce400;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }
        @media (max-width: 768px) {
      header {
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 10px;
        position: fixed; /* Tambahkan fixed untuk posisi child absolute */
      }
    
      header .back-button {
        position: absolute; /* Pindahkan button dengan posisi absolute */
        top: 10px; /* Jarak dari atas */
        left: 10px; /* Jarak dari kiri */
        margin: 0; /* Hilangkan margin default */
        font-size: 16px;
        width: 40px;
        height: 40px;
      }
    
      header .logo {
        flex-direction: column;
        gap: 10px;
      }
    
      header .logo img {
        width: 60px;
        height: 60px;
      }
    
      header h2 {
        font-size: 20px;
      }
    
      header .sub-title {
        font-size: 12px;
      }
    }

        .card {
            margin: 130px auto 50px;
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
                margin : 10px;
                padding: 15px;
                width: 824px;
                height : 520px;
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
                margin-top: 30px;
                padding: 12px;
                font-size: 0.9rem;
            }
        }
    </style>
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
