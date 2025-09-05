<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/{any}', function () {
    return file_get_contents(public_path('index.html'));
})->where('any', '.*');

Route::middleware(['web'])->group(function () {
    Route::apiResource('tickets', TicketController::class);
    Route::post('tickets/{id}/classify', TicketController::class, 'classify');
});
