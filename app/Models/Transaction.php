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
        'to_branch_id',
        'account_holder',
        'account_no',
        'my_reference',
        'thier_reference',
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
    public function type()
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

    /**
     * Gets reciever branch
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toBranch()
    {
        return $this->belongsTo(Branch::class);
    }
}
