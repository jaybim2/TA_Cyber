@extends('layouts.app', ['title' => 'Masuk ke Platform'])

@section('content')
<div class="max-w-md mx-auto px-4 sm:px-6 py-6">
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-3 border border-blue-200">
            <span>🔐 Autentikasi Pengguna</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Masuk ke Akun Anda</h1>
        <p class="text-sm text-slate-600 mt-2">
            Silakan masukkan email dan password terdaftar untuk mengelola platform atau UMKM Anda.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-sm">
            <div class="font-semibold flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>Gagal Masuk</span>
            </div>
            <ul class="list-disc list-inside space-y-1 text-xs text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-6 sm:p-8">
        <form action="{{ url('/login') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Field Email -->
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Email Pengguna
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    placeholder="nama@domain.com"
                    class="w-full px-3.5 py-2.5 rounded-lg border @error('email') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>

            <!-- Field Password -->
            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
                    Password
                </label>
                <input type="password" name="password" id="password" required
                    placeholder="Masukkan password Anda"
                    class="w-full px-3.5 py-2.5 rounded-lg border @error('password') border-rose-300 bg-rose-50/50 @else border-slate-300 @enderror text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>

            <!-- Tombol Masuk -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold text-sm hover:bg-blue-700 shadow-sm hover:shadow transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <span>Masuk</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>

        <div class="mt-6 pt-6 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-500">
                Belum punya akun UMKM?
                <a href="{{ url('/register-umkm') }}" class="font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                    Daftarkan UMKM Anda Sekarang
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
