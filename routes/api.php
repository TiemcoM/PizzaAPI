<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PizzaController;
use App\Http\Controllers\Api\AuthController;

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

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('signup', [AuthController::class, 'signup']);
    });
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('/getallpizzas', [PizzaController::class, 'getAllPizzas']);
        Route::get('/getpizza/{id}', [PizzaController::class, 'getPizza']);
        Route::post('/createpizza', [PizzaController::class, 'createPizza']);
        Route::put('/updatepizza/{id}', [PizzaController::class, 'updatePizza']);
        Route::delete('/deletepizza/{id}', [PizzaController::class, 'deletePizza']);
    });
