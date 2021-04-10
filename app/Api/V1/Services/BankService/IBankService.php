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
}
