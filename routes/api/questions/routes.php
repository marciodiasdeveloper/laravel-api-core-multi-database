<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Questions\QuestionsController;

Route::prefix('questions')->group(function () {
    Route::get('', [QuestionsController::class, 'index']);
});
