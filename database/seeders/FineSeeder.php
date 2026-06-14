<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\User;

class FineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if loans and users exist
        $loansCount = Loan::count();
        $usersCount = User::count();

        if ($loansCount === 0 || $usersCount === 0) {
            $this->command->info('Loans or Users not found. Please run LoanSeeder and UserSeeder first.');
            return;
        }

        // Create 25 fines
        Fine::factory()
            ->count(25)
            ->create();

        $this->command->info('FineSeeder completed successfully.');
    }
}

