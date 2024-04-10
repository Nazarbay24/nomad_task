<?php

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


Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function ()
{
    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('profile', [\App\Http\Controllers\UserController::class, 'myProfile']);
    Route::put('profile/update', [\App\Http\Controllers\UserController::class, 'updateProfile']);

    Route::prefix('contact')->group(function ()
    {
        Route::post('get-all', [\App\Http\Controllers\ContactController::class, 'myContacts']);
        Route::post('create', [\App\Http\Controllers\ContactController::class, 'create']);
        Route::post('update/{id}', [\App\Http\Controllers\ContactController::class, 'update']);
        Route::post('delete/{id}', [\App\Http\Controllers\ContactController::class, 'delete']);
    });

});
