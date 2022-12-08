<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Using for file's temp url
Route::get('fakepath/{path}', function (string $path, Request $request){

    $actualPath = "abyss/{$path}";

    if(!$request->hasValidSignature()) {
        if($request->ajax()) {
            return response()->json([
                'message' => 'unauthorized access denied!'
            ], 401);
        } else {
            abort(401);
        }
    }
    
    return Storage::disk('local')->download($actualPath);
})->name('abyss.temp');