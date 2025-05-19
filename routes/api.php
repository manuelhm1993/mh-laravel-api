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

Route::post('/clients/{client}/services', [ClientController::class, 'attach'])->name('clients.services.attach');