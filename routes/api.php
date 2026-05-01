<?php

use Rapidez\OrderReminder\Http\Controllers\OrderReminderController;
use Rapidez\OrderReminder\Http\Middleware\OrderReminderAuthMiddleware;

Route::middleware('api')->prefix('api')->group(function () {
    Route::get('order-reminders', [OrderReminderController::class, 'index'])->middleware('auth:magento-customer');
    Route::middleware(OrderReminderAuthMiddleware::class)->group(function () {
        Route::post('order-reminders', [OrderReminderController::class, 'store']);
        Route::put('order-reminders/{orderReminder}', [OrderReminderController::class, 'update']);
    });
    Route::delete('order-reminders/{orderReminder}', [OrderReminderController::class, 'destroy']);
});
