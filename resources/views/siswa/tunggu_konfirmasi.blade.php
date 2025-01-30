<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Konfirmasi Guru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJb3RrP6j1eg84BQ2erfFPLBaZrj1I1NE9FYkCOs5TtZUSSHjGZbmL8HjzqP" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/tunggu_konfirm.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
  <header>
    <button class="back-button" onclick="window.location.href='{{ route('dashboard.siswa') }}';">
      <i class="fas fa-arrow-left"></i>
    </button>
    <div class="logo">
      <img src="{{ asset('img/Smk-Negeri-1-Kawali-Logo.png') }}" alt="Logo">
      <div>
        <h2>DISPENSASI SISWA SMK NEGERI 1 KAWALI</h2>
        <p class="sub-title">{{ $siswa->nama }}</p>
      </div>
    </div>
  </header>

  <div class="container">
    <h1 class="mb-4 text-center">Konfirmasi Dispensasi</h1>

    <!-- Guru Piket Card -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3">
          <div class="icon-wrapper">
            <div class="status-icon">
              @if($konfir && $konfir->konfirmasi_1)
              <!-- Show a checkmark icon if the confirmation exists -->
              <i class="bi bi-check-circle-fill text-success" style="font-size: 24px;"></i>
              @else
              <!-- Show a loading spinner if confirmation does not exist -->
              <div class="spinner-border text-secondary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              @endif
            </div>
          </div>
          <div class="student-info">
            <p class="name">Konfirmasi Guru Piket</p>
            @if($konfir && $konfir->konfirmasi_1)
            <p class="class">
              @if($guruPiket)
              Telah disetujui oleh : {{ $guruPiket->nama }}
              @else
              Nama guru tidak ditemukan
              @endif
            </p>
            @else
            <p class="class">Belum ada konfirmasi</p>
            @endif
          </div>
        </div>
        <div class="actions d-flex gap-2">
          <button class="btn detail">Kirim bot chat</button>
        </div>
      </div>
    </div>

    <!-- Guru Pengajar Card -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3">
          <div class="icon-wrapper">
            <div class="status-icon">
              @if($konfir && $konfir->konfirmasi_2)
              <!-- Show a checkmark icon if the confirmation exists -->
              <i class="bi bi-check-circle-fill text-success" style="font-size: 24px;"></i>
              @else
              <!-- Show a loading spinner if confirmation does not exist -->
              <div class="spinner-border text-secondary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              @endif
            </div>
          </div>
          <div class="student-info">
            <p class="name">Konfirmasi Guru Pengajar</p>
            @if($konfir && $konfir->konfirmasi_2)
            <p class="class">
              @if($guruPengajar)
              Telah disetujui oleh : {{ $guruPengajar->nama }}
              @else
              Nama guru tidak ditemukan
              @endif
            </p>
            @else
            <p class="class">Belum ada konfirmasi</p>
            @endif
          </div>
        </div>
        <div class="actions d-flex gap-2">
          <button class="btn detail">Kirim bot chat</button>
        </div>
      </div>
    </div>

    <!-- Kurikulum Card -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3">
          <div class="icon-wrapper">
            <div class="status-icon">
              @if($konfir && $konfir->konfirmasi_3)
              <!-- Show a checkmark icon if the confirmation exists -->
              <i class="bi bi-check-circle-fill text-success" style="font-size: 24px;"></i>
              @else
              <!-- Show a loading spinner if confirmation does not exist -->
              <div class="spinner-border text-secondary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              @endif
            </div>
          </div>
          <div class="student-info">
            <p class="name">Konfirmasi Kurikulum</p>
            @if($konfir && $konfir->konfirmasi_3)
            <p class="class">
              @if($guruKurikulum)
              Telah disetujui oleh : {{ $guruKurikulum->nama }}
              @else
              Nama guru tidak ditemukan
              @endif
            </p>
            @else
            <p class="class">Belum ada konfirmasi</p>
            @endif
          </div>
        </div>
        <div class="actions d-flex gap-2">
          <button class="btn detail">Kirim bot chat</button>
        </div>
      </div>
    </div>
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
  <!-- Bootstrap and Bootstrap Icons CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybOveo3f8VgJUvP5Vyn6pd56rOH1diJfqa0ksL8/4Oh3nybs0" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0uW9YrkQ+Q+97Jmf6fF3j1vSxtIhQczb1Y88aV6YQw0W6qHm" crossorigin="anonymous"></script>
</body>

</html>