<?php

namespace App\Api\V1\Services\BankService;

use Illuminate\Database\Eloquent\Collection;
use App\Api\V1\Repositories\BranchRepository\BranchRepository;
use App\Api\V1\Repositories\BranchRepository\IBranchRepository;
use App\Api\V1\Repositories\AccountTypeRepository\AccountTypeRepository;
use App\Api\V1\Repositories\AccountTypeRepository\IAccountTypeRepository;

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
     * BankService constructor
     *
     * @param IBranchRepository $branchRepository
     * @param IAccountTypeRepository $accountTypeRepository
     */
    public function __construct(IBranchRepository $branchRepository, IAccountTypeRepository $accountTypeRepository)
    {
        $this->branchRepo = $branchRepository;
        $this->accountTypeRepo = $accountTypeRepository;
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
}
