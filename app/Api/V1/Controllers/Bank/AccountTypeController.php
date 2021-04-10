<?php

namespace App\Api\V1\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Api\V1\Services\BankService\IBankService;
use App\Api\V1\Services\BankService\BankService;
use App\Api\V1\Transformers\AccountTypeTransformer;
use Dingo\Api\Http\Response;

class AccountTypeController extends Controller
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
     *      path="/bank/accounts/types/list",
     *      operationId="accountTypes",
     *      tags={"Account Types"},
     *      summary="Bank branches",
     *      security={
     *         {"bearerAuth": {}}
     *      },
     *      description="Returns bank account type list.",
     *      @OA\Response(response=200, description="Successful request"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     *
     * Bank Account types
     *
     * @return Response
     */
    public function index(): Response
    {
        $accountTypes = $this->bankService->getAccountTypes();

        return $this->response->collection($accountTypes, new AccountTypeTransformer);
    }
}
