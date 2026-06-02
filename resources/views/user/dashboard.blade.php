@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Dashboard User</h1>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Peminjaman</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_peminjaman'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Peminjaman Aktif</h3>
            <p class="text-3xl font-bold text-orange-600">{{ $stats['peminjaman_aktif'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Riwayat Kembali</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['riwayat_kembali'] }}</p>
        </div>
    </div>

    <!-- Active Peminjamans -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-semibold">Peminjaman Aktif</h2>
            <a href="{{ route('user.katalog') }}" class="text-blue-600 hover:text-blue-800">Pinjam Alat Baru →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Kembali Rencana</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activePeminjamans as $peminjaman)
                    <tr>
                        <td class="px-6 py-4">{{ $peminjaman->alat->nama_alat }}</td>
                        <td class="px-6 py-4">{{ $peminjaman->tanggal_pinjam }}</td>
                        <td class="px-6 py-4">{{ $peminjaman->tanggal_kembali_rencana }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($peminjaman->status == 'diajukan') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800
                                @endif">
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada peminjaman aktif. 
                            <a href="{{ route('user.katalog') }}" class="text-blue-600 hover:text-blue-800">Lihat katalog alat</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
