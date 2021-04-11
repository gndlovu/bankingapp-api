<?php

namespace App\Api\V1\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer
 *
 * @package App\Api\V1\Transformers
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @var array
     */
    protected $defaultIncludes = ['role'];

    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'object_type'       => "User",
            'id'                => (int) $user->id,
            'name'              => $user->name,
            'email'             => $user->email,
            'total_accounts'    => $user->accounts->count()
        ];

        return [];
    }

    /**
     * @param User $user
     * @return \League\Fractal\Resource\Item
     */
    public function includeRole(User $user)
    {
        return $this->item($user->role, new RoleTransformer);
    }
}
