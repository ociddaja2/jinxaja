<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of peminjamans with search and filter.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat']);

        // Search by user name or alat name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('alat', function ($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->to_date);
        }

        $peminjamans = $query->latest()->paginate(15)->withQueryString();

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Approve a peminjaman request.
     */
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Check if alat is available
        if ($peminjaman->alat->status !== 'tersedia' || $peminjaman->alat->stok < 1) {
            return back()->with('error', 'Alat tidak tersedia untuk dipinjam.');
        }

        $peminjaman->update(['status' => 'disetujui']);
        
        // Update alat status and stock
        $peminjaman->alat->update([
            'status' => 'dipinjam',
            'stok' => $peminjaman->alat->stok - 1,
        ]);

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    /**
     * Reject a peminjaman request.
     */
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'ditolak']);

        return back()->with('success', 'Peminjaman ditolak.');
    }

    /**
     * Mark peminjaman as returned.
     */
    public function return($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali_realisasi' => now()->format('Y-m-d'),
        ]);

        // Update alat status and stock
        $peminjaman->alat->update([
            'status' => 'tersedia',
            'stok' => $peminjaman->alat->stok + 1,
        ]);

        return back()->with('success', 'Peminjaman ditandai sebagai dikembalikan.');
    }

    /**
     * Export peminjaman data to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('alat', function ($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->get();

        $pdf = Pdf::loadView('exports.peminjaman-pdf', compact('data'));
        
        return $pdf->download('laporan-peminjaman-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Export peminjaman data to Excel.
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(new PeminjamanExport, 'laporan-peminjaman-' . now()->format('Y-m-d') . '.xlsx');
    }
}
