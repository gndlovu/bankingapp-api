<?php

namespace App\Api\V1\Repositories\AccountRepository;

use App\Api\V1\Repositories\BaseRepository;
use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

class AccountRepository extends BaseRepository implements IAccountRepository
{
    /**
     * AccountRepository constructor.
     *
     * @param Account $model
     */
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @return Collection|null
     */
    public function findByUser($id): ?Collection
    {
        return $this->model->where('user_id', $id)->get();
    }
}
