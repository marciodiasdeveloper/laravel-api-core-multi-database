<?php

namespace App\Http\Controllers\Api\SignUp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Customer\Customer;

use App\Http\Requests\SignUp\CheckEmailRequest;

class CheckEmailExistsController extends Controller
{
    private $repository;

    public function __construct(Customer $model)
    {
        $this->repository = $model;
    }

    /**
     * @OA\Get(
     *      path="/signup/check-email",
     *      operationId="checkEmail",
     *      tags={"SignUp"},
     *      summary="Check e-mail available to register",
     *      description="Verify e-mail available",
     *      @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Check e-mail available",
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
    public function index(CheckEmailRequest $request)
    {
        if (!$request->has('email')) {
            return response()->json(['error' => 'not_found_email_params'], 404);
        }

        if ($this->repository->where('email', $request->get('email'))->first()) {
            return response()->json(['error' => 'email_exists'], 401);
        }

        return response()->json(['success' => true], 202);
    }
}
