<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PadletController;

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
/*so werden Variablen übergeben, und die kann man dann in Views verwenden, Kurzschreibweise
(wenn in der View derselbe name benutzt wird) ist: compact('name'), hier haben wir jetz schon
Zugriff auf die DB-Tabelle padlets*/

//wenn wer auf die Route-URL kommt, soll er auf die PadletController Klasse kommen
Route::get('/', [PadletController::class,'index']);

/*generelle Listenansicht, auskommentiert, weil wir das jetzt über Model machen und nicht mehr hardkodiert*/
Route::get('/padlets', [PadletController::class,'index']);

/*Detailansicht, vorher stand statt "detail" "show"*/
Route::get('/padlets/{padlet}', [PadletController::class,'detail']);
