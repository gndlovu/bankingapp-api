<?php

namespace App\Api\V1\Services\BankService;

use Illuminate\Database\Eloquent\Collection;
use App\Api\V1\Repositories\BranchRepository\BranchRepository;
use App\Api\V1\Repositories\BranchRepository\IBranchRepository;
use App\Api\V1\Repositories\AccountTypeRepository\AccountTypeRepository;
use App\Api\V1\Repositories\AccountTypeRepository\IAccountTypeRepository;
use App\Api\V1\Repositories\AccountRepository\AccountRepository;
use App\Api\V1\Repositories\AccountRepository\IAccountRepository;
use App\Api\V1\Repositories\TransactionRepository\TransactionRepository;
use App\Api\V1\Repositories\TransactionRepository\ITransactionRepository;
use App\Api\V1\Repositories\TransactionTypeRepository\TransactionTypeRepository;
use App\Api\V1\Repositories\TransactionTypeRepository\ITransactionTypeRepository;
use App\Models\Account;

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
     * @var TransactionRepository
     */
    private $transactionRepo;

    /**
     * @var TransactionTypeRepository
     */
    private $transactionTypeRepo;

    /**
     * BankService constructor
     *
     * @param IBranchRepository $branchRepository
     * @param IAccountTypeRepository $accountTypeRepository
     * @param IAccountRepository $accountRepository
     * @param ITransactionRepository $transactionRepository
     * @param ITransactionTypeRepository $transactionTypeRepository
     */
    public function __construct(
        IBranchRepository $branchRepository,
        IAccountTypeRepository $accountTypeRepository,
        IAccountRepository $accountRepository,
        ITransactionRepository $transactionRepository,
        ITransactionTypeRepository $transactionTypeRepository
    ) {
        $this->branchRepo = $branchRepository;
        $this->accountTypeRepo = $accountTypeRepository;
        $this->accountRepo = $accountRepository;
        $this->transactionRepo = $transactionRepository;
        $this->transactionTypeRepo = $transactionTypeRepository;
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

    /**
     * Gets bank account transactions
     * 
     * @param int $account_id
     * @return array
     */
    public function getAccountTransactions($account_id): Collection
    {
        return $this->transactionRepo->findByAccount($account_id);
    }

    /**
     * Gets bank account details
     * 
     * @param int $id
     * @return Account|null
     */
    public function getAccount($id): ?Account
    {
        $account = $this->accountRepo->find($id);

        abort_if($account === null, 400, 'Invalid account.');

        return $account;
    }

    /**
     * Create bank account transaction
     * 
     * @param int $account_id
     * @param array $transaction
     * @return Account
     */
    public function createTransaction($account_id, $transaction): void
    {
        $account = $this->accountRepo->find($account_id); // TODO - check if this belongs to the authenticated user
        $transactionType = $this->transactionTypeRepo->findByName($transaction['type']);

        abort_if($transactionType === null, 400, 'Could not initiate transaction: Invalid transaction type.');

        data_fill($transaction, 'account_id', $account_id);
        data_fill($transaction, 'transaction_type_id', $transactionType->id);

        $balance = $this->calculateBalance($transaction['type'], $account->balance, $transaction['amount']);
        // TODO -Check funds availability on withdrawal transaction.

        $this->transactionRepo->create($transaction);

        $this->accountRepo->updateOrCreate(['id' => $account->id], ['balance' => $balance]);

        if ($transaction['type'] === 'transfer') {
            $toAccount = $this->accountRepo->find($transaction['to_account_id']); // TODO - check if this belongs to the authenticated user
            $balance = $this->calculateBalance('deposit', $toAccount->balance, $transaction['amount']);
            $this->accountRepo->updateOrCreate(['id' => $toAccount->id], ['balance' => $balance]);
        }
    }

    /**
     * Calculates account balance.
     *
     * @param string $transaction
     * @param int $balance
     * @param int $amount
     * @return int
     */
    private function calculateBalance($transaction, $balance, $amount)
    {
        switch ($transaction) {
            case 'deposit':
                $balance = $balance + $amount;
                break;
            case 'withdrawal':
            case 'transfer':
                $balance = $balance - $amount;
                break;
            default:
                break;
        }

        return $balance;
    }
}
