<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeminjamanRequest;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Display user dashboard with statistics.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_peminjaman' => Peminjaman::where('user_id', $user->id)->count(),
            'peminjaman_aktif' => Peminjaman::where('user_id', $user->id)
                ->whereIn('status', ['diajukan', 'disetujui'])
                ->count(),
            'riwayat_kembali' => Peminjaman::where('user_id', $user->id)
                ->where('status', 'dikembalikan')
                ->count(),
        ];

        $activePeminjamans = Peminjaman::with('alat')
            ->where('user_id', $user->id)
            ->whereIn('status', ['diajukan', 'disetujui'])
            ->latest()
            ->get();

        return view('user.dashboard', compact('stats', 'activePeminjamans'));
    }

    /**
     * Display catalog of available alats with search and filter.
     */
    public function katalog(Request $request)
    {
        $query = Alat::where('status', 'tersedia')->where('stok', '>', 0);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $alats = $query->latest()->paginate(12)->withQueryString();

        // Get unique categories for filter dropdown
        $categories = Alat::selectRaw('DISTINCT kategori')
            ->whereNotNull('kategori')
            ->pluck('kategori');

        return view('user.katalog', compact('alats', 'categories'));
    }

    /**
     * Store a new peminjaman request.
     */
    public function store(StorePeminjamanRequest $request)
    {
        $validated = $request->validated();
        
        $alat = Alat::findOrFail($validated['alat_id']);
        
        // Double check availability
        if ($alat->status !== 'tersedia' || $alat->stok < 1) {
            return back()->with('error', 'Maaf, alat ini tidak tersedia untuk dipinjam.');
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'diajukan';

        Peminjaman::create($validated);

        return redirect()->route('user.riwayat')
            ->with('success', 'Permintaan peminjaman berhasil diajukan. Menunggu persetujuan admin.');
    }

    /**
     * Display user's peminjaman history.
     */
    public function riwayat(Request $request)
    {
        $user = Auth::user();
        
        $query = Peminjaman::with('alat')->where('user_id', $user->id);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->latest()->paginate(15)->withQueryString();

        return view('user.riwayat', compact('peminjamans'));
    }
}
