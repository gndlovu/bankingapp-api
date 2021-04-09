<?php

namespace App\Api\V1\Repositories\UserRepository;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface UserRepository
 *
 * @package App\Api\V1\Repositories\UserRepository
 */
interface IUserRepository
{
    /**
     * @param $email
     * @return Model|null
     */
    public function findByEmail($email): ?Model;
}
