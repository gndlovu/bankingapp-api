<?php

namespace App\Api\V1\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Api\V1\Services\BankService\IBankService;
use App\Api\V1\Services\BankService\BankService;
use App\Api\V1\Transformers\TransactionTransformer;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;

class TransactionController extends Controller
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
     *      path="/bank/transactions/{account_id}/history",
     *      operationId="transactions",
     *      tags={"Transactions"},
     *      summary="Bank account transactions",
     *      security={
     *         {"bearerAuth": {}}
     *      },
     *      description="Returns bank account transaction list.",
     *      @OA\Response(response=200, description="Successful request"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     *
     * Bank Account transactions
     *
     * @return Response
     */
    public function history(int $id): Response
    {
        $transactionHistory = $this->bankService->getAccountTransactions($id);

        return $this->response->collection($transactionHistory, new TransactionTransformer);
    }

    /**
     *  @OA\Post(
     *      path="/bank/transactions/{account_id}/history",
     *      operationId="transaction",
     *      tags={"Transactions"},
     *      summary="Inititate transaction.",
     *      description="Inititate transaction.",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="amount",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="my_reference",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="type",
     *                      type="string"
     *                  ),
     *                  example={"amount": "1000", "my_reference": "My First Deposit", "type": "deposit" }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="Successful request"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=500, description="Internal server error")
     * )
     *
     * Initiate transaction
     *
     * @param Request $request
     *
     * @return Response
     */
    public function create(int $account_id, Request $request)
    {
        $transaction = $this->bankService->createTransaction($account_id, $request->all());

        return $this->response->item($transaction, new TransactionTransformer);
    }
}
