<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlatRequest;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
{
    /**
     * Display a listing of the alats with search and filter.
     */
    public function index(Request $request)
    {
        $query = Alat::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $alats = $query->latest()->paginate(15)->withQueryString();

        return view('admin.alats.index', compact('alats'));
    }

    /**
     * Show the form for creating a new alat.
     */
    public function create()
    {
        return view('admin.alats.create');
    }

    /**
     * Store a newly created alat in storage with image upload.
     */
    public function store(StoreAlatRequest $request)
    {
        $validated = $request->validated();

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('alats', 'public');
            $validated['gambar'] = $path;
        }

        Alat::create($validated);

        return redirect()->route('admin.alats.index')
            ->with('success', 'Alat berhasil ditambahkan.');
    }

    /**
     * Display the specified alat.
     */
    public function show(Alat $alat)
    {
        return view('admin.alats.show', compact('alat'));
    }

    /**
     * Show the form for editing the specified alat.
     */
    public function edit(Alat $alat)
    {
        return view('admin.alats.edit', compact('alat'));
    }

    /**
     * Update the specified alat in storage.
     */
    public function update(StoreAlatRequest $request, Alat $alat)
    {
        $validated = $request->validated();

        // Handle image upload/update
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($alat->gambar) {
                Storage::disk('public')->delete($alat->gambar);
            }
            $path = $request->file('gambar')->store('alats', 'public');
            $validated['gambar'] = $path;
        }

        $alat->update($validated);

        return redirect()->route('admin.alats.index')
            ->with('success', 'Alat berhasil diperbarui.');
    }

    /**
     * Remove the specified alat from storage.
     */
    public function destroy(Alat $alat)
    {
        // Delete associated image if exists
        if ($alat->gambar) {
            Storage::disk('public')->delete($alat->gambar);
        }

        $alat->delete();

        return redirect()->route('admin.alats.index')
            ->with('success', 'Alat berhasil dihapus.');
    }
}
