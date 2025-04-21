<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - KKNM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-xl font-bold text-indigo-600">KKNM</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="ml-3 relative">
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-700">{{ $mahasiswa->nama }}</span>
                                <form action="{{ route('mahasiswa.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-800">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Status Pendaftaran -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Status Pendaftaran KKN</h2>
                    @if($pendaftaran)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700"><span class="font-semibold">Status Pembayaran:</span>
                                <span class="px-2 py-1 rounded text-sm
                                    @if($pendaftaran->status_pembayaran == 'success') bg-green-100 text-green-800
                                    @elseif($pendaftaran->status_pembayaran == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($pendaftaran->status_pembayaran) }}
                                </span>
                            </p>
                            <p class="text-gray-700 mt-2"><span class="font-semibold">Status Pendaftaran:</span>
                                <span class="px-2 py-1 rounded text-sm
                                    @if($pendaftaran->status_pendaftaran == 'approved') bg-green-100 text-green-800
                                    @elseif($pendaftaran->status_pendaftaran == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($pendaftaran->status_pendaftaran) }}
                                </span>
                            </p>
                            @if($pendaftaran->tempat_kkn)
                                <p class="text-gray-700 mt-2"><span class="font-semibold">Tempat KKN:</span> {{ $pendaftaran->tempat_kkn }}</p>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-600 mb-4">Anda belum melakukan pendaftaran KKN</p>
                            <a href="{{ route('mahasiswa.daftar') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Daftar KKN Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tempat KKN yang Tersedia -->
            @if(!$pendaftaran)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tempat KKN yang Tersedia</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($tempat_kkn as $tempat)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $tempat->nama_tempat }}</h3>
                                    <p class="text-gray-600 mt-1">{{ $tempat->kecamatan }}, {{ $tempat->kabupaten }}</p>
                                    <p class="text-gray-600 mt-1">Kuota: {{ $tempat->kuota }} mahasiswa</p>
                                    <p class="text-gray-600 mt-2 text-sm">{{ $tempat->deskripsi }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>
</body>
</html>
