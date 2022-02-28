<?php

use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('events', [EventController::class, 'getEvents']);
Route::get('events/export', [EventController::class, 'exportEvents'])->name('api.events.export');