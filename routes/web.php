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
use App\Http\Controllers\CAdminHostelCheckin;
use App\Http\Controllers\CAdminNavbar;
use App\Http\Controllers\CAdminNavbarHostel;
use App\Http\Controllers\CAdminNavbarReport;
use App\Http\Controllers\CHostelBooking;

Route::middleware(['throttle:public'])->group(function(){
    Route::post('/logout',        [CAuth::class,      'logout'])->name('logout');
    Route::get('/login',          [CAuth::class,     'viewLogin'])->name('login');
   
    Route::get('/checkin/{id}',   [CAdminHostelCheckin::class,'showCheckinForm'])->name('checkin.form');
    Route::get('/',               [CHostelBooking::class,'index'])->name('hostel');
});

Route::middleware(['throttle:login'])->group(function(){
      Route::post('/login',[CAuth::class,'login'])->name('submit.login');
});



Route::middleware(['auth'])->group(function () {
    /**
     * Authenticated routes for admin.
     * */
   // Route::get('/',                  [CAuth::class,                     'feedback'])->name('welcome');
    Route::get('/admin',               [CAdminDashboard::class,     'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/feedback/{id}', [CAdminDashboard::class,'getIndividualReport'])->name('feedback.report');
    Route::post('/send-feedback', [CFeedback::class,  'storeFeedback'])->name('sendfeedback');
    /**
     * Navbar for admin
     * */
     Route::get('/admin/hostel',                              [CAdminNavbar::class,                      'hostel'])->name('admin.navbar.hostel');
     
     Route::post('/admin/hostel/seats/create',                [CAdminNavbarHostel::class,'saveSeatInfo'])->name('admin.navbar.hostel.save_seat');
     Route::post('/admin/hostel/seats/delete/{id}',           [CAdminNavbarHostel::class,'deleteSeatInfo'])->name('admin.navbar.hostel.delete_seat');
     Route::get('/admin/hostel/seats/edit/{id}',              [CAdminNavbarHostel::class,'editSeatInfoView'])->name('admin.navbar.hostel.edit_seat_view');
     Route::post('/admin/hostel/seats/edit/{id}',             [CAdminNavbarHostel::class,'editSeatInfoSubmit'])->name('admin.navbar.hostel.edit_seat_submit');
     Route::post('/admin/hostel/seats/checkin',               [CAdminNavbarHostel::class,'editSeatInfoSubmit'])->name('admin.hostel.seats.checkin');



     Route::get('/admin/report',                              [CAdminNavbar::class,                      'report'])->name('admin.navbar.report');
     Route::post('/admin/report/generate',                    [CAdminNavbarReport::class, 'getGuestReportSummary'])->name('admin.navbar.report.summary');



     Route::get('/admin/checkout',     [CAdminNavbar::class, 'checkout'])->name('admin.navbar.checkout');
     /**
      * Handling 419 Error
      * */
     Route::get('/admin/csrf', [CFeedback::class,'csrfRefresh'])->name('csrf.refresh');   
});

