<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
  <!-- Modal - SISWA -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1" onclick="setFormForSiswa()">
    SISWA
  </button>

  <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="container">
            <div class="card-container">
              <div class="card">
                <div class="logo">
                  <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="SMK Logo" class="logo-img">
                </div>
        
                <div class="title-container">
                  <div class="title-bg">
                    <h1 class="title">DISPENSASI</h1>
                    <h1 class="title">SMK NEGERI 1 KAWALI</h1>
                  </div>
                </div>
        
                <form action="{{ route('login.post') }}" method="POST" class="form">
                  @csrf
                  <div class="input-group">
                      <label for="userId" class="label">NIS Pengguna</label>
                      <input type="text" name="userId" id="userId" class="input-field" required>
                  </div>
              
                  <div class="input-group">
                      <label for="password" class="label">Kata Sandi</label>
                      <input type="password" name="password" id="password" class="input-field" required>
                  </div>
              
                  <button type="submit" class="submit-btn">MASUK</button>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal - GURU -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal2" onclick="setFormForGuru()">
    GURU
  </button>

  <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="container">
            <div class="card-container">
              <div class="card">
                <div class="logo">
                  <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="SMK Logo" class="logo-img">
                </div>
        
                <div class="title-container">
                  <div class="title-bg">
                    <h1 class="title">DISPENSASI</h1>
                    <h1 class="title">SMK NEGERI 1 KAWALI</h1>
                  </div>
                </div>
        
                <form action="{{ route('login.post') }}" method="POST" class="form">
                  @csrf
                  <div class="input-group">
                      <label for="userId" class="label">NIP Pengguna</label>
                      <input type="text" name="userId" id="userId" class="input-field" required>
                  </div>
              
                  <div class="input-group">
                      <label for="password" class="label">Kata Sandi</label>
                      <input type="password" name="password" id="password" class="input-field" required>
                  </div>
              
                  <button type="submit" class="submit-btn">MASUK</button>
              </form>
              
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
function setFormForSiswa() {
    document.getElementById('userId').name = 'nis'; // Set name menjadi 'nis' untuk Siswa
    document.getElementById('userId').id = 'nis'; // Set id menjadi 'nis'
    document.getElementById('password').name = 'password'; // Password tetap 'password'
}

function setFormForGuru() {
    document.getElementById('userId').name = 'nip'; // Set name menjadi 'nip' untuk Guru
    document.getElementById('userId').id = 'nip'; // Set id menjadi 'nip'
    document.getElementById('password').name = 'password'; // Password tetap 'password'
}

  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
