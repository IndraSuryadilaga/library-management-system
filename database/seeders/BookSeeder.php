<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Genre;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all genre IDs
        $genres = Genre::all();

        if ($genres->isEmpty()) {
            $this->command->info('No genres found. Please run the GenreSeeder first.');
            return;
        }

        // Create 213 books
        Book::factory()
            ->count(213)
            ->create()
            ->each(function ($book) use ($genres) {
                // Attach 1 to 3 random genres to each book
                $book->genres()->attach(
                    $genres->random(rand(1, 3))->pluck('id')->toArray()
                );
            });
    }
}
