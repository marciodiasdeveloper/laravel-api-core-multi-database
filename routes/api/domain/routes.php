<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Domain\Search\CheckDomainExistsController;

Route::prefix('domain')->group(function () {
    Route::get('search', [CheckDomainExistsController::class, 'index']);
});
