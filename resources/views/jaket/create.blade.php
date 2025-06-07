<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jaket Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"],
        input[type="file"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Pastikan padding tidak menambah lebar */
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Jaket Baru</h1>

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

        <form action="{{ route('jakets.store.web') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- <div class="form-group">
                <label for="id">ID Jaket (Nomor Seri Unik):</label>
                <input type="text" id="id" name="id" value="{{ old('id') }}" required>
                @error('id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div> --}}

            <div class="form-group">
                <label for="nama">Nama Jaket:</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
                @error('nama')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="jenis">Jenis Jaket:</label>
                <input type="text" id="jenis" name="jenis" value="{{ old('jenis') }}" required>
                @error('jenis')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status Jaket:</label>
                <select id="status" name="status" required>
                    <option value="">Pilih Status</option>
                    <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Habis" {{ old('status') == 'Habis' ? 'selected' : '' }}>Habis</option>
                    <option value="Pre-order" {{ old('status') == 'Pre-order' ? 'selected' : '' }}>Pre-order</option>
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="gambar">Gambar Jaket:</label>
                <input type="file" id="gambar" name="gambar" required>
                @error('gambar')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Tambah Jaket</button>
        </form>
    </div>
</body>
</html>
