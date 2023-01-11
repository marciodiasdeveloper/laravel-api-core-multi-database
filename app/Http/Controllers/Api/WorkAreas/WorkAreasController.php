<?php

namespace App\Http\Controllers\Api\WorkAreas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

use App\Http\Resources\WorkAreas\WorkAreaResource;
use App\Models\SignUp\WorkArea;

class WorkAreasController extends Controller
{

    public function __construct()
    {
    }

    /**
     * @OA\Get(
     *      path="/workareas",
     *      operationId="getSignUpWorkArea",
     *      tags={"WorkAreas"},
     *      summary="Get a list of available work areas to select in the register",
     *      description="List of workareas",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *     )
     *
     * Returns available domain
     */
    public function index()
    {
        $slug = 'signup-step2-work-areas';

        if (Cache::has($slug)) {
            return Cache::get($slug);
        }

        $work_areas = WorkArea::where('status', 'enabled')->orderBy('name', 'ASC')->get();

        $work_areas_resource = WorkAreaResource::collection($work_areas);

        Cache::put($slug, $work_areas_resource, 60);

        return $work_areas_resource;
    }
}
