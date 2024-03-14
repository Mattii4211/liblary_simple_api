<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RentalController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


#BookController
Route::get('/books/list', [BookController::class, 'index']);
Route::get('/books/{book}', [BookController::class, 'show']);

#CustomerController
Route::get('/customers/list', [CustomerController::class, 'index']);
Route::get('/customers/{customer}', [CustomerController::class, 'show']);
Route::post('/customers/add', [CustomerController::class, 'store']);
Route::delete('/customers/{customer}/remove', [CustomerController::class, 'destroy']);

#RentalController
Route::post('/rental/add', [RentalController::class, 'store']);
Route::delete('/rental/{rental}/remove', [RentalController::class, 'destroy']);