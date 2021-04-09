<?php

namespace App\Api\V1\Controllers\Auth;

use App\Api\V1\Requests\Auth\EmailVerification;
use App\Api\V1\Requests\Auth\ForgotPassword;
use App\Api\V1\Requests\Auth\ResetPassword;
use App\Api\V1\Requests\Auth\TwoFactorLogin;
use App\Api\V1\Requests\Auth\UserLogin;
use App\Api\V1\Requests\Auth\UserRegister;
use App\Api\V1\Services\AuthService\IAuthService;
use App\Api\V1\Services\AuthService\AuthService;
use App\Api\V1\Transformers\UserTransformer;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * AuthController constructor
     *
     * @param IAuthService $authService
     */
    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     *  @OA\Post(
     *      path="/auth/register",
     *      operationId="register",
     *      tags={"Authentication"},
     *      summary="User registration.",
     *      description="Creates new users.",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="email"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="password_confirmation",
     *                      type="string"
     *                  ),
     *                  example={"name": "Gladwell Ndlovu","email": "gladwell_n@live.com", "password": "P@ssword01", "password_confirmation": "P@ssword01" }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=201, description="Created"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=422, description="Unprocessable Entity"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=500, description="Internal server error")
     *  )
     *
     *  User registration
     *
     *  @param UserRegister $request
     *
     *  @return Response
     */
    public function register(UserRegister $request): Response
    {
        $this->authService->register($request->only('email', 'password', 'name'));

        return $this->response->created();
    }

    /**
     * @OA\Get(
     *      path="/auth/email/verify/{id}",
     *      operationId="emailVerify",
     *      tags={"Authentication"},
     *      summary="Email verification.",
     *      description="Marks user email as verified.",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(response=204, description="No content"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=500, description="Internal server error")
     *  )
     *
     * User email verification
     *
     * @param int $id
     * @param Request $request
     *
     * @return void
     */
    public function verify(int $id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return $this->response->errorBadRequest('Invalid verirification link.');
        }

        $this->authService->verify($id);

        return $this->response->noContent();
    }

    /**
     * @OA\Post(
     *      path="/auth/email/resend",
     *      operationId="emailResend",
     *      tags={"Authentication"},
     *      summary="Resend email verification link.",
     *      description="Sends email verification link.",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="email",
     *                      type="email"
     *                  ),
     *                  example={"email": "gladwell_n@live.com" }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=201, description="No content"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=422, description="Unprocessable Entity"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=500, description="Internal server error")
     *  )
     *
     * Resend user verification email
     *
     * @param EmailVerification $request
     *
     * @return Response
     */
    public function resend(EmailVerification $request): Response
    {
        $this->authService->resend($request->email);

        return $this->response->noContent();
    }

    /**
     *  @OA\Post(
     *      path="/auth/login",
     *      operationId="login",
     *      tags={"Authentication"},
     *      summary="User login.",
     *      description="Authenticates users.",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="email",
     *                      type="email"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string"
     *                  ),
     *                  example={"email": "gladwell_n@live.com", "password": "P@ssword01" }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="Successful request"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=422, description="Unprocessable Entity"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=500, description="Internal server error")
     * )
     *
     * User login
     *
     * @param UserLogin $request
     *
     * @return Response
     */
    public function login(UserLogin $request): Response
    {
        $token = $this->authService->login($request->only('email', 'password'));

        return $this->response->array($token);
    }

    /**
     *  @OA\Post(
     *      path="/auth/two-factor",
     *      operationId="twoFactorLogin",
     *      tags={"Authentication"},
     *      summary="Google2FA login.",
     *      description="Validate Google2FA code and login..",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="email",
     *                      type="email"
     *                  ),
     *                  @OA\Property(
     *                      property="code",
     *                      type="integer"
     *                  ),
     *                  example={"email": "gladwell_n@live.com", "code": 123456 }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="Successful request"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=422, description="Unprocessable Entity")
     * )
     *
     * Google2FA login
     *
     * @param TwoFactorLogin $request
     *
     * @return Response
     */
    public function twoFactorLogin(TwoFactorLogin $request): Response
    {
        $token = $this->authService->twoFactorLogin($request->only(['email', 'code']));

        return $this->response->array($token);
    }

    /**
     *  @OA\Post(
     *      path="/auth/refresh",
     *      operationId="tokenRefresh",
     *      tags={"Authentication"},
     *      summary="Refresh authentication token..",
     *      security={
     *         {"bearerAuth": {}}
     *      },
     *      description="Invalidates old tokens and return a new one.",
     *      @OA\Response(response=200, description="Successful request"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=500, description="Internal server error")
     * )
     *
     * Refresh authentication token
     *
     * @return Response
     */
    public function refresh(): Response
    {
        $token = $this->authService->refresh();

        return $this->response->array($token);
    }

    /**
     *  @OA\Get(
     *      path="/auth/me",
     *      operationId="profile",
     *      tags={"Authentication"},
     *      summary="User profile",
     *      security={
     *         {"bearerAuth": {}}
     *      },
     *      description="Returns user profile.",
     *      @OA\Response(response=200, description="Successful request"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     *
     * User profile
     *
     * @return Response
     */
    public function profile(): Response
    {
        $user = $this->authService->profile();

        return $this->response->item($user, new UserTransformer);
    }

    /**
     *  @OA\Post(
     *      path="/auth/logout",
     *      operationId="profile",
     *      tags={"Authentication"},
     *      summary="User profile",
     *      security={
     *         {"bearerAuth": {}}
     *      },
     *      description="Invalidate authentication token.",
     *      @OA\Response(response=201, description="Successful request"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=401, description="Unauthorized")
     *  )
     *
     *  Invalidate authentication token
     *
     * @return Response
     */
    public function logout(): Response
    {
        $this->authService->logout();

        return $this->response->noContent();
    }

    /**
     * @OA\Post(
     *      path="/auth/password/forgot",
     *      operationId="forgotPassword",
     *      tags={"Authentication"},
     *      summary="Password reset link.",
     *      description="Sends password reset link.",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="email",
     *                      type="email"
     *                  ),
     *                  example={"email": "gladwell_n@live.com" }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=201, description="Successful request"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=422, description="Unprocessable Entity"),
     *      @OA\Response(response=429, description="Too Many Requests"),
     *      @OA\Response(response=500, description="Internal server error")
     * )
     *
     * Send password reset link
     *
     * @param ForgotPassword $request
     * @return Response
     */
    public function forgotPassword(ForgotPassword $request): Response
    {
        $this->authService->sendResetLink($request->only('email'));

        return $this->response->noContent();
    }

    /**
     *  @OA\Get(
     *      path="/auth/password/reset",
     *      operationId="resetPassword",
     *      tags={"Authentication"},
     *      summary="Reset password",
     *      description="Saves new user password",
     *      @OA\Response(response=201, description="Successful operation")
     *  )
     *
     *  Reset user password
     *
     *  @param ResetPassword $request
     *  @return Response
     */
    public function resetPassword(ResetPassword $request): Response
    {
        $this->authService->resetPassword($request->only('email', 'password', 'password_confirmation', 'token'));

        return $this->response->noContent();
    }
}
