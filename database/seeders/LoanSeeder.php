<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\Item;
use App\Models\User;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if items and users exist
        $itemsCount = Item::count();
        $usersCount = User::count();

        if ($itemsCount === 0 || $usersCount === 0) {
            $this->command->info('Items or Users not found. Please run ItemSeeder and UserSeeder first.');
            return;
        }

        // Create 50 loans
        Loan::factory()
            ->count(50)
            ->create();

        $this->command->info('LoanSeeder completed successfully.');
    }
}

