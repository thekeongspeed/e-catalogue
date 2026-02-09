<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Halaman Utama (Bisa diakses siapa saja)
Route::get('/', [ProductController::class, 'index'])->name('home');

// Login & Logout
Route::get('/login', [ProductController::class, 'loginForm'])->name('login');
Route::post('/login', [ProductController::class, 'loginProcess']);
Route::get('/logout', [ProductController::class, 'logout']);

// Print PDF (Publik boleh print)
Route::get('/print', [ProductController::class, 'printProduct']);
Route::get('/print-customer', [ProductController::class, 'printCustomer']);

// Aksi Admin (Simpan & Hapus)
Route::post('/store', [ProductController::class, 'store']);
Route::get('/delete/{id}', [ProductController::class, 'destroy']); // Tambahan fitur hapus
Route::get('/customer/{name}', [ProductController::class, 'showCustomer']);

Route::get('/manage', [ProductController::class, 'manageData']);

// Route untuk halaman detail produk (pengganti modal)
Route::get('/detail/{id}', [ProductController::class, 'detailProduct']);

// --- ROUTE EDIT TERPISAH ---

// 1. Edit Spesifikasi (Info Utama, Dimensi, Material, Gallery)
Route::get('/edit-spec/{id}', [ProductController::class, 'editSpec']);
Route::put('/update-spec/{id}', [ProductController::class, 'updateSpec']);

// 2. Edit Parts (Komponen)
Route::get('/edit-parts/{id}', [ProductController::class, 'editParts']);
Route::put('/update-parts/{id}', [ProductController::class, 'updateParts']);

// 3. Edit Project Reference
Route::get('/edit-project/{id}', [ProductController::class, 'editProject']);
Route::put('/update-project/{id}', [ProductController::class, 'updateProject']);

// Route untuk memproses UPDATE data (menggunakan method PUT)
Route::put('/update/{id}', [ProductController::class, 'updateData']);

