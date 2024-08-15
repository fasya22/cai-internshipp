<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AkunHrdController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosisiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\AspekPenilaianController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AkunMentorController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\DataMagangController;
use App\Http\Controllers\EnglishCertificatesController;
use App\Http\Controllers\HrdController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\PendaftaranMagangController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

Route::get("/", [LowonganController::class, "getlowonganhome"])->name("getlowonganhome");
Route::get("/jobs", [LowonganController::class, "getlowongan"])->name("getlowongan");
// Route::get('/jobs', function () {
//     return view('front.pages.jobs');
// });
Route::get('/contact', function () {
    return view('front.pages.contact');
});
Route::get('/about', function () {
    return view('front.pages.about');
});

// Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware(['auth', 'verified']);
Route::get('/home/periode/{periodeId}', [HomeController::class, 'getChartData'])
    ->name('getChartData')
    ->middleware(['auth', 'verified']);
Route::get('/home/posisi/{posisiId}', [HomeController::class, 'getPosisiChartData'])
    ->name('getPosisiChartData')
    ->middleware(['auth', 'verified']);
Route::get('/apply-job/{lowongan_uid}', [App\Http\Controllers\DataMagangController::class, 'applyJob'])->middleware(['auth', 'verified'])->name('apply-job');
Route::resource('posisi', PosisiController::class)->middleware(['auth', 'verified']);
Route::resource('english-certificates', EnglishCertificatesController::class)->middleware(['auth', 'verified']);
Route::resource('aspek-penilaian', AspekPenilaianController::class)->middleware(['auth', 'verified']);
Route::resource('periode', PeriodeController::class)->middleware(['auth', 'verified']);
Route::resource('mentor', MentorController::class)->middleware(['auth', 'verified']);
Route::resource('peserta', PesertaController::class)->middleware(['auth', 'verified']);
Route::resource('list-pendaftar', PendaftaranMagangController::class)->middleware(['auth', 'verified']);
Route::resource('peserta-magang', DataMagangController::class)->middleware(['auth', 'verified']);
Route::post('pendaftaran/change-status/{id}/{status}', [PendaftaranMagangController::class, 'changeStatus'])->name('pendaftaran.changeStatus');
Route::post('pendaftaran/change-recommendation-status/{id}/{status}', [PendaftaranMagangController::class, 'changeRecommendationStatus'])->name('changeRecommendationStatus');
Route::resource('lowongan', LowonganController::class)->middleware(['auth', 'verified']);
Route::put('/project/{id}/updateStatusAndFeedback/{uid}', [ProjectController::class, 'updateStatusAndFeedback'])->middleware(['auth', 'verified'])->name('project.updateStatusAndFeedback');
Route::put('/project/{id}/updateProjectPeserta', [ProjectController::class, 'updateProjectPeserta'])->middleware(['auth', 'verified'])->name('project.updateProjectPeserta');
Route::get('/data-logbook/{uid}', [LogbookController::class, 'index'])->middleware(['auth', 'verified'])->name('data-logbook.index');

Route::put('/data-logbook/{id}/updateStatusAndFeedback/{uid}', [LogbookController::class, 'updateStatusAndFeedback'])->middleware(['auth', 'verified'])->name('logbook.updateStatusAndFeedback');
Route::get('/data-project/{uid}', [ProjectController::class, 'index'])->middleware(['auth', 'verified'])->name('data-project.index');
Route::post('/data-project/{uid}/store', [ProjectController::class, 'store'])->middleware(['auth', 'verified'])->name('data-project.store');
Route::put('/data-project/{id}/update/{uid}', [ProjectController::class, 'update'])->middleware(['auth', 'verified'])->name('data-project.update');
Route::delete('/data-project/{id}/destroy/{uid}', [ProjectController::class, 'destroy'])->middleware(['auth', 'verified'])->name('data-project.destroy');
Route::get('/data-penilaian/{uid}', [PenilaianController::class, 'index'])->middleware(['auth', 'verified'])->name('data-penilaian.index');
Route::post('/data-penilaian/{uid}/store', [PenilaianController::class, 'store'])->middleware(['auth', 'verified'])->name('data-penilaian.store');
Route::put('/data-penilaian/{id}/update/{uid}', [PenilaianController::class, 'update'])->middleware(['auth', 'verified'])->name('data-penilaian.update');
Route::delete('/data-penilaian/{id}/destroy/{uid}', [PenilaianController::class, 'destroy'])->middleware(['auth', 'verified'])->name('data-penilaian.destroy');
// Route::delete('/data-project/{lowongan_id}/projects/{project_id}/delete', [ProjectController::class, 'deleteProject'])->name('data-project.delete');
Route::get('/history-magang', [DataMagangController::class, 'historyMagang'])->middleware(['auth', 'verified']);
Route::get('/kegiatan-magang', [DataMagangController::class, 'historyMagangMentor'])->middleware(['auth', 'verified'])->name('historyMagangMentor');
Route::get('/list-pendaftar/detail/{uid}', [PendaftaranMagangController::class, 'getlistpendaftar'])->middleware(['auth', 'verified'])->name('getlistpendaftar');
Route::get('/daftar-pelamar', [PendaftaranMagangController::class, 'getlistpendaftarhrd'])->middleware(['auth', 'verified'])->name('getlistpendaftarhrd');
Route::get('/peserta-magang/detail/{lowongan_uid}', [DataMagangController::class, 'getlistpeserta'])->middleware(['auth', 'verified'])->name('getlistpeserta');
Route::get('/get-available-periodes/{posisiId}', [LowonganController::class, 'getAvailablePeriodes']);

