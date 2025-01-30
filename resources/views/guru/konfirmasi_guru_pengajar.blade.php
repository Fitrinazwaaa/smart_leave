<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konfirmasi Mata Pelajaran</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="{{ asset('css/konfirmasi_guru.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

  <div class="container">
    <h1 class="mb-4 text-center">Konfirmasi Dispensasi - Mata Pelajaran</h1>
    @foreach ($dispen as $data)
    <div class="card" id="dispensasi-{{ $data->id }}">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3">
          <div class="student-info">
            <p class="name">{{ $data->nama }} ({{ $data->nis }})</p>
            <p class="class">{{ $data->tingkat }} {{ $data->konsentrasi_keahlian }}</p>
          </div>
        </div>
        <!-- Form Konfirmasi -->
        <form action="{{ route('konfirmasiMataPelajaran') }}" method="POST">
          @csrf
          <input type="hidden" name="id_dispen" value="{{ $data->id_dispen }}">
          <div class="actions d-flex gap-2">
            <button type="submit" class="btn btn-primary">Konfirmasi</button>
          </div>
        </form>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Bootstrap and Bootstrap Icons CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
