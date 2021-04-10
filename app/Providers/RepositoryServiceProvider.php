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
use App\Api\V1\Services\BankService\BankService;
use App\Api\V1\Services\BankService\IBankService;
use App\Api\V1\Repositories\BranchRepository\IBranchRepository;
use App\Api\V1\Repositories\BranchRepository\BranchRepository;
use App\Api\V1\Repositories\AccountTypeRepository\IAccountTypeRepository;
use App\Api\V1\Repositories\AccountTypeRepository\AccountTypeRepository;
use App\Api\V1\Repositories\AccountRepository\IAccountRepository;
use App\Api\V1\Repositories\AccountRepository\AccountRepository;

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
        $this->app->bind(IBankService::class, BankService::class);
        $this->app->bind(IBranchRepository::class, BranchRepository::class);
        $this->app->bind(IAccountTypeRepository::class, AccountTypeRepository::class);
        $this->app->bind(IAccountRepository::class, AccountRepository::class);
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
