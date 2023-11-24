<?php

use App\Http\Controllers\ScheduleController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('tasks')->group(function () {
    Route::get('/',[ScheduleController::class,'index']);
    Route::get('/getTask/{id}',[ScheduleController::class,'show']);
    Route::post('/addTask',[ScheduleController::class,'store']);
    Route::post('/updateTask/{id}',[ScheduleController::class,'update']);
    Route::delete('/deleteTask/{id}',[ScheduleController::class,'destroy']);
});

