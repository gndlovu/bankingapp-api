<?php

namespace App\Api\V1\Services\TwoFactorService;

use App\Api\V1\Services\TwoFactorService\ITwoFactorService;
use App\Models\User;
use Google2FA;

class TwoFactorService implements ITwoFactorService
{
    /**
     * Register user
     *
     * @param string $secret
     * @param string $code
     *
     * @return bool
     */
    public function verify(string $secret, string $code): bool
    {
        return Google2FA::verifyKey($secret, $code);
    }

    /**
     * Gets Google2FA QR code URL
     *
     * @param User $user
     *
     * @return void
     */
    public function twoFactorUrl(User $user)
    {
        return Google2FA::getQRCodeInline(
            'bankingapp.gladwelln.dev',
            $user->email,
            $user->google2fa_secret
        );
    }

    /**
     * Gets Google2FA secret key
     *
     * @return string
     */
    public function generateSecretKey(): string
    {
        return Google2FA::generateSecretKey();
    }
}
