<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\ProductCategoryController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Khusus route API, ntar urlnya gini : 127.0.0.1:8000/api/[nama-route]
Route::get('/products', [ProductController::class, 'all']);
Route::get('/categories', [ProductCategoryController::class, 'all']);

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', [UserController::class, 'fetch']); //Untuk ambil data user yang login (auth:sanctum)
    Route::post('/user', [UserController::class, 'updateProfile']);
    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/transactions', [TransactionController::class, 'all']);
    Route::post('/checkout', [TransactionController::class, 'checkout']);
});
