<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Seeder;

class AccountTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'Savings Account',
            ], [
                'name' => 'Cheque Account',
            ],
        ];

        foreach ($types as $type) {
            AccountType::updateOrCreate(['name' => $type['name']], $type);
        }
    }
}
