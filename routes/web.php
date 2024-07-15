<?php

use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('login');
});

Route::get('auth/google',[GoogleAuthController::class,'redirect'])->name('google.auth');
Route::get('auth/google/call-back',[GoogleAuthController::class,'callbackGoogle']);

Route::get('/dashboard/{user_id}', [GoogleAuthController::class,'dashboard'])->name('dashboard');