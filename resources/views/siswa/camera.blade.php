<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambil Foto Dispensasi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            color: #333;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        p {
            font-size: 1rem;
            margin-bottom: 15px;
            color: #555;
        }

        video {
            width: 100%;
            border: 2px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        img {
            display: none;
            margin-top: 10px;
            width: 100%;
            border: 2px solid #ddd;
            border-radius: 8px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #3498db;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-success {
            background-color: #2ecc71;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 1.5rem;
            }

            p {
                font-size: 0.9rem;
            }

            .btn {
                font-size: 0.9rem;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Ambil Foto untuk Dispensasi</h1>
    <p><strong>Nama:</strong> {{ $dispensasi->nama }}</p>
    <p><strong>Kategori:</strong> {{ $dispensasi->kategori }}</p>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if($dispensasi->waktu_kembali) <!-- Jika sudah ada waktu kembali -->
        <p class="alert alert-info">Foto sudah dikirim, kamera dinonaktifkan.</p>
    @else
        <!-- Kamera -->
        <video id="camera" autoplay></video>
        <img id="preview" alt="Foto yang diambil">

        <!-- Tombol Ambil Foto -->
        <button id="captureButton" class="btn btn-primary">Ambil Foto</button>

        <!-- Form untuk upload -->
        <form id="photoForm" action="{{ route('dispensasi.submitPhoto', ['id' => $dispensasi->id_dispen]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" id="photoInput" name="photo" accept="image/*" style="display: none;">
            <button type="submit" class="btn btn-success" style="display: none;" id="submitPhotoButton">Unggah Foto</button>
        </form>
    @endif
</div>


    <script>
        const video = document.getElementById('camera');
        const preview = document.getElementById('preview');
        const captureButton = document.getElementById('captureButton');
        const photoInput = document.getElementById('photoInput');
        const submitPhotoButton = document.getElementById('submitPhotoButton');

        // Aktifkan kamera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(error => {
                console.error('Error accessing camera: ', error);
            });

        // Ambil foto
        captureButton.addEventListener('click', () => {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Convert canvas ke file data URL
            const dataUrl = canvas.toDataURL('image/jpeg');

            // Tampilkan preview gambar
            preview.src = dataUrl;
            preview.style.display = 'block';

            // Convert data URL ke file dan masukkan ke input file
            fetch(dataUrl)
                .then(res => res.blob())
                .then(blob => {
                    const file = new File([blob], 'photo.jpg', { type: 'image/jpeg' });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    photoInput.files = dataTransfer.files;

                    // Tampilkan tombol unggah
                    submitPhotoButton.style.display = 'block';
                });
        });
    </script>
</body>
</html>
