<?php

namespace App\Api\V1\Services\BankService;

interface IBankService
{
    /**
     * @return array
     */
    public function getBranches();
}
