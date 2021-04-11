<?php

namespace App\Api\V1\Repositories\TransactionTypeRepository;

use App\Api\V1\Repositories\BaseRepository;
use App\Models\TransactionType;

class TransactionTypeRepository extends BaseRepository implements ITransactionTypeRepository
{
    /**
     * TransactionTypeRepository constructor.
     *
     * @param TransactionType $model
     */
    public function __construct(TransactionType $model)
    {
        parent::__construct($model);
    }


    /**
     * @param string $name
     * @return TransactionType|null
     */
    public function findByName($name): ?TransactionType
    {
        return $this->model->whereRaw('LOWER(`name`) = ? ', $name)->first();
    }
}
