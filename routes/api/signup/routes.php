<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\SignUp\SignUpController;
use App\Http\Controllers\Api\SignUp\CheckEmailExistsController;

// use App\Jobs\Customer\SignUp\SendmailJob;

Route::prefix('signup')->group(function () {
    Route::get('check-email', [CheckEmailExistsController::class, 'index']);
    Route::post('', [SignUpController::class, 'store']);
    // Route::get('send-mail', function () {
    //     SendmailJob::dispatch('eu@marciodias.me')->onConnection('database')->onQueue('queue_mail');
    //     return response()->json('email dispatched');
    // });
});
