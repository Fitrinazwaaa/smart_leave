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
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">History Dispensasi</h1>

        <!-- Filter -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="font-semibold text-gray-800 border-b pb-4 mb-4 text-xs"
                style="margin-top: -2px; padding-bottom: 9px; font-size: 20px;">Filter Data</h2>
            <form method="GET" action="{{ route('historyGuru') }}" class="flex flex-wrap items-center gap-4 text-xs">
                <!-- Waktu -->
                <div class="w-1/6 min-w-[150px]">
                    <label for="waktu" class="font-medium text-gray-600 mb-1 block">Waktu</label>
                    <select name="waktu" id="waktu"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
                        <option value="semua">Semua</option>
                        <option value="kemarin">Kemarin</option>
                        <option value="1 minggu">1 Minggu Terakhir</option>
                        <option value="1 bulan">1 Bulan Terakhir</option>
                        <option value="1 tahun">1 Tahun Terakhir</option>
                    </select>
                </div>
                <!-- Kelas -->
                <div class="w-1/6 min-w-[150px]">
                    <label for="kelas" class="font-medium text-gray-600 mb-1 block">Kelas</label>
                    <select name="kelas" id="kelas"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
                        <option value="">Semua Kelas</option>
                        @foreach($daftar_kelas as $kelas)
                        <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Jenis Kelamin -->
                <div class="w-1/6 min-w-[150px]">
                    <label for="jenis_kelamin" class="font-medium text-gray-600 mb-1 block">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
                        <option value="">Semua</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <!-- Nama -->
                <div class="w-1/6 min-w-[150px]">
                    <label for="nama" class="font-medium text-gray-600 mb-1 block">Nama</label>
                    <input type="text" name="nama" id="nama" placeholder="Nama Siswa"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
                </div>
                <!-- NIS -->
                <div class="w-1/6 min-w-[150px]">
                    <label for="nis" class="font-medium text-gray-600 mb-1 block">NIS</label>
                    <input type="text" name="nis" id="nis" placeholder="NIS Siswa"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
                </div>
                <!-- Tombol Filter -->
                <div class="w-auto self-end">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs">
                        Filter
                    </button>
                </div>
            </form>
        </div>




        <!-- Kategori: Keluar Lingkungan Sekolah -->
        <div id="keluar-sekolah" class="mb-10 kategori">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class=" font-semibold text-gray-800 border-b pb-4 mb-4" style="margin-top: -2px; padding-bottom: 9px; font-size: 20px; ">Keluar Lingkungan Sekolah</h2>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="px-4 py-2 text-center">NIS</th>
                                <th class="px-4 py-2 text-left">Nama</th>
                                <th class="px-4 py-2 text-center" style="width: 100px">Kelas</th>
                                <th class="px-4 py-2 text-center">Jenis Kelamin</th>
                                <th class="px-4 py-2 text-left">Alasan</th>
                                <th class="px-4 py-2 text-center">Waktu Keluar</th>
                                <th class="px-4 py-2 text-center">Waktu Kembali</th>
                                <th class="px-4 py-2 text-center" style="width: 100px">Status</th>
                                <th class="px-4 py-2 text-center">Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($keluar_sekolah as $data)
                            <tr class="hover:bg-gray-50 border-b">
                                <td class="px-4 py-2 text-center">{{ $data->nis }}</td>
                                <td class="px-4 py-2 text-left">{{ $data->nama }}</td>
                                <td class="px-4 py-2 text-center">{{ $data->tingkatan }} {{ $data->konsentrasi_keahlian }}</td>
                                <td class="px-4 py-2 text-center">{{ $data->jk === 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                                <td class="px-4 py-2 text-left">{{ $data->alasan }}</td>
                                <td class="px-4 py-2 text-center">{{ $data->waktu_keluar }}</td>
                                <td class="px-4 py-2 text-center">{{ $data->waktu_kembali ?? 'Belum Kembali' }}</td>
                                <td class="px-4 py-2 text-center">
                                    {{-- Konfirmasi 1 --}}
                                    @php
                                    $konfirmasi1 = $data->konfirmasi->whereNotNull('konfirmasi_1')->first();
                                    @endphp
                                    {!! $konfirmasi1 ? '<span><i class="bi bi-check-circle-fill text-success"></i></span>' : '<span><i class="bi bi-dash-circle-fill text-secondary"></i></span>' !!}

                                    {{-- Konfirmasi 2 --}}
                                    @php
                                    $konfirmasi2 = $data->konfirmasi->whereNotNull('konfirmasi_2')->first();
                                    @endphp
                                    {!! $konfirmasi2 ? '<span><i class="bi bi-check-circle-fill text-success"></i></span>' : '<span><i class="bi bi-dash-circle-fill text-secondary"></i></span>' !!}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    @if($data->bukti_foto)
                                    <button class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700" onclick="showImage('{{ asset('storage/' . $data->bukti_foto) }}')">Lihat</button>
                                    @else
                                    <span class="text-gray-500">Tidak ada foto</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kategori: Mengikuti Kegiatan -->
        <div id="kegiatan" class="mb-10 kategori" style="margin-top: -15px;">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class=" font-semibold text-gray-800 border-b pb-4 mb-4" style="margin-top: -2px; padding-bottom: 9px; font-size: 20px; ">Mengikuti Kegiatan</h2>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="px-4 py-2 text-center">NIS</th>
                                <th class="px-4 py-2 text-left">Nama</th>
                                <th class="px-4 py-2 text-center" style="width: 100px">Kelas</th>
                                <th class="px-4 py-2 text-center">Jenis Kelamin</th>
                                <th class="px-4 py-2 text-left">Alasan</th>
                                <th class="px-4 py-2 text-center">Waktu Keluar</th>
                                <th class="px-4 py-2 text-center" style="width: 100px">Status</th>
                                <th class="px-4 py-2 text-center">Bukti Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mengikuti_kegiatan as $data)
                            <tr class="hover:bg-gray-50 border-b">
                                <td class="px-4 py-2 text-center">{{ $data->nis }}</td>
                                <td class="px-4 py-2 text-left">{{ $data->nama }}</td>
                                <td class="px-4 py-2 text-center">{{ $data->tingkatan }} {{ $data->konsentrasi_keahlian }}</td>
                                <td class="px-4 py-2 text-center">{{ $data->jk === 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                                <td class="px-4 py-2 text-left">{{ $data->alasan }}</td>
                                <td class="px-4 py-2 text-center">{{ $data->waktu_keluar }}</td>
                                <td class="px-4 py-2 text-center">
                                    {{-- Konfirmasi 1 --}}
                                    @php
                                    $konfirmasi1 = $data->konfirmasi->whereNotNull('konfirmasi_1')->first();
                                    @endphp
                                    {!! $konfirmasi1 ? '<span><i class="bi bi-check-circle-fill text-success"></i></span>' : '<span><i class="bi bi-dash-circle-fill text-secondary"></i></span>' !!}

                                    {{-- Konfirmasi 2 --}}
                                    @php
                                    $konfirmasi2 = $data->konfirmasi->whereNotNull('konfirmasi_2')->first();
                                    @endphp
                                    {!! $konfirmasi2 ? '<span><i class="bi bi-check-circle-fill text-success"></i></span>' : '<span><i class="bi bi-dash-circle-fill text-secondary"></i></span>' !!}

                                    {{-- Konfirmasi 3 --}}
                                    @php
                                    $konfirmasi3 = $data->konfirmasi->whereNotNull('konfirmasi_3')->first();
                                    @endphp
                                    {!! $konfirmasi3 ? '<span><i class="bi bi-check-circle-fill text-success"></i></span>' : '<span><i class="bi bi-dash-circle-fill text-secondary"></i></span>' !!}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    @if($data->bukti_foto)
                                    <button class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700" onclick="showImage('{{ asset('storage/' . $data->bukti_foto) }}')">Lihat</button>
                                    @else
                                    <span class="text-gray-500">Tidak ada foto</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Foto -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <img id="modalImage" src="" class="max-w-md rounded-lg" width="350px">
            <button onclick="closeImage()" class="block mx-auto mt-4 bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600">Tutup</button>
        </div>
    </div>

    <script>
        function filterKategori() {
            const selected = document.getElementById('filter').value;
            const categories = document.querySelectorAll('.kategori');

            categories.forEach(category => {
                if (selected === 'all' || category.id === selected) {
                    category.style.display = 'block';
                } else {
                    category.style.display = 'none';
                }
            });
        }

        function showImage(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImage() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>

    <!-- Bootstrap 5 JS and Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybOveo3f8VgJUvP5Vyn6pd56rOH1diJfqa0ksL8/4Oh3nybs0" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0uW9YrkQ+Q+97Jmf6fF3j1vSxtIhQczb1Y88aV6YQw0W6qHm" crossorigin="anonymous"></script>
</body>

</html>