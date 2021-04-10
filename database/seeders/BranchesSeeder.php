<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = Bank::all();

        foreach ($banks as $bank) {
            for ($i = 1; $i <= 5; $i++) {
                $digits = 6;
                $code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);

                $branch = ['bank_id' => $bank->id, 'name' => "Branch {$i}", 'code' => $code];
                Branch::updateOrCreate(['code' => $branch['code'], 'bank_id' => $bank->id], $branch);
            }
        }
    }
}
