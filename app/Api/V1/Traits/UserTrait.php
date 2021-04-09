<?php

namespace App\Api\V1\Traits;

use App\Models\User;

/**
 * Trait UserTrait
 * @package App\Api\V1\Traits
 */
trait UserTrait
{
    /**
     * Send user verification email
     *
     * @param User $user
     * 
     * @return void
     */
    public function sendVerifyMail($user)
    {
        $user->sendEmailVerificationNotification();
    }
}
