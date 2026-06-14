<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Item;
use App\Models\Book;
use App\Models\User;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if items, books, and users exist
        $itemsCount = Item::count();
        $booksCount = Book::count();
        $usersCount = User::count();

        if ($itemsCount === 0 || $booksCount === 0 || $usersCount === 0) {
            $this->command->info('Items, Books or Users not found. Please run ItemSeeder, BookSeeder and UserSeeder first.');
            return;
        }

        // Create 30 reservations
        Reservation::factory()
            ->count(30)
            ->create();

        $this->command->info('ReservationSeeder completed successfully.');
    }
}

