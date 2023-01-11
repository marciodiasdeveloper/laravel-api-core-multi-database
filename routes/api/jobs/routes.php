<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Jobs\JobsController;

Route::prefix('signup')->group(function () {
    Route::get('', [JobsController::class, 'index']);
});
