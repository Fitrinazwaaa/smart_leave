<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun Kurikulum</title>
</head>
<body>

    <h2>Pengaturan Akun Kurikulum</h2>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ url('/akun-kurikulum') }}" method="POST">
        @csrf

        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="{{ old('username', 'kurikulum') }}" required>
        </div>

        <div>
            <label for="password">Password Baru (opsional):</label>
            <input type="password" id="password" name="password">
        </div>

        <div>
            <label for="password_confirmation">Konfirmasi Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit">Perbarui Akun</button>
    </form>

</body>
</html>
