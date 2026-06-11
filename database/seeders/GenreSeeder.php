<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Fiction', 'Non-Fiction', 'Science Fiction', 'Fantasy', 'Mystery',
            'Thriller', 'Romance', 'Horror', 'Historical Fiction', 'Biography',
            'Autobiography', 'Poetry', 'Self-Help', 'Young Adult', 'Children\'s',
        ];

        foreach ($genres as $genre) {
            Genre::create(['name' => $genre]);
        }
    }
}
