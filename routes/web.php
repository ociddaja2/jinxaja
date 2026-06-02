<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\User\PeminjamanController as UserPeminjamanController;

// Home route
Route::get('/', function () {
    return redirect()->route('');
});

// Authentication routes (assuming Laravel Breeze or similar is installed)
// Route::view('login', 'auth.login')->name('login');

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Alat management (CRUD)
        Route::resource('alats', AlatController::class);
        
        // Peminjaman management
        Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::post('/peminjaman/{id}/approve', [AdminPeminjamanController::class, 'approve'])->name('peminjaman.approve');
        Route::post('/peminjaman/{id}/reject', [AdminPeminjamanController::class, 'reject'])->name('peminjaman.reject');
        Route::post('/peminjaman/{id}/return', [AdminPeminjamanController::class, 'return'])->name('peminjaman.return');
        
        // Export features
        Route::get('/peminjaman/export-pdf', [AdminPeminjamanController::class, 'exportPdf'])->name('peminjaman.export.pdf');
        Route::get('/peminjaman/export-excel', [AdminPeminjamanController::class, 'exportExcel'])->name('peminjaman.export.excel');
    });

    // User routes
    Route::middleware(['role:user'])->prefix('user')->name('user.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [UserPeminjamanController::class, 'dashboard'])->name('dashboard');
        
        // Katalog alat (browse available tools)
        Route::get('/katalog', [UserPeminjamanController::class, 'katalog'])->name('katalog');
        
        // Submit peminjaman request
        Route::post('/pinjam', [UserPeminjamanController::class, 'store'])->name('pinjam.store');
        
        // Riwayat peminjaman
        Route::get('/riwayat', [UserPeminjamanController::class, 'riwayat'])->name('riwayat');
    });
});

