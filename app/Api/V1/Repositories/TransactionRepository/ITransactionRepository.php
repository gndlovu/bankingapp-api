<?php

namespace App\Api\V1\Repositories\TransactionRepository;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ITransactionRepository
 *
 * @package App\Api\V1\Repositories\ITransactionRepository
 */
interface ITransactionRepository
{
    /**
     * @param int $account_id
     * @return Collection
     */
    public function findByAccount($account_id): ?Collection;
}
