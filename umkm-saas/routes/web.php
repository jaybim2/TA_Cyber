<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterUmkmController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Rute Index (Landing sementara di Slice 1, diarahkan berdasarkan status login)
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->isVendor()
            ? redirect()->route('vendor.dashboard')
            : redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Layar 2: Login & Logout
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Layar 3: Registrasi UMKM
Route::get('/register-umkm', [RegisterUmkmController::class, 'create'])->name('register-umkm');
Route::post('/register-umkm', [RegisterUmkmController::class, 'store']);

// Layar 6: Dashboard UMKM (Hanya Admin UMKM yang terotentikasi)
Route::middleware(['auth', 'role:umkm_admin'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return view('dashboard', [
            'user' => $user,
            'organization' => $user->organization,
        ]);
    })->name('dashboard');
});

// Layar 4: Dashboard Vendor (Hanya Vendor yang terotentikasi)
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor', function () {
        return view('vendor.dashboard', [
            'user' => Auth::user(),
        ]);
    })->name('vendor.dashboard');
});
