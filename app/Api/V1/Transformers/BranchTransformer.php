<?php

namespace App\Api\V1\Transformers;

use App\Models\Branch;
use League\Fractal\TransformerAbstract;

/**
 * Class BranchTransformer
 * @package App\Api\V1\Transformers
 */
class BranchTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @param Branch $branch
     * @return array
     */
    public function transform(Branch $branch)
    {
        return [
            'id'   => $branch->id,
            'bank' => $branch->bank->name,
            'name' => $branch->name,
            'code' => $branch->code,
        ];
    }
}
