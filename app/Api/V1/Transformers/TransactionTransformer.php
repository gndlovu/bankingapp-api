<?php

namespace App\Api\V1\Transformers;

use App\Models\Transaction;
use League\Fractal\TransformerAbstract;
use App\Api\V1\Transformers\AccountTransformer;
use App\Api\V1\Transformers\BranchTransformer;

/**
 * Class TransactionTransformer
 *
 * @package App\Api\V1\Transformers
 */
class TransactionTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @var array
     */
    protected $defaultIncludes = ['account', 'to_account'];

    /**
     * @param User $user
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'id'                => $transaction->id,
            'reference'         => $transaction->reference,
            'amount'            => $transaction->amount,
            'created_at'        => $transaction->created_at,
            'type'              => $transaction->transactionType->name, // TODO - Move this to it's own transformer
        ];

        return [];
    }

    /**
     * @param Transaction $transaction
     * @return \League\Fractal\Resource\Item
     */
    public function includeAccount(Transaction $transaction)
    {
        return $this->item($transaction->account, new AccountTransformer);
    }

    /**
     * @param Transaction $transaction
     * @return \League\Fractal\Resource\Item
     */
    public function includeToAccount(Transaction $transaction)
    {
        // To account is null on transfer transactions
        if (!$transaction->toAccount) {
            return;
        }

        return $this->item($transaction->toAccount, new AccountTransformer);
    }
}
