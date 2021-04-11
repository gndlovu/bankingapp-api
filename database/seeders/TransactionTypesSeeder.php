<?php

namespace Database\Seeders;

use App\Models\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypesSeeder extends Seeder
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
                'name' => 'Deposit',
            ], [
                'name' => 'Withdrawal',
            ], [
                'name' => 'Transfer',
            ]
        ];

        foreach ($types as $type) {
            TransactionType::updateOrCreate(['name' => $type['name']], $type);
        }
    }
}
