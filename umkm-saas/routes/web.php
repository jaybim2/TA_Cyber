<?php

use App\Http\Controllers\Auth\RegisterUmkmController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman utama sementara diarahkan ke registrasi UMKM (Landing Page penuh di T15)
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('register-umkm');
});

// Layar 3: Registrasi UMKM
Route::get('/register-umkm', [RegisterUmkmController::class, 'create'])->name('register-umkm');
Route::post('/register-umkm', [RegisterUmkmController::class, 'store']);

// Layar 6: Dashboard UMKM (Placeholder dasar untuk paska-registrasi)
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('register-umkm');
    }

    $user = Auth::user();
    return view('dashboard', [
        'user' => $user,
        'organization' => $user->organization,
    ]);
})->name('dashboard');
