<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Stunting Checker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-100 to-green-50 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav
        class="flex justify-between items-center px-8 py-4 bg-gradient-to-b from-blue-200 to-white shadow-lg backdrop-blur-sm">
        <h1 class="text-2xl font-extrabold text-blue-700 tracking-wide drop-shadow-sm">
            🌿 StuntingChecker
        </h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="px-5 py-2.5 bg-gradient-to-b from-red-500 to-red-600 text-white text-sm font-semibold rounded-lg shadow-md hover:from-red-600 hover:to-red-700 transition-transform transform hover:scale-105 focus:ring-2 focus:ring-red-300"
                onclick="return confirm('Yakin ingin logout?')">
                Logout
            </button>
        </form>
    </nav>


    <!-- Hero Section -->
    <header class="text-center mt-12 px-6">
        <h2 class="text-4xl font-extrabold text-gray-800 mb-4">
            Pantau Status Gizi dan Cegah Stunting Sejak Dini 👶
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
            Stunting bukan takdir, tapi bisa dicegah. Awasi tumbuh kembang anak sejak dini dengan StuntingChecker.
        </p>
    </header>

    <!-- Motivational Cards Section -->
    <section class="mt-16 px-8 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">

        <!-- Card 1 -->
        <div class="bg-white p-8 rounded-2xl shadow-lg text-center hover:scale-105 transition">
            <div class="text-4xl mb-3 text-green-500">🌱</div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Tumbuh Sehat Sejak Dini</h3>
            <p class="text-gray-700 text-lg italic">
                “Cegah lebih awal, tumbuh lebih optimal. Perhatikan tanda-tanda stunting sebelum terlambat.”
            </p>
        </div>

        <!-- Card 2 -->
        <div class="bg-blue-600 p-8 rounded-2xl shadow-lg text-center text-white hover:scale-105 transition">
            <div class="text-4xl mb-2">🚀</div>
            <h3 class="text-xl font-semibold">Cek Sekarang</h3>
            <p class="text-blue-100 mt-2 mb-4">Mulai pemeriksaan anak Anda dengan langkah sederhana.</p>
            <a href="{{ route('cek-stunting') }}"
                class="inline-block bg-white text-blue-700 font-semibold px-6 py-2 rounded-lg hover:bg-blue-100 transition">
                Mulai Cek
            </a>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-8 rounded-2xl shadow-lg text-center hover:scale-105 transition">
            <div class="text-4xl mb-3 text-yellow-500">💛</div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Peduli Tumbuh Kembang</h3>
            <p class="text-gray-700 text-lg italic">
                “Setiap anak berhak tumbuh kuat dan cerdas. Yuk, pantau perkembangan mereka dengan penuh kasih.”
            </p>
        </div>


    </section>

    <!-- Footer -->
    <footer class="text-center py-6 border-t bg-white mt-16">
        <p class="text-gray-600">
            &copy; 2025 Sistem Monitoring Stunting — Semua Hak Dilindungi.
        </p>
    </footer>

</body>

</html>
