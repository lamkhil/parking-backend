<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//login
use App\Http\Controllers\AuthController;
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

//parking
use App\Http\Controllers\ParkingController;
Route::get('/vehicle-type',[ParkingController::class, 'vehicleType'])->middleware('auth:sanctum');
Route::post('/entry-and-exit', [ParkingController::class, 'entryAndExit'])->middleware('auth:sanctum');
