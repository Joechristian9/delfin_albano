<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopFiveSelectionScoreController;

Route::middleware('auth:sanctum')
    ->post('/production_number/scores', [TopFiveSelectionScoreController::class, 'production_number_store'])
    ->name('production_number.store');
