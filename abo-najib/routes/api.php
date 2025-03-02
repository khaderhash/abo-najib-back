<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ReminderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['jwt.verify'])->group(function(){


    Route::get('/goal',[GoalController::class,'index']);
    Route::get('/goal/{id}',[GoalController::class,'show']);
    Route::post('/addgoal',[GoalController::class,'store']);
    Route::post('/updategoal/{id}',[GoalController::class,'update']);
    Route::post('/deletegoal/{id}',[GoalController::class,'destroy']);

});
Route::middleware(['jwt.verify'])->group(function() {
    Route::get('/Expense', [ExpenseController::class, 'index']);
    Route::get('/Expense/{id}', [ExpenseController::class, 'show']);
    Route::post('/addExpense', [ExpenseController::class, 'store']);
    Route::post('/updateExpense/{id}', [ExpenseController::class, 'update']);
    Route::post('/deleteExpense/{id}', [ExpenseController::class, 'destroy']);
});
Route::middleware(['jwt.verify'])->group(function() {
    Route::get('/Expense', [IncomeController::class, 'index']);
    Route::get('/Expense/{id}', [IncomeController::class, 'show']);
    Route::post('/addExpense', [IncomeController::class, 'store']);
    Route::post('/updateExpense/{id}', [IncomeController::class, 'update']);
    Route::post('/deleteExpense/{id}', [IncomeController::class, 'destroy']);
});
Route::middleware(['jwt.verify'])->group(function() {
    Route::get('/Expense', [ReminderController::class, 'index']);
    Route::get('/Expense/{id}', [ReminderController::class, 'show']);
    Route::post('/addExpense', [ReminderController::class, 'store']);
    Route::post('/updateExpense/{id}', [ReminderController::class, 'update']);
    Route::post('/deleteExpense/{id}', [ReminderController::class, 'destroy']);
});



Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('/profile', [AuthController::class, 'profile'])->middleware('auth:api');
});
