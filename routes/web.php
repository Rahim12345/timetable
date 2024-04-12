<?php

use App\Http\Controllers\TimetableController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TimetableController::class, 'index']);

Route::resource('/calendar', TimetableController::class)
    ->only(['store','update','destroy']);
