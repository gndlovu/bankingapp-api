<?php

namespace App\Api\V1\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface IBaseRepository
 *
 * @package App\Api\V1\Repositories
 */
interface IBaseRepository
{
    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param array $attributes
     * @param array $values
     * @return Model
     */
    public function updateOrCreate(array $attributes, array $values): Model;

    /**
     * @param $id
     * @return Model|null
     */
    public function find($id): ?Model;
}
