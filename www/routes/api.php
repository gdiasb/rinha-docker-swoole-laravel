<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;




Route::get('clientes', [ClienteController::class, 'index']);
Route::get('clientes/{id}', [ClienteController::class, 'show']);


