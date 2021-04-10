<?php

namespace App\Api\V1\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Api\V1\Services\BankService\IBankService;
use App\Api\V1\Services\BankService\BankService;
use App\Api\V1\Transformers\BranchTransformer;
use Dingo\Api\Http\Response;

class BranchController extends Controller
{
    /**
     * @var BankService
     */
    private $bankService;

    /**
     * AuthController constructor
     *
     * @param IBankService $bankService
     */
    public function __construct(IBankService $bankService)
    {
        $this->bankService = $bankService;
    }

    /**
     *  @OA\Get(
     *      path="/bank/branches/list",
     *      operationId="bankBranches",
     *      tags={"Branhes"},
     *      summary="Bank branches",
     *      security={
     *         {"bearerAuth": {}}
     *      },
     *      description="Returns bank branche list.",
     *      @OA\Response(response=200, description="Successful request"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     *
     * Bank branches
     *
     * @return Response
     */
    public function index(): Response
    {
        $branches = $this->bankService->getBranches();

        return $this->response->collection($branches, new BranchTransformer);
    }
}
