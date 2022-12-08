<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbyssDemoController;


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

// Api's abyss demo routes group
Route::prefix('v1/record')->group(function() {
    Route::get('/all',      [AbyssDemoController::class, 'all']);
    Route::post('/create',  [AbyssDemoController::class, 'create']);
    Route::get('/get/{id}', [AbyssDemoController::class, 'getById']);
});
