<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $coverUrls = [
            'http://ecx.images-amazon.com/images/I/41kSLEoswsL.jpg',
            'http://ecx.images-amazon.com/images/I/510l0qhi01L.jpg',
            'http://ecx.images-amazon.com/images/I/51p5aUY%2BOKL.jpg',
            'http://ecx.images-amazon.com/images/I/51pum0eWe4L.jpg',
            'http://ecx.images-amazon.com/images/I/51PuTPPCxaL.jpg',
            'http://ecx.images-amazon.com/images/I/51VIlqRy-VL.jpg',
            'http://ecx.images-amazon.com/images/I/41n7iZq-0jL.jpg',
            'http://ecx.images-amazon.com/images/I/41xLYt-v6nL.jpg',
            'http://ecx.images-amazon.com/images/I/51C16779N8L.jpg',
            'http://ecx.images-amazon.com/images/I/51JFeqcU96L.jpg',
            'http://ecx.images-amazon.com/images/I/51C16779N8L.jpg',
            'http://ecx.images-amazon.com/images/I/51bWdcsbX0L.jpg',
            'http://ecx.images-amazon.com/images/I/51zi2q5JfbL.jpg',
            'http://ecx.images-amazon.com/images/I/61c4EZtdtNL.jpg',
            'http://ecx.images-amazon.com/images/I/41uPslzVRgL.jpg',
            'http://ecx.images-amazon.com/images/I/51BLmSCM6dL.jpg',
            'http://ecx.images-amazon.com/images/I/61INLFujcpL.jpg',
        ];

        return [
            'title' => $this->faker->sentence(3),
            'isbn' => $this->faker->unique()->isbn13(),
            'publication_year' => $this->faker->year(),
            'author_id' => Author::inRandomOrder()->first()->id,
            'publisher_id' => Publisher::inRandomOrder()->first()->id,
            'cover' => $this->faker->randomElement($coverUrls),
        ];
    }
}
