<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css"> -->
     <style>
      body {
  font-family: 'Inter', sans-serif;
  background: linear-gradient(135deg, #89f7fe, #66a6ff);
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0;
  background-image: url('https://www.transparenttextures.com/patterns/bright-squares.png');
  background-size: cover;
  color: #333;
}

.container {
  max-width: 400px;
  width: 100%;
  background: rgba(255, 255, 255, 0.9);
  padding: 20px;
  border-radius: 15px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.logo {
  text-align: center;
  margin-bottom: 20px;
}

.logo img {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.title-container {
  text-align: center;
  margin-bottom: 30px;
}

.title {
  font-size: 24px;
  font-weight: 700;
  color: #1A202C;
}

.role-selection {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}

.role-selection-btn {
  flex: 1;
  height: 45px;
  background-color: #1A202C;
  color: #fff;
  font-size: 16px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.role-selection-btn:hover {
  background-color: #333;
}

.form-container {
  display: none;
}

.form-container.active {
  display: block;
}

.input-group {
  margin-bottom: 15px;
}

.input-group label {
  font-size: 14px;
  font-weight: 600;
  color: #333;
  margin-bottom: 5px;
  display: block;
}

.input-group input {
  width: 100%;
  height: 40px;
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 14px;
  color: #333;
  transition: border-color 0.3s ease;
}

.input-group input:focus {
  border-color: #1A202C;
  outline: none;
}

.submit-btn {
  width: 100%;
  height: 45px;
  background-color: #1A202C;
  color: white;
  font-weight: 600;
  font-size: 16px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.submit-btn:hover {
  background-color: #333;
}

.alert {
  margin-top: 20px;
  text-align: center;
  padding: 15px;
  border-radius: 5px;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
}

@media (max-width: 480px) {
  .role-selection-btn {
    font-size: 14px;
  }

  .submit-btn {
    font-size: 14px;
  }
}

     </style>
</head>

<body>
  <div class="container">
    <!-- Notifikasi sukses atau error -->
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    
    <div class="logo">
      <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="Logo">
    </div>
    <div class="title-container">
      <h1 class="title">DISPENSASI</h1>
      <h1 class="title">SMK NEGERI 1 KAWALI</h1>
    </div>

    <div class="role-selection">
  <button class="role-selection-btn" onclick="showForm('siswa')">SISWA</button>
  <button class="role-selection-btn" onclick="showForm('guru')">GURU</button>
  <button class="role-selection-btn" onclick="showForm('kurikulum')">ADMIN</button>
  <!-- <button class="role-selection-btn" onclick="showForm('kepala_sekolah')">KEPALA SEKOLAH</button> -->
</div>

<!-- Form Login Siswa -->
<div id="siswa-form" class="form-container">
  <form action="{{ route('login.siswa') }}" method="POST">
    @csrf
    <div class="input-group">
      <label for="nis">NIS Pengguna</label>
      <input type="text" id="nis" name="nis" required>
    </div>
    <div class="input-group">
      <label for="password">Kata Sandi</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="submit-btn">MASUK</button>
  </form>
</div>

<!-- Form Login Guru -->
<div id="guru-form" class="form-container">
  <form action="{{ route('login.guru') }}" method="POST">
    @csrf
    <div class="input-group">
      <label for="nip">NIP/NUPTK Pengguna</label>
      <input type="text" id="nip" name="nip" required>
    </div>
    <div class="input-group">
      <label for="password">Kata Sandi</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="submit-btn">MASUK</button>
  </form>
</div>

<!-- Form Login Kurikulum -->
<div id="kurikulum-form" class="form-container">
  <form action="{{ route('login.kurikulum') }}" method="POST">
    @csrf
    <div class="input-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div class="input-group">
      <label for="password">Kata Sandi</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="submit-btn">MASUK</button>
  </form>
</div>

<!-- Form Login kepala sekolah -->
<!-- <div id="kepala_sekolah-form" class="form-container">
  <form action="{{ route('login.kurikulum') }}" method="POST">
    @csrf
    <div class="input-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div class="input-group">
      <label for="password">Kata Sandi</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="submit-btn">MASUK</button>
  </form>
</div> -->
  </div>

  <script>
    function showForm(role) {
      document.getElementById('siswa-form').classList.remove('active');
      document.getElementById('guru-form').classList.remove('active');
      document.getElementById('kurikulum-form').classList.remove('active');

      document.getElementById(role + '-form').classList.add('active');
    }
  </script>
</body>

</html>