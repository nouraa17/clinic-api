<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ClinicControllerResource;
use App\Http\Controllers\FeedbackControllerResource;
use App\Http\Controllers\HistoryControllerResource;
use App\Http\Controllers\QuestionControllerResource;
use App\Http\Controllers\ReservationControllerResource;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');

Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::middleware('auth')->group(function () {
    Route::resources([
        'clinic'=> ClinicControllerResource::class,
        'reservation'=> ReservationControllerResource::class,
        'question'=> QuestionControllerResource::class,
        'feedback'=> FeedbackControllerResource::class,
        'history'=> HistoryControllerResource::class,
    ]);
});

