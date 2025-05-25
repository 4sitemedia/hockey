<?php

use App\Http\Controllers\GenerateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/teams', [TeamController::class, 'index'])->name('teams');
Route::post('/teams/{team}/generate', [GenerateController::class, 'index']);
Route::post('/teams/{team}/schedule', [TeamController::class, 'games']);
Route::get('/schedule/{date?}', [ScheduleController::class, 'index'])->name('schedule');
