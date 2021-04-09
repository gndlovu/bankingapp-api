<?php

namespace App\Api\V1\Transformers;

use App\Models\Role;
use League\Fractal\TransformerAbstract;

/**
 * Class RoleTransformer
 * @package App\Api\V1\Transformers
 */
class RoleTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'users',
    ];

    /**
     * @param Role $role
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'name' => $role->name
        ];
    }
}
