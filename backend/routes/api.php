<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/auth/login", [AuthController::class, "login"]);
Route::middleware("auth:sanctum")->get("/auth/profile", [AuthController::class, "profile"]);
Route::middleware("auth:sanctum")->get("/ticket", [TicketController::class, "all"]);
Route::middleware("auth:sanctum")->post("/ticket/create", [TicketController::class, "create"]);
Route::middleware("auth:sanctum")->get("/ticket/{id}", [TicketController::class, "detail"]);
Route::middleware("auth:sanctum")->post("/ticket/reply/{id}", [TicketController::class, "reply"]);
