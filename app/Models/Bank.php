<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id', 'name'];

    /**
     * Disable Eloquent created_at and updated_at columns.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get bank branches
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
