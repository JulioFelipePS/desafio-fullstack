<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\UserController;
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

Route::apiResource('/mentors', MentorController::class)->except('index')->middleware(['auth:sanctum', 'admin']);
Route::get('mentors',[MentorController::class,'index'])->middleware(['auth:sanctum']);


Route::apiResource('/users', UserController::class)->only('store');

Route::apiResource('/auth', AuthController::class);