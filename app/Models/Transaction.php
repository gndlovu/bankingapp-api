<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'transaction_type_id',
        'account_id',
        'to_account_id',
        'reference',
        'amount'
    ];

    /**
     * Disable Eloquent created_at and updated_at columns.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Gets user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Gets transaction type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    /**
     * Gets transaction initiator account
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Gets reciever account
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toAccount()
    {
        return $this->belongsTo(Account::class);
    }
}
