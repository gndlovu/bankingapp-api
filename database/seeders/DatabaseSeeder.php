<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(BanksSeeder::class);
        $this->call(BranchesSeeder::class);
        $this->call(AccountTypesSeeder::class);
        $this->call(TransactionTypesSeeder::class);
    }
}
