<?php

namespace App\Api\V1\Services\TwoFactorService;

use App\Models\User;

interface ITwoFactorService
{
    /**
     * @param string $secret
     * @param string $code
     *
     * @return boolean
     */
    public function verify(string $secret, string $code): bool;

    /**
     * @param User $user
     *
     * @return void
     */
    public function twoFactorUrl(User $user);

    /**
     * @return string
     */
    public function generateSecretKey(): string;
}
