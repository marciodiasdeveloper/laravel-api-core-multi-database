<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::prefix('tenants')->group(function () {
//     Route::get('', [\App\Http\Controllers\Api\Tenant\TenantController::class, 'index']);
//     Route::post('', [\App\Http\Controllers\Api\Tenant\TenantController::class, 'store']);
//     Route::get('{uuid}', [\App\Http\Controllers\Api\Tenant\TenantController::class, 'show']);
//     Route::put('{uuid}', [\App\Http\Controllers\Api\Tenant\TenantController::class, 'update']);
//     Route::delete('{uuid}', [\App\Http\Controllers\Api\Tenant\TenantController::class, 'destroy']);
// });
