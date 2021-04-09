<?php

namespace App\Api\V1\Services\AuthService;

use App\Api\V1\Repositories\UserRepository\UserRepository;
use App\Api\V1\Repositories\UserRepository\IUserRepository;
use App\Api\V1\Services\TwoFactorService\TwoFactorService;
use App\Api\V1\Services\TwoFactorService\ITwoFactorService;
use App\Api\V1\Traits\UserTrait;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use JWTAuth;

class AuthService implements IAuthService
{
    use UserTrait;

    /**
     * @var UserRepository
     */
    private $userRepo;

    /**
     * @var TwoFactorService
     */
    private $twoFactorService;

    /**
     * AuthService constructor
     *
     * @param IUserRepository $userRepository
     * @param ITwoFactorService $twoFactorService
     */
    public function __construct(IUserRepository $userRepository, ITwoFactorService $twoFactorService)
    {
        $this->userRepo = $userRepository;
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Register user
     *
     * @param array $data
     *
     * @return void
     */
    public function register($data)
    {
        data_fill($data, 'google2fa_secret', $this->twoFactorService->generateSecretKey());
        $user = $this->userRepo->create($data);

        $this->sendVerifyMail($user);
    }

    /**
     * User email verification
     *
     * @param int $id
     *
     * @return void
     */
    public function verify(int $id)
    {
        $user = $this->userRepo->find($id);
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
    }

    /**
     * Send user verification email
     *
     * @param string $email
     * @return void
     */
    public function resend(string $email)
    {
        $user = $this->userRepo->findByEmail($email);
        if ($user->hasVerifiedEmail()) {
            abort(400, 'Email already verified.');
        }

        $this->sendVerifyMail($user);
    }

    /**
     * User login
     *
     * @param array $data
     * @return array
     */
    public function login($data): array
    {
        $user = $this->userRepo->findByEmail($data['email']);

        abort_unless($user->hasVerifiedEmail(), 400, 'Email not verified.');

        $token = auth()->attempt($data);

        abort_unless($token, 401, 'Unauthorized');

        abort_if($user->google2fa_enable, 301, $user->email);

        return $this->createToken($token);
    }

    /**
     * Verify Google2FA code and login.
     *
     * @param array $data
     * @return array
     */
    public function twoFactorLogin($data): array
    {
        $user = $this->userRepo->findByEmail($data['email']);

        abort_unless($user, 401, 'Unauthorized');
        abort_unless($this->twoFactorService->verify($user->google2fa_secret, $data['code']), 401, 'Unauthorized');

        $token = JWTAuth::fromUser($user);

        return $this->createToken($token);
    }

    /**
     * Refresh authentication token
     *
     * @return array
     */
    public function refresh(): array
    {
        return $this->createToken(auth()->refresh());
    }

    /**
     * User profile
     *
     * @return User
     */
    public function profile()
    {
        return auth()->user();
    }

    /**
     * Invalidate authentication token
     *
     * @return void
     */
    public function logout()
    {
        auth()->logout();
    }

    /**
     * Create and return auth data
     *
     * @param string $token
     * @return array
     */
    private function createToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    /**
     * Send password reset link
     *
     * @param array $email
     * @return void
     */
    public function sendResetLink(array $email)
    {
        $status = Password::sendResetLink($email);

        abort_unless($status === Password::RESET_LINK_SENT, 400, 'Could not send password reset link.');
    }

    /**
     * Reset user password
     *
     * @param array $data
     * @return void
     */
    public function resetPassword(array $data): void
    {
        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user->forceFill(['password' => $password])->save();
                $user->setRememberToken(Str::random(60));

                event(new PasswordReset($user));
            }
        );

        abort_unless($status === Password::PASSWORD_RESET, 400, 'Could not reset password.');
    }
}
