<?php
/**
 * @author <mdadalkhan@gmail.com>
 * 21/01/2026
 * MD. Adal Khan
 * */
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CFeedback; 
use App\Http\Controllers\CAuth;
use App\Http\Controllers\CAdminDashboard;
use App\Http\Controllers\CAdminNavbar;
use App\Http\Controllers\CAdminNavbarReport;



 
Route::middleware(['throttle:public'])->group(function(){
    Route::get('/login',          [CAuth::class,    'viewLogin'])->name('login');
    Route::post('/login',         [CAuth::class,    'login'])->name('login.submit');
    Route::post('/logout',        [CAuth::class,    'logout'])->name('logout');
    Route::post('/send-feedback', [CFeedback::class,'storeFeedback'])->name('sendfeedback');
});



Route::middleware(['auth'])->group(function () {
    /**
     * Authenticated routes for admin.
     * */
    Route::get('/',                    [CAuth::class,                     'feedback'])->name('welcome');
    Route::get('/admin',               [CAdminDashboard::class,     'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/feedback/{id}', [CAdminDashboard::class,'getIndividualReport'])->name('feedback.report');

    /**
     * Navbar for admin
     * */
     Route::get('/admin/hostel',                              [CAdminNavbar::class,                      'hostel'])->name('admin.navbar.hostel');
     Route::get('/admin/report',                              [CAdminNavbar::class,                      'report'])->name('admin.navbar.report');
     Route::post('/admin/report/generate',                    [CAdminNavbarReport::class, 'getGuestReportSummary'])->name('admin.navbar.report.summary');



     Route::get('/admin/checkout',     [CAdminNavbar::class, 'checkout'])->name('admin.navbar.checkout');
     /**
      * Handling 419 Error
      * */
     Route::get('/admin/csrf', [CFeedback::class,'csrfRefresh'])->name('csrf.refresh');   
});

