<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SewaController;
use App\Http\Controllers\Api\CameraController;

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

Route::post('/login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->group(function() {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::post('/sewa', [SewaController::class, 'store']);
    Route::get('/sewa/{id}', [SewaController::class, 'show']);
    Route::put('/sewa/{id}', [SewaController::class, 'update']);
    Route::delete('/sewa/{id}', [SewaController::class, 'destroy']);
    Route::get('/sewa/{id}/edit', [SewaController::class, 'edit']);

    Route::get('/camera', [CameraController::class, 'index']);
    Route::get('/camera/{id}', [CameraController::class, 'show']);
// });
