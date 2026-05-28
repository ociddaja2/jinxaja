<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;
use App\Models\Book;
use App\Models\Member;

class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pinjamans = Pinjaman::with('book', 'member')->get();
        return view('pinjaman.index', compact('pinjamans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::all();
        $members = Member::all();
        return view('pinjaman.create', compact('books', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date',
        ]);

        Pinjaman::create($validated);
        return redirect()->route('pinjamans.index')->with('success', 'Loan created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pinjaman = Pinjaman::findOrFail($id);
        $books = Book::all();
        $members = Member::all();
        return view('pinjaman.edit', compact('pinjaman', 'books', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pinjaman = Pinjaman::findOrFail($id);
        
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date',
        ]);

        $pinjaman->update($validated);
        return redirect()->route('pinjamans.index')->with('success', 'Loan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->delete();
        return redirect()->route('pinjamans.index')->with('success', 'Loan deleted successfully');
    }
}
