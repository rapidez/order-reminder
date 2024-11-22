<?php

use Rapidez\OrderReminder\Http\Controllers\OrderReminderController;

Route::middleware('web')->group(function () {
    Route::view('account/order-reminders', 'rapidez-order-reminder::account.order-reminders')->name('rapidez-order-reminder.account.index');
    Route::controller(OrderReminderController::class)->group(function () {
        Route::get('order_reminders/confirm/{orderReminder}', 'confirm')->name('rapidez-order-reminder.confirm')->middleware('signed');
        Route::get('order_reminders/unsubscribe/{orderReminder}', 'unsubscribe')->name('rapidez-order-reminder.unsubscribe')->middleware('signed');
    });
});
