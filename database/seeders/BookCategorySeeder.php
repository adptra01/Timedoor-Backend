<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Assign 1-3 random categories to each book
        Book::all()->each(function ($book) {
            $randomCategories = Category::inRandomOrder()
                ->limit(rand(1, 3000))
                ->get();

            foreach ($randomCategories as $category) {
                BookCategory::factory()->create([
                    'book_id' => $book->id,
                    'category_id' => $category->id,
                ]);
            }
        });

        $this->command->info('✅ BookCategorySeeder berhasil dijalankan, '.BookCategory::count().' data BookCategory dibuat.');
    }
}
