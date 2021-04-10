<?php

namespace App\Api\V1\Repositories\BranchRepository;

use App\Api\V1\Repositories\BaseRepository;
use App\Models\Branch;

class BranchRepository extends BaseRepository implements IBranchRepository
{
    /**
     * BranchRepository constructor.
     *
     * @param Branch $model
     */
    public function __construct(Branch $model)
    {
        parent::__construct($model);
    }
}
