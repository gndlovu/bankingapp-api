<?php

namespace App\Api\V1\Transformers;

use App\Models\AccountType;
use League\Fractal\TransformerAbstract;

/**
 * Class AccountTypeTransformer
 * @package App\Api\V1\Transformers
 */
class AccountTypeTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @param AccountType $accountType
     * @return array
     */
    public function transform(AccountType $accountType)
    {
        return [
            'id' => (int)$accountType->id,
            'name' => $accountType->name,
        ];
    }
}
