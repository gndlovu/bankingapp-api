<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
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
     * Get transactions
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
