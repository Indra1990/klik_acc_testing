<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseOrderController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/items', [ItemController::class, 'index']);
Route::get('/items-show/{id}', [ItemController::class, 'show']);
Route::get('/get-po', [PurchaseOrderController::class, 'getPo']);
Route::post('/create-new/po', [PurchaseOrderController::class, 'create_save']);
