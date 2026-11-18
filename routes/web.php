<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

// 1. Rutas Públicas para el Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. Rutas Protegidas (Tu sistema actual)
Route::middleware(['auth'])->group(function () {
    
    // AQUÍ ESTÁN LAS RUTAS QUE FALTABAN:
    Route::get('/cambiar-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/cambiar-password', [AuthController::class, 'updatePassword'])->name('password.update');

    // Tus rutas del panel
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::post('/usuario/crear', [AdminController::class, 'crearUsuario'])->name('admin.usuario.crear');
    Route::post('/usuario/toggle/{id}', [AdminController::class, 'toggleActivo'])->name('admin.usuario.toggle');
    Route::get('/usuario/{id}/asistencias', [AdminController::class, 'usuarioAsistencias'])->name('admin.usuario.asistencias');
});