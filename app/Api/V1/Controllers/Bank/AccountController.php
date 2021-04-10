<?php

namespace App\Api\V1\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Api\V1\Services\BankService\IBankService;
use App\Api\V1\Services\BankService\BankService;
use App\Api\V1\Transformers\AccountTransformer;
use App\Api\V1\Requests\Bank\Account\AddAccount;
use App\Api\V1\Requests\Bank\Account\EditAccount;
use Dingo\Api\Http\Response;

class AccountController extends Controller
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
     *      path="/bank/accounts/list",
     *      operationId="bankAccount",
     *      tags={"Accounts"},
     *      summary="User bank accounts",
     *      security={
     *         {"bearerAuth": {}}
     *      },
     *      description="Returns bank account list.",
     *      @OA\Response(response=200, description="Successful request"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     *
     * Bank accounts
     *
     * @return Response
     */
    public function index(): Response
    {
        $accounts = $this->bankService->getAccounts();

        return $this->response->collection($accounts, new AccountTransformer);
    }

    /**
     *  @OA\Post(
     *      path="/bank/accounts/add",
     *      operationId="addAccount",
     *      tags={"Accounts"},
     *      summary="New bank account.",
     *      description="Creates new bank account.",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="account_type_id",
     *                      type="number"
     *                  ),
     *                  @OA\Property(
     *                      property="branch_id",
     *                      type="number"
     *                  ),
     *                  @OA\Property(
     *                      property="account_no",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="overdraft",
     *                      type="number"
     *                  ),
     *                  example={"account_type_id": 1,"branch_id": 1, "account_no": "83736453676", "overdraft": 5000 }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=201, description="Created"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=422, description="Unprocessable Entity"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=500, description="Internal server error")
     *  )
     *
     *  New bank account
     *
     *  @param AddAccount $request
     *
     *  @return Response
     */

    public function add(AddAccount $request): Response
    {
        $this->bankService->createAccount($request->only('account_type_id', 'branch_id', 'account_no', 'overdraft'));

        return $this->response->noContent();
    }

    /**
     *  @OA\Put(
     *      path="/bank/accounts/edit",
     *      operationId="editAccount",
     *      tags={"Accounts"},
     *      summary="Bank account update.",
     *      description="Updates bank account.",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="id",
     *                      type="number"
     *                  ),
     *                  @OA\Property(
     *                      property="overdraft",
     *                      type="number"
     *                  ),
     *                  example={"id": 1, "overdraft": 5000 }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=201, description="Updated"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=422, description="Unprocessable Entity"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=500, description="Internal server error")
     *  )
     *
     *  Update bank account
     *
     *  @param EditAccount $request
     *
     *  @return Response
     */

    public function edit(EditAccount $request): Response
    {
        $this->bankService->updateAccount($request->only('id', 'overdraft'));

        return $this->response->noContent();
    }
}
