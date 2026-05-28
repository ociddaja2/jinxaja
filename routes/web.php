<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PinjamanController;
use App\Models\Book;
use App\Models\Member;
use App\Models\Author;
use App\Models\Pinjaman;

Route::get('/', function () {
    $stats = [
        'books' => Book::count(),
        'members' => Member::count(),
        'authors' => Author::count(),
        'loans' => Pinjaman::where('return_date', null)->count(),
    ];
    return view('welcome', compact('stats'));
});

// Resource Routes untuk CRUD operations
Route::resource('categories', CategoryController::class);
Route::resource('authors', AuthorController::class);
Route::resource('books', BookController::class);
Route::resource('members', MemberController::class);
Route::resource('pinjamans', PinjamanController::class);
