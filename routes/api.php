<?php

use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;


Route::get('/analyze/{username}', [AnalyticsController::class, 'analyze']);
Route::get('/contributions/{username}', [AnalyticsController::class, 'contributions']);