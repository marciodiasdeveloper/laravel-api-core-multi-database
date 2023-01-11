<?php

namespace App\Http\Controllers\Api\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

use App\Http\Resources\Jobs\JobResource;
use App\Models\SignUp\Job;

class JobsController extends Controller
{

    public function __construct()
    {
    }

    /**
     * @OA\Get(
     *      path="/jobs",
     *      operationId="getJobs",
     *      tags={"Jobs"},
     *      summary="Get a list of available jobs to select in the register",
     *      description="List of jobs",
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
        $slug = 'signup-step1-jobs';

        if (Cache::has($slug)) {
            return Cache::get($slug);
        }

        $jobs = Job::where('status', 'enabled')->orderBy('name', 'ASC')->get();

        $jobs_resource = JobResource::collection($jobs);

        Cache::put($slug, $jobs_resource, 60);

        return $jobs_resource;
    }
}
