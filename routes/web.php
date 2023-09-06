<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return redirect('/login');
    if(isset(Auth::user()->email)){
        return redirect('/dashboard');
    }
    else{
        return view('landing');
    }
});
Route::get('/register', function () {
    return redirect('/login');
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

        Route::get('/changePassword', 'changePassword');
        Route::post('/changePassword', 'saveChangePassword');
    });
    Route::controller(PesertaController::class)->group(function() {
        Route::get('/peserta', 'index');
        Route::post('/peserta', 'create');
        Route::post('/donePayment', 'donePayment');
        Route::post('/updatePeserta/{biodata}', 'updatePeserta');
        Route::post('/createPeserta/{biodata}', 'createPeserta');
        Route::get('/biodata/{biodata}', 'biodata');
        Route::post('/accPeserta', 'accPeserta');

    });
    Route::controller(SoalController::class)->group(function() {
        Route::get('/banksoal/{sublink}', 'index');
        Route::post('/createSoal', 'store');
        Route::post('/deleteSoal', 'destroy');
        Route::get('/test', 'test');
    });
    Route::controller(TimeController::class)->group(function() {
        Route::post('/setTime/{babak}', 'setTime');
        Route::post('/updateTime/{babak}', 'updateTime');
        Route::get('/getTimes', function(){
            return redirect('/dashboard');
        });
        Route::post('/getTimes', 'getTimes');
        Route::get('/getTime', function(){
            return redirect('/dashboard');
        });
        Route::post('/getTime', 'getTime');
    });
    Route::controller(AnswerController::class)->group(function() {
        Route::get('/nilai/{sublink}', 'nilai');
        Route::post('/answer', 'store');
        Route::post('/uploadSesi2', 'upload');
        Route::post('/updateNilaiFile', 'updateNilai');
        // Route::get('/export/{babak}', 'export');
    });

    Route::controller(AnswerFileController::class)->group(function() {
        Route::get('/export/{babak}', 'export');
    });

});

require __DIR__.'/auth.php';
