<?php

namespace App\Api\V1\Repositories\UserRepository;

use App\Api\V1\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserRepository extends BaseRepository implements IUserRepository
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail($email): ?Model
    {
        return $this->model->where('email', $email)->first();
    }
}
