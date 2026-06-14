<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Book;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if books exist
        $booksCount = Book::count();

        if ($booksCount === 0) {
            $this->command->info('No books found. Please run the BookSeeder first.');
            return;
        }

        // Create 3-5 items for each book
        Book::all()->each(function ($book) {
            Item::factory()
                ->count(rand(3, 5))
                ->create([
                    'book_id' => $book->id,
                ]);
        });

        $this->command->info('ItemSeeder completed successfully.');
    }
}

