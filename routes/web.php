<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;

Route::group(['middleware' => 'guest'], function()
{
    Route::get('/masuk', [UserController::class, 'login'])->name('login');
    Route::post('/masuk', [UserController::class, 'postlogin'])->name('postlogin');

    Route::get('/daftar', [UserController::class, 'register'])->name('register');
    Route::post('/daftar', [UserController::class, 'postregister'])->name('postregister');

    Route::group(['as' => 'password'], function()
    {
        Route::get('/password/lupa', [UserController::class, 'lupaPassword'])->name('.request');
        Route::post('/password/lupa', [UserController::class, 'kirimResetLink'])->name('.email');

        Route::get('/password/reset', [UserController::class, 'perbaruiPassword_errorHandler'])->name('.resetErrorHandler');
        Route::get('/password/reset/{token}', [UserController::class, 'perbaruiPassword'])->name('.reset');
        Route::post('/password/reset', [UserController::class, 'updatePassword'])->name('.update');
    });
});

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/keluar', [UserController::class, 'logout'])->name('logout');

    Route::group(['as' => 'verification'], function()
    {
        // Email Verification
        Route::get('/email/verify', [PageController::class, 'verifyEmail'])->name('.notice');
        Route::get('/email/verify/notification', [PageController::class, 'ResendVerifEmail'])->middleware('throttle:6,1')->name('.send');
        Route::get('/email/verify/{id}/{hash}', [PageController::class, 'verifyEmailHandler'])->middleware('signed')->name('.verify');
    });
});

Route::group(['middleware' => 'verified'], function()
{
    Route::group(['middleware' => 'cekrole:member'], function()
    {
        Route::group(['as' => 'user'], function()
        {
            Route::get('/user/pengaturan', [UserController::class, 'controlPanel'])->name('_pengaturan');
            Route::put('/user/pengaturan', [UserController::class, 'edit_controlPanel'])->name('_editpengaturan');
        });

        Route::group(['as' => 'post'], function()
        {
            Route::get('/laporan/baru/tags', [PostController::class, 'category'])->name('.category');

            Route::get('/laporan/baru/barang', [PostController::class, 'create_barang'])->name('.create.barang');
            Route::post('/laporan/baru/barang', [PostController::class, 'store_barang'])->name('.store.barang');

            Route::get('/laporan/baru/kendaraan', [PostController::class, 'create_kendaraan'])->name('.create.kendaraan');
            Route::post('/laporan/baru/kendaraan', [PostController::class, 'store_kendaraan'])->name('.store.kendaraan');

            Route::get('/laporan/baru/orang', [PostController::class, 'create_orang'])->name('.create.orang');
            Route::post('/laporan/baru/orang', [PostController::class, 'store_orang'])->name('.store.orang');

            Route::post('/laporan/validasi/{csae_code}/ditemukan', [PostController::class, 'laporan_ditemukan'])->name('.validasi.ditemukan');
        });

        Route::group(['as' => 'report'], function()
        {
            Route::post('/report/laporan', [ReportController::class, 'report_laporan'])->name('.laporan');
            Route::post('/report/member', [ReportController::class, 'report_member'])->name('.member');
        });
    });

    Route::group(['middleware' => 'cekrole:staff'], function()
    {
        Route::group(['as' => 'staff'], function()
        {
            Route::get('/staff/panel', [StaffController::class, 'index'])->name('.panel');
        });

        Route::group(['as' => 'staff.laporan'], function()
        {
            Route::get('/staff/laporan/validasi', [StaffController::class, 'laporan_validasi_page'])->name('.validasi.page');
            Route::post('/staff/laporan/validasi', [StaffController::class, 'laporan_validasi'])->name('.validasi');
            Route::post('/staff/laporan/hapus', [StaffController::class, 'laporan_hapus'])->name('.hapus');
        });

        Route::group(['as' => 'staff.member'], function()
        {
            Route::get('/staff/member/validasi', [StaffController::class, 'member_validasi_page'])->name('.validasi.page');
            Route::post('/staff/member/validasi', [StaffController::class, 'member_validasi'])->name('.validasi');
            Route::post('/staff/member/hapus', [StaffController::class, 'member_hapus'])->name('.hapus');
        });
    });

    Route::group(['middleware' => 'cekrole:moderator'], function()
    {
        Route::group(['as' => 'staff.report'], function()
        {
            Route::get('/staff/report/laporan', [StaffController::class, 'report_laporan'])->name('.laporan.page');
            Route::post('/staff/report/laporan/approve', [StaffController::class, 'report_laporan_approve'])->name('.laporan.approve');
            Route::post('/staff/report/laporan/decline', [StaffController::class, 'report_laporan_decline'])->name('.laporan.decline');

            Route::get('/staff/report/member', [StaffController::class, 'report_member'])->name('.member.page');
            Route::post('/staff/report/member/approve', [StaffController::class, 'report_member_approve'])->name('.member.approve');
            Route::post('/staff/report/member/decline', [StaffController::class, 'report_member_decline'])->name('.member.decline');
        });
    });

    Route::group(['middleware' => 'cekrole:admin'], function()
    {
        Route::group(['as' => 'admin'], function()
        {
            Route::get('/admin/panel', [AdminController::class, 'index'])->name('.panel');
        });

        Route::group(['as' => 'admin.setting'], function()
        {
            Route::get('/admin/setting/laporan', [AdminController::class, 'setting_laporan'])->name('.laporan');
            Route::post('/admin/setting/laporan', [AdminController::class, 'setting_laporan_post'])->name('.laporan.post');

            Route::get('/admin/setting/user', [AdminController::class, 'setting_user'])->name('.user');
            Route::post('/admin/setting/user', [AdminController::class, 'setting_user_post'])->name('.user.post');
        });
    });

    // Route::group(['middleware' => 'cekrole:admin'], function()
    // {
    //
    // });

    // Route::group(['as' => 'admin'], function()
    // {
    //
    // });
});

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/donasi', [DonationController::class, 'index'])->name('donasi');
Route::get('/donasi/finish', [DonationController::class, 'donasi_finish'])->name('donasi_finish');
Route::get('/donasi/error', [DonationController::class, 'donasi_error'])->name('donasi_error');

Route::get('/@{username}', [UserController::class, 'userProfile'])->name('user_profile');

Route::group(['as' => 'post'], function()
{
    Route::get('/laporan', [PostController::class, 'index'])->name('.index');

    Route::get('/laporan?status=temu', [PostController::class, 'index'])->name('.index.temu');

    Route::get('/laporan?tags=barang', [PostController::class, 'index'])->name('.index.barang');
    Route::get('/laporan?tags=kendaraan', [PostController::class, 'index'])->name('.index.kendaraan');
    Route::get('/laporan?tags=orang', [PostController::class, 'index'])->name('.index.orang');

    Route::get('/laporan/{slugorcode}', [PostController::class, 'laporan_slugorcode'])->name('.slugorcode');
    Route::get('/laporan/{case_code}/{slug}', [PostController::class, 'laporan_lengkap'])->name('.lengkap');
});

Route::middleware(['ajax'])->group(function () {
    Route::get('/rc', [PageController::class, 'reloadCaptcha'])->name('reloadCaptcha');
});
