<?php

use App\Models\AkunGuru;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Carbon::setLocale('id');
$nip = Auth::user()->nip;  // Mendapatkan nip dari user yang sedang login
$guru = AkunGuru::where('nip', $nip)->first();
// Ambil data pengguna dari tabel akun_guru berdasarkan NIP
$akunGuru = DB::table('akun_guru')->where('nip', $nip)->first();

if (!$guru) {
    // Jika guru tidak ditemukan, tampilkan error atau redirect
    return redirect()->route('login')->withErrors(['error' => 'Guru tidak ditemukan.']);
}

use App\Models\PiketGuru;

$piketGuru = PiketGuru::all();
$totalGuru = AkunGuru::count(); // Hitung jumlah guru
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Dispensasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            background: linear-gradient(to bottom, #ffffff, #f3f4f7);
            background-image: url('https://www.transparenttextures.com/patterns/asfalt-dark.png');
            background-attachment: fixed;
            /* Membuat latar belakang tetap */
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


        .container {
            max-width: 1160px;
            margin: 90px auto 0;
            padding: 30px;
        }

        th {
            font-size: 14px;
        }

        td {
            font-size: 12px;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                padding: 10px;
                position: fixed;
            }

            header .back-button {
                position: absolute;
                /* Pindahkan button dengan posisi absolute */
                top: 10px;
                /* Jarak dari atas */
                left: 10px;
                /* Jarak dari kiri */
                margin: 0;
                /* Hilangkan margin default */
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

            .container {
                margin: 130px auto 0;
                padding: 20px;
                border-radius: 8px;
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <header>
        <button class="back-button" onclick="window.location.href='{{ route('dashboard.guru') }}';">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="logo">
            <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="Logo">
            <div>
                <h2>DISPENSASI DIGITAL SMK NEGERI 1 KAWALI</h2>
                <p class="sub-title">{{ $guru->nama }}</p>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">
        <!-- Judul -->
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Jadwal Guru Piket</h1>

        <!-- Kategori: Keluar Lingkungan Sekolah -->
        <div class="mb-10 kategori">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class=" font-semibold text-gray-800 border-b pb-4 mb-4" style="margin-top: -2px; padding-bottom: 9px; font-size: 20px; ">Pekan Ganjil</h2>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="px-4 py-2 text-center">Senin</th>
                                <th class="px-4 py-2 text-center">Selasa</th>
                                <th class="px-4 py-2 text-center">Rabu</th>
                                <th class="px-4 py-2 text-center">Kamis</th>
                                <th class="px-4 py-2 text-center">Jumat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $maxRows = max(
                            $piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Senin')->count(),
                            $piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Selasa')->count(),
                            $piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Rabu')->count(),
                            $piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Kamis')->count(),
                            $piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Jumat')->count(),
                            );
                            @endphp

                            @for ($i = 0; $i < $maxRows; $i++)
                                <tr class="hover:bg-gray-50 border-b">
                                <td class="px-4 py-2 text-center">{{ optional($piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Senin')->values()->get($i))->nama ?? '' }}</td>
                                <td class="px-4 py-2 text-center">{{ optional($piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Selasa')->values()->get($i))->nama ?? '' }}</td>
                                <td class="px-4 py-2 text-center">{{ optional($piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Rabu')->values()->get($i))->nama ?? '' }}</td>
                                <td class="px-4 py-2 text-center">{{ optional($piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Kamis')->values()->get($i))->nama ?? '' }}</td>
                                <td class="px-4 py-2 text-center">{{ optional($piketGuru->where('pekan', 'ganjil')->where('hari_piket', 'Jumat')->values()->get($i))->nama ?? '' }}</td>
                                </tr>
                                @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mb-10 kategori" style="margin-top: -15px;">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class=" font-semibold text-gray-800 border-b pb-4 mb-4" style="margin-top: -2px; padding-bottom: 9px; font-size: 20px; ">Pekan Genap</h2>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="px-4 py-2 text-center">Senin</th>
                                <th class="px-4 py-2 text-center">Selasa</th>
                                <th class="px-4 py-2 text-center">Rabu</th>
                                <th class="px-4 py-2 text-center">Kamis</th>
                                <th class="px-4 py-2 text-center">Jumat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $maxRows = max(
                            $piketGuru->where('pekan', 'genap')->where('hari_piket', 'Senin')->count(),
                            $piketGuru->where('pekan', 'genap')->where('hari_piket', 'Selasa')->count(),
                            $piketGuru->where('pekan', 'genap')->where('hari_piket', 'Rabu')->count(),
                            $piketGuru->where('pekan', 'genap')->where('hari_piket', 'Kamis')->count(),
                            $piketGuru->where('pekan', 'genap')->where('hari_piket', 'Jumat')->count(),
                            );
                            @endphp

                            @for ($i = 0; $i < $maxRows; $i++)
                                <tr class="hover:bg-gray-50 border-b">
                                <td class="px-4 py-2 text-center">{{ optional($piketGuru->where('pekan', 'genap')->where('hari_piket', 'Senin')->values()->get($i))->nama ?? '' }}</td>
                                <td class="px-4 py-2 text-center">{{ optional($piketGuru->where('pekan', 'genap')->where('hari_piket', 'Selasa')->values()->get($i))->nama ?? '' }}</td>
                                <td class="px-4 py-2 text-center">{{ optional($piketGuru->where('pekan', 'genap')->where('hari_piket', 'Rabu')->values()->get($i))->nama ?? '' }}</td>
                                <td class="px-4 py-2 text-center">{{ optional($piketGuru->where('pekan', 'genap')->where('hari_piket', 'Kamis')->values()->get($i))->nama ?? '' }}</td>
                                <td class="px-4 py-2 text-center">{{ optional($piketGuru->where('pekan', 'genap')->where('hari_piket', 'Jumat')->values()->get($i))->nama ?? '' }}</td>
                                </tr>
                                @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybOveo3f8VgJUvP5Vyn6pd56rOH1diJfqa0ksL8/4Oh3nybs0" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0uW9YrkQ+Q+97Jmf6fF3j1vSxtIhQczb1Y88aV6YQw0W6qHm" crossorigin="anonymous"></script>
</body>

</html>