<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('{any?}', function() {
//     return view('application');
// })->where('any', '.*');

Route::prefix('api')->group(function () {
    Route::post('register', [App\Http\Controllers\Api\UserController::class, 'register']);
    Route::post('login', [App\Http\Controllers\Api\UserController::class, 'authenticate']);
    Route::get('inventory-item/{id}', [App\Http\Controllers\Api\InventoryItemController::class, 'index']);
    Route::post('inventory-item', [App\Http\Controllers\Api\InventoryItemController::class, 'store']);
    Route::delete('inventory-item/{id}', [App\Http\Controllers\Api\InventoryItemController::class, 'destroy']);
    Route::delete('inventory-item', [App\Http\Controllers\Api\InventoryItemController::class, 'destroyAll']);
});

Route::get('{any?}', function() {
    return view('application');
})->where('any', '^(?!api).*$');