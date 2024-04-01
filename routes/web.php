<?php

use App\Http\Controllers\TimetableController;
use Illuminate\Support\Facades\Route;

Route::resource('/calendar', TimetableController::class);
