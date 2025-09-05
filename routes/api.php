<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;


Route::apiResource('tickets', TicketController::class);
Route::get('/categories', [TicketController::class, 'categories']);
Route::post('tickets/{id}/classify', [TicketController::class, 'classify']);
