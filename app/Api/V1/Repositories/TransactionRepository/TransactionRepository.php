<?php

namespace App\Api\V1\Repositories\TransactionRepository;

use App\Api\V1\Repositories\BaseRepository;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository extends BaseRepository implements ITransactionRepository
{
    /**
     * TransactionRepository constructor.
     *
     * @param Transaction $model
     */
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $account_id
     * @return Collection
     */
    public function findByAccount($account_id): ?Collection
    {
        return $this->model->where('account_id', $account_id)->get();
    }
}
