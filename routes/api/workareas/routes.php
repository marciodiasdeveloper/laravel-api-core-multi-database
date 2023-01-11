<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\WorkAreas\WorkAreaController;

Route::prefix('workareas')->group(function () {
    Route::get('', [WorkAreaController::class, 'index']);
});
