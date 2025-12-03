<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Cek Stunting - Sistem Monitoring</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-green-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Navigation -->
        <nav class="flex justify-between items-center mb-8">
            <a href="{{ route('beranda') }}" class="flex items-center space-x-2 text-blue-600 hover:text-blue-700">
                <span>🏠</span>
                <span>Beranda</span>
            </a>
            <div class="text-sm text-gray-600">
                Sistem Monitoring Stunting
            </div>
        </nav>

        <!-- Result Card -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <div class="text-4xl mb-4">
                        @php
                            $data['status'];
                        @endphp
                        @if ($data['status'] == 'Normal')
                            ✅
                        @elseif($data['status'] == 'Stunting')
                            ⚠️
                        @else
                            🚨
                        @endif
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Hasil Pengecekan Stunting</h1>
                    <p class="text-green-600 font-semibold">Data telah tersimpan dalam sistem monitoring</p>
                </div>

                <!-- Data Summary -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    <h3 class="font-semibold text-gray-800 mb-4 text-lg">Ringkasan Data</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div class="flex justify-stretch">
                                <span class="text-gray-600">Nama:</span>
                                <span class="font-semibold"> {{ $data['nama'] }}</span>
                            </div>
                            <div class="flex justify-stretch">
                                <span class="text-gray-600">Umur:</span>
                                <span class="font-semibold"> {{ $data['umur'] }} bulan</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-stretch">
                                <span class="text-gray-600">Jenis Kelamin:</span>
                                <span class="font-semibold">
                                    {{ $data['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </div>
                            <div class="flex justify-stretch">
                                <span class="text-gray-600">Tinggi Badan:</span>
                                <span class="font-semibold"> {{ $data['tinggi_badan'] }} cm</span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Status Result -->
                <div class="text-center mb-8">
                    <div
                        class="inline-block px-6 py-4 rounded-2xl 
                        @if ($data['status'] == 'normal') bg-green-100 text-green-800 border border-green-200
                        @elseif($data['status'] == 'pendek') bg-yellow-100 text-yellow-800 border border-yellow-200
                        @else bg-red-100 text-red-800 border border-red-200 @endif">
                        <h3 class="text-2xl font-bold mb-2">Status: {{ $data['status'] }}</h3>

                        <p class="text-lg">
                            @if ($data['status'] == 'tinggi')
                                🚨 Segera konsultasi dengan tenaga kesehatan
                            @elseif($data['status'] == 'normal')
                                ✅ Pertumbuhan anak dalam kondisi normal
                            @elseif($data['status'] == 'pendek')
                                ⚠️ Perlu perhatian lebih pada asupan gizi
                            @else
                                🚨 Segera konsultasi dengan tenaga kesehatan
                            @endif
                        </p>
                    </div>
                </div>



                <!-- Action Buttons -->
                <div class="text-center space-y-4">
                    <p class="text-sm text-gray-600">
                        ID Data: <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $data['id'] }}</span>
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('cek-stunting') }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            🔍 Cek Lagi
                        </a>
                        <a href="{{ route('beranda') }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            🏠 Ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
