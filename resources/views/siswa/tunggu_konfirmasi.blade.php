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
  <style>
    .vertical-layout {
      display: flex;
      flex-direction: column;
      /* Elemen ditampilkan secara vertikal */
      gap: 10px;
      /* Beri jarak antar elemen */
    }

    .vertical-layout button {
      width: 100%;
      /* Tombol memanjang sesuai lebar container */
    }
  </style>
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
    <h1 class="mb-4 text-center" style="font-weight: bold;">Konfirmasi Dispensasi</h1>

    @if($konfir && $konfir->kategori === 'keluar lingkungan sekolah')
    <!-- Guru Piket Card -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3">
          <div class="icon-wrapper">
            <div class="status-icon">
              @if($konfir && $konfir->konfirmasi_1)
              <i class="bi bi-check-circle-fill text-success" style="font-size: 24px;"></i>
              @else
              <div class="spinner-border text-secondary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              @endif
            </div>
          </div>
          <div class="student-info">
            <p class="name">Konfirmasi Guru Piket</p>
            @if($konfir && $konfir->konfirmasi_1)
            <p class="class">"{{ $konfir->kategori ?? 'Belum ada kategori' }}"</p>
            <p class="class">
              @if($guruPiket)
              telah disetujui oleh : {{ $guruPiket->nama }}
              @else
              Nama guru tidak ditemukan
              @endif
            </p>
            @else
            <p class="class">Belum ada konfirmasi</p>
            @endif
          </div>
        </div>
        <div>
          <div class="vertical-layout">
            @if($guruPiketList->isNotEmpty())
            @foreach($guruPiketList as $guru)
            <button class="btn btn-primary"
              data-nip="{{ $guru->nip }}"
              data-nama="{{ $siswa->nama }}"
              data-kategori="{{ $konfir->kategori ?? 'Belum ada kategori' }}"
              onclick="kirimChat(this)">
              Kirim Pesan ke {{ $guru->nama }}
            </button>
            @endforeach
            @else
            <p>Guru piket tidak tersedia untuk hari ini.</p>
            @endif
          </div>
        </div>
      </div>
    </div>


    @elseif($konfir && $konfir->kategori === 'mengikuti kegiatan')
    <!-- Guru Piket Card -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3">
          <div class="icon-wrapper">
            <div class="status-icon">
              @if($konfir && $konfir->konfirmasi_1)
              <i class="bi bi-check-circle-fill text-success" style="font-size: 24px;"></i>
              @else
              <div class="spinner-border text-secondary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              @endif
            </div>
          </div>
          <div class="student-info">
            <p class="name">Konfirmasi Guru Piket</p>
            @if($konfir && $konfir->konfirmasi_1)
            <p class="class">"{{ $konfir->kategori ?? 'Belum ada kategori' }}"</p>
            <p class="class">
              @if($guruPiket)
              telah disetujui oleh : {{ $guruPiket->nama }}
              @else
              Nama guru tidak ditemukan
              @endif
            </p>
            @else
            <p class="class">Belum ada konfirmasi</p>
            @endif
          </div>
        </div>
        <div>
          <div class="vertical-layout">
            @if($guruPiketList->isNotEmpty())
            @foreach($guruPiketList as $guru)
            <button class="btn btn-primary"
              data-nip="{{ $guru->nip }}"
              data-nama="{{ $siswa->nama }}"
              data-kategori="{{ $konfir->kategori ?? 'Belum ada kategori' }}"
              onclick="kirimChat(this)">
              Kirim Pesan ke {{ $guru->nama }}
            </button>
            @endforeach
            @else
            <p>Guru piket tidak tersedia untuk hari ini.</p>
            @endif
          </div>
        </div>
      </div>
    </div>


    <!-- Guru Pengajar Card -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3">
          <div class="icon-wrapper">
            <div class="status-icon">
              @if($konfir->konfirmasi_2)
              <i class="bi bi-check-circle-fill text-success" style="font-size: 24px;"></i>
              @else
              <div class="spinner-border text-secondary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              @endif
            </div>
          </div>
          <div class="student-info">
            <p class="name">Konfirmasi Guru Pengajar</p>
            @if($konfir->konfirmasi_2)
            <p class="class">"{{ $konfir->kategori ?? 'Belum ada kategori' }}"</p>
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
        <div class="vertical-layout">
          @if($guruPengajar)
          <button class="btn btn-primary"
            data-nip="{{ $guruPengajar->nip }}"
            data-nama="{{ $siswa->nama }}"
            data-kategori="Pengajar"
            onclick="kirimChat(this)">
            Kirim Pesan ke {{ $guruPengajar->nama }}
          </button>
          @endif
        </div>
      </div>
    </div>

    <!-- Kurikulum Card -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3">
          <div class="icon-wrapper">
            <div class="status-icon">
              @if($konfir->konfirmasi_3)
              <i class="bi bi-check-circle-fill text-success" style="font-size: 24px;"></i>
              @else
              <div class="spinner-border text-secondary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              @endif
            </div>
          </div>
          <div class="student-info">
            <p class="name">Konfirmasi Kurikulum</p>
            @if($konfir->konfirmasi_3)
            <p class="class">"{{ $konfir->kategori ?? 'Belum ada kategori' }}"</p>
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
        <div class="vertical-layout">
          @if($guruKurikulum)
          <button class="btn btn-primary"
            data-nip="{{ $guruKurikulum->nip }}"
            data-nama="{{ $siswa->nama }}"
            data-kategori="Kurikulum"
            onclick="kirimChat(this)">
            Kirim Pesan ke {{ $guruKurikulum->nama }}
          </button>
          @elseif($guruKurikulumList->isNotEmpty())
          @foreach($guruKurikulumList as $guru)
          <button class="btn btn-primary"
            data-nip="{{ $guru->nip }}"
            data-nama="{{ $siswa->nama }}"
            data-kategori="Kurikulum"
            onclick="kirimChat(this)">
            Kirim Pesan ke {{ $guru->nama }}
          </button>
          @endforeach
          @endif
        </div>
      </div>
    </div>
    @endif
  </div>

  <script>
    function kirimChat(button) {
      const nip = button.getAttribute('data-nip');
      const namaSiswa = button.getAttribute('data-nama');
      const kategori = button.getAttribute('data-kategori');

      if (!nip) {
        alert("Guru piket tidak tersedia.");
        return;
      }

      fetch("{{ route('kirim.chat') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
          body: JSON.stringify({
            nip: nip,
            nama_siswa: namaSiswa,
            kategori: kategori
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.whatsapp_url) {
            window.open(data.whatsapp_url, "_blank");
          } else {
            alert("Gagal mengirim pesan. Silakan coba lagi.");
          }
        })
        .catch(error => {
          console.error("Error:", error);
          alert("Terjadi kesalahan. Silakan coba lagi.");
        });
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>