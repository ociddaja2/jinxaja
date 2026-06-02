@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Alat</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_alat'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Alat Tersedia</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['alat_tersedia'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Alat Dipinjam</h3>
            <p class="text-3xl font-bold text-orange-600">{{ $stats['alat_dipinjam'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total Peminjaman</h3>
            <p class="text-3xl font-bold text-purple-600">{{ $stats['total_peminjaman'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Menunggu Persetujuan</h3>
            <p class="text-3xl font-bold text-red-600">{{ $stats['peminjaman_pending'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-gray-500 text-sm font-medium">Total User</h3>
            <p class="text-3xl font-bold text-gray-600">{{ $stats['total_user'] }}</p>
        </div>
    </div>

    <!-- Recent Peminjamans -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="text-xl font-semibold">Peminjaman Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentPeminjamans as $peminjaman)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $peminjaman->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $peminjaman->alat->nama_alat }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $peminjaman->tanggal_pinjam }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($peminjaman->status == 'diajukan') bg-yellow-100 text-yellow-800
                                @elseif($peminjaman->status == 'disetujui') bg-green-100 text-green-800
                                @elseif($peminjaman->status == 'dikembalikan') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if($peminjaman->status == 'diajukan')
                                <form action="{{ route('admin.peminjaman.approve', $peminjaman->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900">Setujui</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data peminjaman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
