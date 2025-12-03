<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Stunting - Sistem Monitoring</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        input[type="radio"] {
            accent-color: #2563eb;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-green-50 min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="flex justify-between items-center p-4 bg-white shadow-sm">
        <a href="{{ route('beranda') }}" class="flex items-center space-x-2 text-blue-600 hover:text-blue-700">
            <span>←</span>
            <span>Kembali ke Beranda</span>
        </a>

        <div class="flex items-center space-x-4">
            @auth
                <div class="text-sm text-gray-700 text-right">
                    <p class="font-semibold text-blue-700">{{ Auth::user()->name }}</p>
                    <p class="text-gray-500 text-xs">{{ Auth::user()->email }}</p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600 focus:ring-2 focus:ring-red-300 transition"
                        onclick="return confirm('Yakin ingin logout?')">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="bg-white shadow-lg rounded-2xl w-full max-w-md p-8 border border-gray-200">
            <!-- Judul -->
            <h1 class="text-2xl font-bold text-center text-gray-800 mb-8">Cek Status Stunting</h1>

            <!-- Error Handling -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-300 rounded-lg p-4 mb-6">
                    <h3 class="text-red-800 font-semibold mb-2">Periksa kembali data yang dimasukkan:</h3>
                    <ul class="list-disc list-inside text-red-700 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('check-stunting') }}" class="space-y-5">
                @csrf
                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Anak</label>
                    <input id="nama" name="nama" type="text" value="{{ old('nama') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- Jenis Kelamin -->
                <div class="text-center">
                    <p class="text-gray-700 font-medium mb-2">Jenis Kelamin</p>
                    <div class="flex justify-center space-x-8">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="laki-laki" required
                                {{ old('jenis_kelamin') == 'laki-laki' ? 'checked' : '' }}>
                            <span>Laki-laki</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="perempuan" required
                                {{ old('jenis_kelamin') == 'perempuan' ? 'checked' : '' }}>
                            <span>Perempuan</span>
                        </label>
                    </div>
                </div>

                <!-- Umur & Tinggi Badan -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="umur" class="block text-sm font-medium text-gray-700 mb-1">Umur (bulan)</label>
                        <input id="umur" name="umur" type="number" min="1" max="60"
                            value="{{ old('umur') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>
                    <div>
                        <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-1">Tinggi Badan
                            (cm) *</label>
                        <input id="tinggi_badan" name="tinggi_badan" type="number" step="0.01" min="30"
                            max="150" value="{{ old('tinggi_badan') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>
                </div>

                <!-- Tombol -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition duration-200 flex items-center justify-center space-x-2">
                        <span>🔍</span>
                        <span>Cek Sekarang</span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Info Box -->
    <footer class="bg-blue-50 border-t border-blue-200 mt-10 py-6">
        <div class="max-w-md mx-auto px-4 text-blue-800">
            <h3 class="font-semibold mb-2 text-center">Informasi Penting</h3>
            <ul class="text-sm space-y-1 list-disc list-inside">
                <li>Pastikan pengukuran dilakukan dengan alat yang tepat</li>
                <li>Data digunakan untuk monitoring dan analisis stunting</li>
                <li>Hasil merupakan screening awal, tetap konsultasikan dengan tenaga kesehatan</li>
            </ul>
        </div>
    </footer>
</body>

</html>
