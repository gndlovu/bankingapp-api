<?php

namespace App\Api\V1\Services\AuthService;

interface IAuthService
{
    /**
     * @param array $attributes
     * @return void
     */
    public function register(array $attributes);

    /**
     * @param int $id
     * @return void
     */
    public function verify(int $id);

    /**
     * @param string $email
     * @return void
     */
    public function resend(string $email);

    /**
     * @param array $attributes
     * @return void
     */
    public function login(array $attributes);

    /**
     * @param array $attributes
     * @return void
     */
    public function twoFactorLogin(array $attributes);

    /**
     * @param aaray $email
     * @return void
     */
    public function sendResetLink(array $email);

    /**
     * @param array $attributes
     * @return void
     */
    public function resetPassword(array $attributes);
}
