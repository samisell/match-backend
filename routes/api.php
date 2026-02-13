<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserPhotoController;
use App\Http\Controllers\Api\UserPreferenceController;
use App\Http\Controllers\Api\UserMatchController;
use App\Http\Controllers\Api\MessageController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('users', UserController::class);
    Route::apiResource('users.photos', UserPhotoController::class)->shallow();
    Route::apiResource('users.preferences', UserPreferenceController::class)->shallow();
    Route::apiResource('users.matches', UserMatchController::class)->shallow();
    Route::apiResource('users.messages', MessageController::class)->shallow();

    Route::middleware('is_admin')->prefix('admin')->group(function () {
        Route::apiResource('email-templates', \App\Http\Controllers\Api\Admin\EmailTemplateController::class);
    });
});