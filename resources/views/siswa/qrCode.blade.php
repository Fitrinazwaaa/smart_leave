<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporkan Kembali - SMK NEGERI 1 KAWALI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
</head>
<body>

    <header class="bg-primary text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo d-flex align-items-center">
                <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="Logo" width="50" class="me-2">
                <h2 class="mb-0">Laporkan Kembali</h2>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </header>

    <main class="container mt-4">
        <h3 class="mb-4">Scan QR Code untuk Melaporkan Kembali</h3>

        <!-- Tampilan Kamera untuk Scan QR Code -->
        <div id="reader" style="width: 100%; height: 300px;"></div>

        <!-- Formulir Laporkan Kembali -->
        <form id="formReturn" action="{{ route('dispensasi.storeReturn', $dispensasi->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="waktu_kembali" class="form-label">Waktu Kembali</label>
                <input type="datetime-local" class="form-control" id="waktu_kembali" name="waktu_kembali" required>
            </div>

            <button type="submit" class="btn btn-primary">Laporkan Kembali</button>
        </form>

        <script>
            function onScanSuccess(decodedText, decodedResult) {
                // Mengambil ID dispensasi dari QR Code yang dipindai
                let urlParams = new URLSearchParams(decodedText);
                let id = urlParams.get('id');

                // Set ID dispensasi pada form
                document.getElementById('formReturn').action = '/dispensasi/' + id + '/lapor-kembali';
            }

            let html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start(
                { facingMode: "environment" }, // Pilih kamera belakang
                {
                    fps: 10,    // frame per second
                    qrbox: 250  // ukuran pemindaian
                },
                onScanSuccess
            );
        </script>
    </main>

    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center">
            <p>&copy; 2025 SMK Negeri 1 Kawali | All Rights Reserved</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
