<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        // Create 3-500000 ratings for each book
        Book::all()->each(function ($book) {
            $numberOfRatings = rand(3, 500000);

            Rating::factory()->count($numberOfRatings)->create([
                'book_id' => $book->id,
                'user_id' => fn () => User::factory()->create()->id,
            ]);

            // Update book's average rating
            $avgRating = Rating::where('book_id', $book->id)->avg('rating');
            $votersCount = Rating::where('book_id', $book->id)->count();

            $book->update([
                'avg_rating' => $avgRating,
                'voters_count' => $votersCount,
            ]);
        });

        $this->command->info('✅ RatingSeeder berhasil dijalankan, '.Rating::count().' data Rating dibuat.');
    }
}
