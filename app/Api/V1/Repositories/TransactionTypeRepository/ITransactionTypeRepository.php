<?php

namespace App\Api\V1\Repositories\TransactionTypeRepository;

use App\Models\TransactionType;

/**
 * Interface ITransactionTypeRepository
 *
 * @package App\Api\V1\Repositories\ITransactionTypeRepository
 */
interface ITransactionTypeRepository
{
    /**
     * @param string $name
     * @return TransactionType
     */
    public function findByName($name): ?TransactionType;
}
