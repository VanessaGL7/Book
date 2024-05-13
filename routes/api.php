<?php

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
Route::post('/register', [RegisterController::class, 'register']);

Route::put('/user/username', [UserController::class, 'updateUsername']);
Route::put('/user/password', [UserController::class, 'updatePassword']);
Route::put('/user/profile-picture', [UserController::class, 'updateProfilePicture']);

Route::get('/book', [BookController::class, 'index']);
Route::get('/book/{id}', [BookController::class, 'show']);
Route::post('/book', [BookController::class, 'store']);
Route::put('/book/{id}', [BookController::class, 'update']);
Route::delete('/book/{id}', [BookController::class, 'destroy']);

Route::get('/favorites/{id_user}', [FavoriteController::class, 'getUserFavorites']);

Route::get('/books/{id_book}/valuation', [ValorationController::class, 'show']);


Route::post('/books/{id_book}/valoration', [ValorationController::class, 'store']);
Route::put('/valoration/{id_valoration}', [ValorationController::class, 'update']);
Route::delete('/valoration/{id_valoration}', [ValorationController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
