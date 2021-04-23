<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([], function ()
{
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/verify', [AuthController::class, 'verify'])->name('verify');
});
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group( function ()
{
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/subscriber/add', [WorkerController::class, 'addSubscriber']);
    Route::post('/subscribers/add', [WorkerController::class, 'addSubscribers']);

    Route::delete('/subscriber/remove/{id}', [WorkerController::class, 'removeSubscriber']);
    Route::delete('/subscribers/remove', [WorkerController::class, 'removeSubscribers']);

    Route::put('/subscriber/edit/{id}', [WorkerController::class, 'editSubscriber']);

    Route::put('/user/{id}', [WorkerController::class, 'getUser']);
    Route::put('/users/{page}', [WorkerController::class, 'getUsers']);
    Route::put('/subscribers/{page}', [WorkerController::class, 'getSubscribers']);
    Route::put('/filter/users', [WorkerController::class, 'getFilteredUsers']);

    Route::post('/send', [WorkerController::class, 'sendMessage']);
});
