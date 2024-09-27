<?php

use App\Http\Controllers\Api\ClinicController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::resources([
        'clinics' => ClinicController::class,
        'reservations' => ReservationController::class,
        'questions' => QuestionController::class,
        'feedbacks' => FeedbackController::class,
        'histories' => HistoryController::class,
        ]);
});

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    // users management
    Route::get('/users', [DashboardController::class, 'usersIndex']);
    Route::post('/users', [DashboardController::class, 'storeUser']);
    Route::get('/users/{user}', [DashboardController::class, 'showUser']);
    Route::put('/users/{user}', [DashboardController::class, 'updateUser']);
    Route::delete('/users/{user}', [DashboardController::class, 'deleteUser']);

    // clinics management
    Route::get('/clinics', [DashboardController::class, 'clinicsIndex']);
    Route::post('/clinics', [DashboardController::class, 'storeClinic']);
    Route::get('/clinics/{clinic}', [DashboardController::class, 'showClinic']);
    Route::put('/clinics/{clinic}', [DashboardController::class, 'updateClinic']);
    Route::delete('/clinics/{clinic}', [DashboardController::class, 'deleteClinic']);

    // reservations management
    Route::get('/reservations', [DashboardController::class, 'reservationsIndex']);
    Route::post('/reservations', [DashboardController::class, 'storeReservation']);
    Route::get('/reservations/{reservation}', [DashboardController::class, 'showReservation']);
    Route::put('/reservations/{reservation}', [DashboardController::class, 'updateReservation']);
    Route::delete('/reservations/{reservation}', [DashboardController::class, 'deleteReservation']);

    // questions management
    Route::get('/questions', [DashboardController::class, 'questionsIndex']);
    Route::post('/questions', [DashboardController::class, 'storeQuestion']);
    Route::get('/questions/{question}', [DashboardController::class, 'showQuestion']);
    Route::put('/questions/{question}', [DashboardController::class, 'updateQuestion']);
    Route::delete('/questions/{question}', [DashboardController::class, 'deleteQuestion']);

    // feedbacks management
    Route::get('/feedbacks', [DashboardController::class, 'feedbacksIndex']);
    Route::post('/feedbacks', [DashboardController::class, 'storeFeedback']);
    Route::get('/feedbacks/{feedback}', [DashboardController::class, 'showFeedback']);
    Route::put('/feedbacks/{feedback}', [DashboardController::class, 'updateFeedback']);
    Route::delete('/feedbacks/{feedback}', [DashboardController::class, 'deleteFeedback']);

    // histories management
    Route::get('/histories', [DashboardController::class, 'historiesIndex']);
    Route::post('/histories', [DashboardController::class, 'storeHistory']);
    Route::get('/histories/{history}', [DashboardController::class, 'showHistory']);
    Route::put('/histories/{history}', [DashboardController::class, 'updateHistory']);
    Route::delete('/histories/{history}', [DashboardController::class, 'deleteHistory']);
});
