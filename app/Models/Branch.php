<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id', 'bank_id', 'name', 'code'];

    /**
     * Disable Eloquent created_at and updated_at columns.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Gets branch bank
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * Get branch accounts
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
