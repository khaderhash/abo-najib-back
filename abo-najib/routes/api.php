<?php

use App\Http\Controllers\GoalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/goal',[GoalController::class,'index']);
Route::get('/goal/{id}',[GoalController::class,'show']);
Route::post('/addgoal',[GoalController::class,'store']);
Route::post('/updategoal/{id}',[GoalController::class,'update']);
Route::post('/deletegoal/{id}',[GoalController::class,'destroy']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('profile', [AuthController::class, 'userProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

});
