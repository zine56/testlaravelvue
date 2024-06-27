<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserDataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('homepage');
    Route::post('/data', [UserDataController::class, 'store']);
    Route::get('/data', [UserDataController::class, 'index']);
});


