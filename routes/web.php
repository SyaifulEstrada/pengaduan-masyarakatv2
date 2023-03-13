<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'index'])->name('pemas.index');

Route::post('/login/auth', [UserController::class, 'login'])->name('pemas.login');

Route::post('/registrasi', [UserController::class, 'registrasi'])->name('pemas.daftar');

Route::post('/store', [UserController::class, 'storePengaduan'])->name('pemas.store');
Route::get('/laporan/{siapa?}', [UserController::class, 'laporan'])->name('pemas.laporan');

Route::get('/logout', [UserController::class, 'logout'])->name('pemas.logout');

