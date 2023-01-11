<?php

namespace App\Http\Controllers\Api\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\TenantRequest;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\DB;

use App\Models\Tenant\Tenant;

use App\Services\Tenant\TenantService;

use App\Http\Resources\Tenant\TenantResource;

class TenantController extends Controller
{
    private $repository;

    public function __construct(Tenant $model)
    {
        $this->repository = $model;
    }

    public function index(Request $request)
    {

        $items_per_page = $request->get('items_per_page', 100);

        $tenants = $this->repository->paginate($items_per_page);

        return TenantResource::collection($tenants);
    }

    public function store(TenantRequest $request)
    {

        $data = $request->validated();

        DB::beginTransaction();

        try {
            if (!$tenant = app(TenantService::class)->save($data)) {
                DB::rollback();
                return response()->json(['error' => 'tenant_create_failed'], 500);
            }
        } catch (ValidationException $e) {
            DB::rollback();
            return response()->json(['error' => $e], 500);
        }

        DB::commit();

        return new TenantResource($tenant);
    }

    public function show($uuid)
    {
        if (!$tenant = $this->repository->where('uuid', $uuid)->first())
            return response()->json(['error' => 'tenant_not_found'], 404);

        return new TenantResource($tenant);
    }

    public function update(TenantRequest $request, $uuid)
    {
        if (!$tenant = $this->repository->where('uuid', $uuid)->first())
            return response()->json(['error' => 'tenant_not_found'], 404);

        $data = $request->validated();

        DB::beginTransaction();

        try {
            $tenant_service = new TenantService();

            if (!$tenant = $tenant_service->save($data)) {
                DB::rollback();
                return response()->json(['error' => 'tenant_create_failed'], 500);
            }
        } catch (ValidationException $e) {
            DB::rollback();
            return response()->json(['error' => $e], 500);
        }

        DB::commit();

        return new TenantResource($tenant);
    }

    public function destroy($uuid)
    {
        if (!$tenant = $this->repository->where('uuid', $uuid)->first())
            return response()->json(['error' => 'tenant_not_found'], 404);

        if ($tenant->delete())
            return response()->json(['error' => 'not_delete'], 500);

        return response()->json([], 204);
    }
}
