<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResources([
    'clients'  => ClientController::class,
    'services' => ServiceController::class,
]);

Route::controller(ClientController::class)->prefix('clients')->name('clients.')->group(function () {
    Route::post('/services', 'attach')->name('services.attach');
    Route::delete('{client}/services', 'detach')->name('services.detach');
});