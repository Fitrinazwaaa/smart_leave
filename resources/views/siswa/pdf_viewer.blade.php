<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viewer PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }
        iframe {
            width: 100%;
            height: 600px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .button-container {
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            margin: 10px;
            padding: 12px 18px;
            font-size: 16px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #bb2d3b;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Tombol Navigasi -->
        <div class="button-container">
            <a href="{{ route('dashboard.siswa') }}" class="btn btn-danger">Kembali ke Dashboard</a>
            <a href="{{ route('dispensasi.pdfDownload') }}" class="btn btn-primary">Unduh PDF</a>
        </div>

        <!-- Pratinjau PDF -->
        <h2>Pratinjau PDF</h2>
        <iframe id="pdfViewer" src="{{ $fullPath }}" allowfullscreen></iframe>
    </div>

</body>
</html>
