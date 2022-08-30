<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesertaController;

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
Route::get('/phpinfo', function() {
    return phpinfo();
});
Route::get('/', function () {
    if(isset(Auth::user()->email)){
        return redirect('/dashboard');
    }
    else{        
        return view('landing');
    }
});

Route::middleware('auth')->group(function () {

    Route::controller(DashboardController::class)->group(function() {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::post('/uploadBuktiBayar', 'uploadBuktiBayar');
        Route::post('/updateBuktiBayar', 'updateBuktiBayar');
        
        Route::get('/pembayaran', 'pembayaran');
        Route::post('/accPembayaran', 'accPembayaran');
    });
    Route::controller(PesertaController::class)->group(function() {
        Route::get('/peserta', 'index')->name('dashboard');
        Route::post('/donePayment', 'donePayment');
        Route::post('/updatePeserta/{biodata}', 'updatePeserta');
        Route::post('/createPeserta/{biodata}', 'createPeserta');
        Route::get('/biodata/{biodata}', 'biodata');
        Route::post('/accPeserta', 'accPeserta');

    });
    
});

require __DIR__.'/auth.php';
