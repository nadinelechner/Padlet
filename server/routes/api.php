<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PadletController;

/*
|--------------------------------------------------------------------------
| API Routes - unsere Datenschnittstelle
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("padlets",[PadletController::class,'index']);
//Route::get("padlets/{private}",[PadletController::class,'showprivateonly']);
Route::get("padlets/{id}",[PadletController::class,'detail']);
//Route::get("padlets/checkname/{name}",[PadletController::class,'checkname']);
//Route::get("padlets/findbysearchterm/{searchterm}",[PadletController::class,'findbysearchterm']);
Route::post('padlets', [PadletController::class,'save']);
Route::put('padlets/{name}', [PadletController::class,'update']);
Route::delete('padlets/{name}', [PadletController::class,'delete']);

