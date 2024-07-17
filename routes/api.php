<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix('v1')->group(function (){
    Route::apiResource('blog', BlogController::class);
    Route::post('post/{post}/like',[PostController::class,'likePost']);
    Route::post('post/{post}/comment',[PostController::class,'comment']);
    Route::apiResource('post', PostController::class);
});