// Route::resource('pendaftaran', MagangController::class)->middleware(['auth']);
// Route::get('/job-details', function () { return view('front.pages.job-details');});
Route::resource('user-mentor', AkunMentorController::class)->middleware(['auth', 'is_admin']);
Route::resource('hrd', HrdController::class)->middleware(['auth', 'is_admin']);
Route::resource('user-hrd', AkunHrdController::class)->middleware(['auth', 'is_admin']);

Route::get('/job-details/{uid}', [LowonganController::class, 'show'])->name('job-details');

Route::get('/cai-internship/{uid}', [MagangController::class, 'index'])->middleware(['auth', 'verified'])->name('cai-internship');
Route::get('/kegiatan-magang/{lowongan_uid}', [MagangController::class, 'show'])->middleware(['auth', 'verified'])->name('kegiatan-magang');

Route::post('/apply-job/{lowongan_uid}', [DataMagangController::class, 'store'])->middleware(['auth', 'verified'])->name('apply-job.store');
// Route::get('/cai-internship/{id}', 'magang@namaMetode')->name('cai-internship');
// Route::resource('magang', DataMagangController::class);


Route::group(['prefix' => 'logbook', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/{magang_uid}', [LogbookController::class, 'getlogbookpeserta'])->name('logbook.index');
    Route::get('/{magang_uid}/create', [LogbookController::class, 'create'])->name('logbook.create');
    Route::post('/{magang_uid}', [LogbookController::class, 'store'])->name('logbook.store');
    Route::get('/{magang_uid}/{id}', [LogbookController::class, 'show'])->name('logbook.show');
    Route::get('/{magang_uid}/{id}/edit', [LogbookController::class, 'edit'])->name('logbook.edit');
    Route::put('/{magang_uid}/{id}', [LogbookController::class, 'update'])->name('logbook.update');
    Route::delete('/{magang_uid}/{id}', [LogbookController::class, 'destroy'])->name('logbook.destroy');
});
Route::group(['prefix' => 'project', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/{magang_uid}', [ProjectController::class, 'getprojectpeserta'])->name('project.index');
    Route::get('/{magang_id}/create', [ProjectController::class, 'create'])->name('project.create');
    // Route::post('/{magang_id}', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/{magang_id}/{id}', [ProjectController::class, 'show'])->name('project.show');
    Route::get('/{magang_id}/{id}/edit', [ProjectController::class, 'edit'])->name('project.edit');
    Route::put('/{magang_id}/{id}', [ProjectController::class, 'update'])->name('project.update');
    Route::delete('/{magang_id}/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');
});
Route::group(['prefix' => 'penilaian', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/{magang_uid}', [PenilaianController::class, 'getpenilaianpeserta'])->name('penilaian.index');
});

Route::get('/cetak-penilaian/{magang_uid}', [PenilaianController::class, 'cetakPenilaian'])->middleware(['auth', 'verified'])->name('cetakPenilaian');
Route::get('/cetak-logbook/{magang_uid}', [LogbookController::class, 'cetakLogbook'])->middleware(['auth', 'verified'])->name('cetakLogbook');


Route::prefix('profil-peserta')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/{uid}', [PesertaController::class, 'show'])->name('profil-peserta.show');
    Route::get('/{uid}/edit', [PesertaController::class, 'edit'])->name('profil-peserta.edit');
    Route::put('/{uid}/update', [PesertaController::class, 'update'])->name('profil-peserta.update');
});
Route::prefix('profil-mentor')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/{uid}', [MentorController::class, 'show'])->name('profil-mentor.show');
    Route::get('/{uid}/edit', [MentorController::class, 'edit'])->name('profil-mentor.edit');
    Route::put('/{uid}/update', [MentorController::class, 'updateProfil'])->name('profil-mentor.update');
});
Route::prefix('profil-hrd')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/{uid}', [HrdController::class, 'show'])->name('profil-hrd.show');
    Route::get('/{uid}/edit', [HrdController::class, 'edit'])->name('profil-hrd.edit');
    Route::put('/{uid}/update', [HrdController::class, 'updateProfil'])->name('profil-hrd.update');
});
Route::prefix('profil-admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/{uid}', [AdminController::class, 'show'])->name('profil-admin.show');
    Route::get('/{uid}/edit', [AdminController::class, 'edit'])->name('profil-admin.edit');
    Route::put('/{uid}/update', [AdminController::class, 'update'])->name('profil-admin.update');
});

// Route::get('/admin/dashboard', [HomeController::class, 'dashboardAdmin'])->name('dashboardAdmin');
Route::get('/list-pendaftar/filter', [PendaftaranMagangController::class, 'filter'])->middleware(['auth', 'verified'])->name('filterPendaftaran');
Route::get('/peserta-magang/filter', [DataMagangController::class, 'filter'])->middleware(['auth', 'verified'])->name('filterPeserta');
Route::get('/kegiatan-magang/filter', [DataMagangController::class, 'filterHistory'])->middleware(['auth', 'verified'])->name('filterHistory');

Route::post('/simpan-penilaian/{id}', [PendaftaranMagangController::class, 'simpanPenilaian'])->name('simpan-penilaian');
Route::post('/change-acceptance-status/{id}/{status}', [PendaftaranMagangController::class, 'changeAcceptanceStatus'])->name('changeAcceptanceStatus');
Route::get('/list-pendaftar/export-pdf', [PendaftaranMagangController::class, 'exportPdf'])->name('list-pendaftar.exportPdf');
Route::get('/mentor/export-excel', [MentorController::class, 'exportExcel'])->name('mentor.excel');
