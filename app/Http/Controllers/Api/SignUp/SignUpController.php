<?php

namespace App\Http\Controllers\Api\SignUp;

// use Illuminate\Http\Request;
// use App\Models\Tenant\Tenant;

use App\Http\Controllers\Controller;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Services\Catalog\CatalogService;
use App\Services\Customer\CustomerService;
use App\Services\Tenant\TenantService;

use App\Events\Customer\SignUpEvent;

use App\Http\Requests\SignUp\SignUpRequest;

// use App\Http\Resources\Tenant\TenantResource;

class SignUpController extends Controller
{
    private $catalogService;
    private $customerService;
    private $tenantService;

    public function __construct(
        CatalogService $catalogService,
        CustomerService $customerService,
        TenantService $tenantService
    ) {
        $this->catalogService = $catalogService;
        $this->customerService = $customerService;
        $this->tenantService = $tenantService;
    }

    /**
     * @OA\Post(
     *      path="/signup/",
     *      tags={"SignUp"},
     *      summary="Check e-mail available",
     *      description="Verify e-mail available",
     *      @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="E-mail",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="E-mail",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="Phone mobile",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="job",
     *         in="query",
     *         description="Job UUID",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="company_name",
     *         in="query",
     *         description="Name of company",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="company_phone_mobile",
     *         in="query",
     *         description="Phone of company",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="company_occupation_area",
     *         in="query",
     *         description="Company Occupation Area",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="company_employees_number",
     *         in="query",
     *         description="Company Employees",
     *         @OA\Schema(
     *             type="number"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="domain",
     *         in="query",
     *         description="Company Employees",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="questions",
     *         in="query",
     *         description="Company Employees",
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
    public function store(SignUpRequest $request)
    {

        $data = $request->validated();

        $dto = $this->mountTransformer($data);

        DB::beginTransaction();

        try {
            if ($this->customerService->checkEmailExists($dto['email'])) {
                DB::rollback();
                return response()->json(['error' => 'customer_email_exists'], 500);
            }

            if (!$catalog = $this->catalogService->save($dto)) {
                DB::rollback();
                return response()->json(['error' => 'catalog_created_failed'], 500);
            }

            if (!$customer = $this->customerService->save($catalog, $dto)) {
                DB::rollback();
                return response()->json(['error' => 'customer_created_failed'], 500);
            }

            if (!$this->tenantService->save($customer, $dto)) {
                DB::rollback();
                return response()->json(['error' => 'tenant_create_failed'], 500);
            }
        } catch (ValidationException $e) {
            DB::rollback();
            return response()->json(['error' => $e, 'message' => $e->getMessage()], 500);
        }

        DB::commit();

        // event(new SignUpEvent($customer));

        return response()->json($catalog);
        // return new TenantResource($tenant);
    }

    public function mountTransformer($data)
    {
        $data = [
            'email' => $data['step1']['personal']['user']['email'],
            'name' => $data['step1']['personal']['catalog']['name'],
            'phone' => [
                'phone_type' => 'personal',
                'phone_number' => $data['step1']['personal']['catalog']['phone'],
            ],
            'password' => $data['step1']['personal']['user']['password'],
            'job' => $data['step1']['personal']['job'],
            'company_name' => $data['step2']['company']['name'],
            'branch_name' => '',
            'phone' => $data['step2']['company']['occupation_area'],
            'occupation_area' => $data['step2']['company']['occupation_area'],
            'employees_number' => $data['step2']['company']['employees_number'],
            'type' => 'trial',
            'trial_ends_at' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s'),
            'ends_at' => null
        ];

        return $data;
    }
}
