<?php

namespace App\Api\V1\Transformers;

use App\Models\Account;
use League\Fractal\TransformerAbstract;
use App\Api\V1\Transformers\AccountTypeTransformer;
use App\Api\V1\Transformers\BranchTransformer;

/**
 * Class AccountTransformer
 * @package App\Api\V1\Transformers
 */
class AccountTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = ['type', 'branch'];

    /**
     * @param Account $account
     * @return array
     */
    public function transform(Account $account)
    {
        return [
            'id' => (int)$account->id,
            'account_no' => $account->account_no,
            'balance' => $account->balance,
            'overdraft' => $account->overdraft,
            'created_at' => $account->created_at,
            'updated_at' => $account->updated_at,
        ];
    }

    /**
     * @param Account $account
     * @return \League\Fractal\Resource\Item
     */
    public function includeType(Account $account)
    {
        return $this->item($account->type, new AccountTypeTransformer);
    }

    /**
     * @param Account $account
     * @return \League\Fractal\Resource\Item
     */
    public function includeBranch(Account $account)
    {
        return $this->item($account->branch, new BranchTransformer);
    }
}
