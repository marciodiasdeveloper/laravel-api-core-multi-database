<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Microservice - api-core",
 *     version="0.1",
 *      @OA\Contact(
 *          email="planeasy@marciodias.me"
 *      ),
 * ),
 *  @OA\Server(
 *      description="developer environment",
 *      url="https://localhost:8000/"
 *  ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
