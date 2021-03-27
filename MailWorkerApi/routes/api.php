<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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
    Route::post('/subscriber/add', [UserController::class, 'addSubscriber']);

});
