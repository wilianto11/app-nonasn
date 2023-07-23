<?php

use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PdController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PegawaiController;

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

Route::middleware(['guest:pegawai'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/Login', [AuthController::class, 'Login'])->name('Login');
});

Route::middleware(['guest:user'])->group(function () {
    Route::get('/admin', function () {
        return view('auth.adminlogin');
    })->name('adminlogin');
    Route::post('/adminlogin', [AuthController::class, 'adminlogin']);
});

Route::middleware(['auth:pegawai'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/Logout', [AuthController::class, 'Logout'])->name('Logout');
    Route::get('/camera', [AbsensiController::class, 'index'])->name('camera');
    Route::post('/camera-snap', [AbsensiController::class, 'store'])->name('camera-snap');

    # edit profile
    Route::get('/edit-profile', [AbsensiController::class, 'editProfile'])->name('edit-profile');
    Route::post('/update/{nik}/profile', [AbsensiController::class, 'updateProfile']);

    # history
    Route::get('/absensi-history', [AbsensiController::class, 'history'])->name('absensi-history');
    Route::post('/get-history', [AbsensiController::class, 'getHistory'])->name('get-history');

    # izin
    Route::get('/absensi-izin', [AbsensiController::class, 'izin'])->name('absensi-izin');
    Route::get('/absensi-izin/create', [AbsensiController::class, 'createizin'])->name('create-izin');
    Route::post('/absensi-izin/store', [AbsensiController::class, 'storeizin'])->name('store-izin');
});

Route::middleware(['auth:user'])->group(function () {
    Route::get('/admin/adminindex', [DashboardController::class, 'adminindex']);
    Route::get('/adminLogout', [AuthController::class, 'adminLogout'])->name('adminLogout');

    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai');
    Route::post('/pegawai/store', [PegawaiController::class, 'createstore'])->name('createstore');
    Route::post('/pegawai/editpegawai', [PegawaiController::class, 'editpegawai'])->name('editpegawai');
    Route::post('/pegawai/{nik}/updatepegawai', [PegawaiController::class, 'updatepegawai'])->name('updatepegawai');
    Route::post('/pegawai/{nik}/hapus', [PegawaiController::class, 'deletepegawai'])->name('deletepegawai');

    Route::get('/perangkatdaerah', [PdController::class, 'index'])->name('perangkatdaerah');
    Route::post('/perangkatdaerah/createstore', [PdController::class, 'createstore']);
    Route::post('/perangkatdaerah/editpd', [PdController::class, 'edit'])->name('edit');
    Route::post('/perangkatdaerah/{id_pd}/update', [PdController::class, 'update'])->name('update');
    Route::post('/perangkatdaerah/{id_pd}/delete', [PdController::class, 'delete'])->name('delete');

    Route::get('/absensi/cek', [AbsensiController::class, 'cekabsensi'])->name('cekabsensi');
    Route::post('/cekdata', [AbsensiController::class, 'cekdata'])->name('cekdata');
    Route::post('/showmap', [AbsensiController::class, 'showmap'])->name('showmap');

    Route::get('/absensi/laporan', [AbsensiController::class, 'laporan'])->name('laporan');
    Route::post('/absensi/printlaporan', [AbsensiController::class, 'printlaporan'])->name('printlaporan');
    Route::get('/absensi/laporanabsensi', [AbsensiController::class, 'laporanabsensi'])->name('laporanabsensi');
    Route::post('/absensi/printlaporanabsen', [AbsensiController::class, 'printlaporanabsen'])->name('printlaporanabsen');
    Route::get('/absensi/izinadmin', [AbsensiController::class, 'izinadmin'])->name('izinadmin');
    Route::post('/absensi/approved', [AbsensiController::class, 'approved'])->name('approved');
    Route::get('/absensi/{id}/batalapprove', [AbsensiController::class, 'batalapprove'])->name('batalapprove');

    Route::get('/lokasi/lokasikantor', [LokasiController::class, 'lokasikantor'])->name('lokasikantor');
    Route::post('/lokasi/updatelokasi', [LokasiController::class, 'updatelokasi'])->name('updatelokasi');
});

Route::get('/404', [DashboardController::class, '404']);
