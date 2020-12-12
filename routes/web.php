<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseOrderController;
/*

*/
Route::get('/', [PurchaseOrderController::class, 'index']);
Route::get('/create-new', [PurchaseOrderController::class, 'create_page']);
// Route::post('/create-new', [PurchaseOrderController::class, 'create_save']);
Route::get('/update/{id}', [PurchaseOrderController::class, 'update_page']);
