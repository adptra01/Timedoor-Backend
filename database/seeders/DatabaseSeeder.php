<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Category;
use App\Models\Rating;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Author::factory(10)->create();
        Book::factory(10)->create();
        Category::factory(10)->create();
        BookCategory::factory(10)->create();
        Rating::factory(10)->create();

        // $this->call([
        //     AuthorSeeder::class,      // First, create authors
        //     CategorySeeder::class,     // Then categories
        //     BookSeeder::class,         // Then books (needs authors)
        //     BookCategorySeeder::class, // Then book-category relations (needs books and categories)
        //     RatingSeeder::class,       // Finally ratings (needs books and creates users)
        // ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
