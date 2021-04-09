<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Api\V1\Repositories\BaseRepository;
use App\Api\V1\Repositories\IBaseRepository;
use App\Api\V1\Services\AuthService\AuthService;
use App\Api\V1\Services\AuthService\IAuthService;
use App\Api\V1\Repositories\UserRepository\IUserRepository;
use App\Api\V1\Repositories\UserRepository\UserRepository;
use App\Api\V1\Services\TwoFactorService\TwoFactorService;
use App\Api\V1\Services\TwoFactorService\ITwoFactorService;

/**
 * Class RepositoryServiceProvider
 *
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IBaseRepository::class, BaseRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(ITwoFactorService::class, TwoFactorService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
