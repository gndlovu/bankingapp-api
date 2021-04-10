<?php

namespace App\Api\V1\Repositories\AccountRepository;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface IAccountRepository
 *
 * @package App\Api\V1\Repositories\IAccountRepository
 */
interface IAccountRepository
{
    /**
     * @param $user_id
     * @return Collection
     */
    public function findByUser($user_id): ?Collection;
}
