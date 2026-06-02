<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\User\PeminjamanController as UserPeminjamanController;

// Home route - redirect to login if not authenticated
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin' 
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Authentication routes (Login/Logout) - Simple Implementation
Route::middleware('guest')->group(function () {
    Route::get('login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::post('login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Redirect based on role
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    })->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

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
