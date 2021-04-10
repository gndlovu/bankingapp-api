<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            [
                'name' => 'Momentum Limited',
            ], [
                'name' => 'Absa Group Limited',
            ], [
                'name' => 'African Bank Limited',
            ], [
                'name' => 'Bidvest Bank Limited',
            ], [
                'name' => 'Capitec Bank Limited',
            ], [
                'name' => 'Discovery Limited',
            ], [
                'name' => 'First National Bank',
            ]
        ];

        foreach ($banks as $bank) {
            Bank::updateOrCreate(['name' => $bank['name']], $bank);
        }
    }
}
