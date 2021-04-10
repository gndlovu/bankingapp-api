<?php

namespace App\Api\V1\Services\BankService;

use Illuminate\Database\Eloquent\Collection;
use App\Api\V1\Repositories\BranchRepository\BranchRepository;
use App\Api\V1\Repositories\BranchRepository\IBranchRepository;
use App\Api\V1\Repositories\AccountTypeRepository\AccountTypeRepository;
use App\Api\V1\Repositories\AccountTypeRepository\IAccountTypeRepository;
use App\Api\V1\Repositories\AccountRepository\AccountRepository;
use App\Api\V1\Repositories\AccountRepository\IAccountRepository;

class BankService implements IBankService
{
    /**
     * @var BranchRepository
     */
    private $branchRepo;

    /**
     * @var AccountTypeRepository
     */
    private $accountTypeRepo;

    /**
     * @var AccountRepository
     */
    private $accountRepo;

    /**
     * BankService constructor
     *
     * @param IBranchRepository $branchRepository
     * @param IAccountTypeRepository $accountTypeRepository
     */
    public function __construct(
        IBranchRepository $branchRepository,
        IAccountTypeRepository $accountTypeRepository,
        IAccountRepository $accountRepository
    ) {
        $this->branchRepo = $branchRepository;
        $this->accountTypeRepo = $accountTypeRepository;
        $this->accountRepo = $accountRepository;
    }

    /**
     * Gets bank branches
     * 
     * @return array
     */
    public function getBranches(): Collection
    {
        return $this->branchRepo->all();
    }

    /**
     * Gets bank account types
     * 
     * @return array
     */
    public function getAccountTypes(): Collection
    {
        return $this->accountTypeRepo->all();
    }

    /**
     * Gets bank accounts
     * 
     * @return array
     */
    public function getAccounts(): Collection
    {
        return $this->accountRepo->findByUser(auth()->user()->id);
    }

    /**
     * @param array $data
     * @return void
     */
    public function createAccount($data)
    {
        data_fill($data, 'user_id', auth()->user()->id);
        data_fill($data, 'balance', 0);

        $this->accountRepo->create($data);
    }

    /**
     * @param array $data
     * @return void
     */
    public function updateAccount($data)
    {
        // TODO - Check if account belongs to authenticated user.
        $this->accountRepo->updateOrCreate(['id' => $data['id']], $data);
    }
}
