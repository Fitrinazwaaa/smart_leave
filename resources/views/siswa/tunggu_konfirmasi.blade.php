<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Konfirmasi Guru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f7fa;
      padding: 40px;
    }
    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
      transform: scale(1.02);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .card-body {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .student-info {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }
    .student-info .name {
      font-size: 1.2rem;
      font-weight: bold;
      margin: 0;
    }
    .student-info .class {
      font-size: 0.95rem;
      color: #6c757d;
      margin: 0;
    }
    .actions button {
      min-width: 110px;
      transition: background-color 0.2s, transform 0.2s;
    }
    .actions .btn:hover {
      transform: translateY(-2px);
    }
    .actions .detail {
      background-color: #007bff;
      color: #fff;
      border: none;
    }
    .actions .detail:hover {
      background-color: #0056b3;
    }
    .actions .confirm {
      background-color: #28a745;
      color: #fff;
      border: none;
    }
    .actions .confirm:hover {
      background-color: #218838;
    }
    .actions .confirm:disabled {
      background-color: #d6d8db;
      color: #6c757d;
      cursor: not-allowed;
    }
    .icon-wrapper {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .check-icon {
      font-size: 1.5rem;
      color: #28a745;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="mb-4 text-center">Konfirmasi Dispensasi</h1>

    <!-- Guru Piket Card -->
@foreach ($guruPiket as $data)
<div class="card">
  <div class="card-body">
    <div class="d-flex align-items-center gap-3">
      <div class="icon-wrapper">
        <div class="spinner-border text-secondary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <div class="student-info">
        <p class="name">Konfirmasi Guru Piket</p>
        <p class="class">
          {{ $data->nama ?? 'Belum ada konfirmasi' }}
        </p>
      </div>
    </div>
    <div class="actions d-flex gap-2">
      <button class="btn detail">Kirim bot chat</button>
    </div>
  </div>
</div>
@endforeach

<!-- Guru Pengajar Card -->
@foreach ($guruPengajar as $data)
<div class="card">
  <div class="card-body">
    <div class="d-flex align-items-center gap-3">
      <div class="icon-wrapper">
        <div class="spinner-border text-secondary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <div class="student-info">
        <p class="name">Konfirmasi Guru Pengajar</p>
        <p class="class">{{ $data->nama ?? 'Belum ada konfirmasi' }}</p>
      </div>
    </div>
    <div class="actions d-flex gap-2">
      <button class="btn detail">Kirim bot chat</button>
    </div>
  </div>
</div>
@endforeach

<!-- Kurikulum Card -->
@foreach ($kurikulum as $data)
<div class="card">
  <div class="card-body">
    <div class="d-flex align-items-center gap-3">
      <div class="icon-wrapper">
        <div class="spinner-border text-secondary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <div class="student-info">
        <p class="name">Konfirmasi Kurikulum</p>
        <p class="class">{{ $data->username ?? 'Belum ada konfirmasi' }}</p>
      </div>
    </div>
    <div class="actions d-flex gap-2">
      <button class="btn detail">Kirim bot chat</button>
    </div>
  </div>
</div>
@endforeach


  </div>

  <script>
    function confirmStudent(id) {
      const loadingElement = document.getElementById(`loading-${id}`);
      const confirmButton = document.querySelector(`#student-${id} .confirm`);

      // Debugging: Check if elements exist
      if (!loadingElement) {
        console.error(`Loading element not found for student with ID ${id}`);
        return;
      }

      if (!confirmButton) {
        console.error(`Confirm button not found for student with ID ${id}`);
        return;
      }

      // Simulate confirmation by replacing spinner with a check icon
      loadingElement.innerHTML = "<i class='bi bi-check-circle-fill check-icon'></i>";

      // Disable the confirm button
      confirmButton.disabled = true;
    }
  </script>

  <!-- Bootstrap and Bootstrap Icons CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
