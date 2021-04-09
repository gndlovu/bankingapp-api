<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
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
     * Get users assigned this role
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
