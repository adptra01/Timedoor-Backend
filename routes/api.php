<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookCategoryController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    Route::apiResource('users', UserController::class);
    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('ratings', RatingController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('books', BookController::class);
    Route::apiResource('book-categories', BookCategoryController::class);
});

Route::get('authors/top', [AuthorController::class, 'top']);
