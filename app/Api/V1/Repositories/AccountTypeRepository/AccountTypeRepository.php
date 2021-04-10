<?php

namespace App\Api\V1\Repositories\AccountTypeRepository;

use App\Api\V1\Repositories\BaseRepository;
use App\Models\AccountType;

class AccountTypeRepository extends BaseRepository implements IAccountTypeRepository
{
    /**
     * AccountTypeRepository constructor.
     *
     * @param AccountType $model
     */
    public function __construct(AccountType $model)
    {
        parent::__construct($model);
    }
}
