
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/bagian', [AuthController::class, 'bagian'])->name('bagian');
    Route::get('/level', [AuthController::class, 'level'])->name('level');
    Route::get('/status', [AuthController::class, 'status'])->name('status');
    Route::get('/user', [AuthController::class, 'user'])->name('user');
    Route::get('/userprofile', [AuthController::class, 'userprofile'])->name('userprofile');
    Route::get('/proyek', [AuthController::class, 'proyek'])->name('proyek'); 
    Route::get('/keterangan', [AuthController::class, 'keterangan'])->name('keterangan');
    Route::get('/aktivitas', [AuthController::class, 'aktivitas'])->name('aktivitas');
    Route::get('/ModeJamKerja', [AuthController::class, 'ModeJamKerja'])->name('mode.jam.kerja');
    Route::get('/StatusJamKerja', [AuthController::class, 'StatusJamKerja'])->name('status.jam.kerja');
    Route::get('/progresKerja', [AuthController::class, 'progresKerja'])->name('progres.kerja');
    Route::get('/lembur', [AuthController::class, 'lembur'])->name('lembur');
    Route::get('/pesan', [AuthController::class, 'pesan'])->name('pesan');
    Route::get('/jenisPesan', [AuthController::class, 'jenisPesan'])->name('jenis.pesan');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');


    Route::post('/upload-foto', [AuthController::class, 'uploadFoto'])->name('upload.foto');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/', function () {
    return view('welcome');
});
