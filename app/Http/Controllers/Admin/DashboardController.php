<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics.
     */
    public function index(Request $request)
    {
        $stats = [
            'total_alat' => Alat::count(),
            'alat_tersedia' => Alat::where('status', 'tersedia')->count(),
            'alat_dipinjam' => Alat::where('status', 'dipinjam')->count(),
            'total_peminjaman' => Peminjaman::count(),
            'peminjaman_pending' => Peminjaman::where('status', 'diajukan')->count(),
            'total_user' => User::where('role', 'user')->count(),
        ];

        $recentPeminjamans = Peminjaman::with(['user', 'alat'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPeminjamans'));
    }
}
