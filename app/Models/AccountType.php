<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
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
     * Get accounts
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
