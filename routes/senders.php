<?php

use Illuminate\Support\Facades\Route;
use Lanos\SendgridTenancy\Http\Controllers;

Route::prefix('email')->group(function () {
    Route::get('', [Controllers\EmailSenderController::class, 'getEmailSenders'])->name('api.settings.application.email.get');
    Route::post('', [Controllers\EmailSenderController::class, 'createEmailSender'])->name('api.settings.application.email.create');

    Route::prefix('{id}')->group(function () {
        Route::get('', [Controllers\EmailSenderController::class, 'checkEmailStatus'])->name('api.settings.application.email.status');
        Route::delete('', [Controllers\EmailSenderController::class, 'deleteEmail'])->name('api.settings.application.email.delete');
    });
});