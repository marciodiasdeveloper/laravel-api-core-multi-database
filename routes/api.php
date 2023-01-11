<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'success']);
});

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

require_once base_path('routes/api/domain/routes.php');
require_once base_path('routes/api/signup/routes.php');
require_once base_path('routes/api/questions/routes.php');
require_once base_path('routes/api/jobs/routes.php');
require_once base_path('routes/api/workareas/routes.php');
