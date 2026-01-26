<?php
/**
 * @author <mdadalkhan@gmail.com>
 * 21/01/2026
 * */
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\CFeedback; 


use App\Http\Controllers\CAuth;
use App\Http\Controllers\SmsGetWay;



Route::get('/',               [CAuth::class, 'ViewLogin'])->name('login');
Route::post('/',              [CAuth::class,'login'])->name('SubmitLogin');
Route::post('/logout',        [CAuth::class, 'logout'])->name('logout');
// Route::post('/send-sms',       [SmsGetWay::class,'TestSMS'])->name('send_sms'); 
Route::post('/send-feedback', [CFeedback::class,'StoreFeedback'])->name('SendFeedback');




Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); });
});

