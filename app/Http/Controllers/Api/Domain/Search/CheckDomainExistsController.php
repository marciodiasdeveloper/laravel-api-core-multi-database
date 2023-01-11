<?php

namespace App\Http\Controllers\Api\Domain\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

use App\Models\Tenant\Domain;

class CheckDomainExistsController extends Controller
{
    private $model;

    public function __construct(Domain $model)
    {
        $this->model = $model;
    }

   /**
     * @OA\Get(
     *      path="/domain/search",
     *      operationId="searchDomain",
     *      tags={"Domain"},
     *      summary="Checks if the subdomain is available for registration",
     *      description="Check available subdomain to subdomain.planeasy.com.br",
     *      @OA\Parameter(
     *         name="domain",
     *         in="query",
     *         description="Field Subdomain for planeasy.com.br",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *     )
     *
     * Returns available domain
     */
    public function index(Request $request)
    {
        if (!$request->get('domain')) {
            return response()->json(['error' => 'not_found_domain_params'], 404);
        }

        $slug = 'api-core-domains-search-' . $request->get('domain');

        if (Cache::has($slug)) {
            return Cache::get($slug);
        }

        if ($domain = $this->model->where('domain', $request->get('domain'))->first()) {
            $result = ['success' => true, 'message' => 'domain_exists', 'uuid' => $domain->uuid];
        } else {
            $result = ['success' => true, 'message' => 'domain_not_found'];
        }

        Cache::put($slug, $result, 5);

        return $result;
    }
}
