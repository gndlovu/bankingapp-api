<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given account can be accessed by the user.
     *
     * @param  User  $user
     * @param  Account  $account
     * @return bool
     */
    public function access(User $user, Account $account)
    {
        if ($user->id === $account->user->id) {
            return true;
        } else {
            return false;
        }
    }
}
