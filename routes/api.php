<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Components\NotificationController;
use App\Http\Controllers\Components\ProfileController;

// работаем с записями профиля
Route::prefix('profiles')->group(function () {
    Route::get ('/', [ProfileController::class, 'index']);                   // получить все профили    
    Route::post('/add', [ProfileController::class, 'addProfile']);           // добавить профиль
    Route::get ('/{profile_id}', [ProfileController::class, 'getProfile']);  // получить профиль по id
    Route::put ('/edit', [ProfileController::class, 'editProfile']);         // редактировать профиль
});

// работаем с уведомлениями
Route::prefix('notification')->group(function () {
    Route::post('/get-code', [NotificationController::class, 'getCode']);      // запрос кода подтверждения
    Route::post('/check-code', [NotificationController::class, 'checkCode']);  // проверка кода подтверждения
});
