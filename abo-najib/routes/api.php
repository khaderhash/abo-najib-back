<?php

use App\Http\Controllers\GoalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/goal',[GoalController::class,'index']);
Route::get('/goal/{id}',[GoalController::class,'show']);
Route::post('/addgoal',[GoalController::class,'store']);
Route::post('/updategoal/{id}',[GoalController::class,'update']);
Route::post('/deletegoal/{id}',[GoalController::class,'destroy']);
