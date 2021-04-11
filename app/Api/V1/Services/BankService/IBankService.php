<?php

namespace App\Api\V1\Services\BankService;

interface IBankService
{
    /**
     * @return array
     */
    public function getBranches();

    /**
     * @return array
     */
    public function getAccountTypes();

    /**
     * @return array
     */
    public function getAccounts();

    /**
     * @param array $attributes
     * @return void
     */
    public function createAccount(array $attributes);

    /**
     * @param array $attributes
     * @return void
     */
    public function updateAccount(array $attributes);

    /**
     * @param int $account_id
     * @return void
     */
    public function getAccountTransactions(int $account_id);

    /**
     * @param int $id
     * @return void
     */
    public function getAccount(int $id);

    /**
     * @param int $account_id
     * @param array $transaction
     * @return void
     */
    public function createTransaction(int $account_id, array $transaction);
}
