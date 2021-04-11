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
    protected $defaultIncludes = ['account', 'branch'];

    /**
     * @param User $user
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'id'                => $transaction->id,
            'account_holder'    => $transaction->account_holder,
            'account_no'        => $transaction->account_no,
            'my_reference'      => $transaction->my_reference,
            'thier_reference'   => $transaction->thier_reference,
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
    public function includeBranch(Transaction $transaction)
    {
        // Branch is null on transfer transactions
        if (!$transaction->toBranch) {
            return;
        }

        return $this->item($transaction->toBranch, new BranchTransformer);
    }
}
