<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Memulai proses seeder untuk BookCategory...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Ambil semua ID buku dan kategori
        $bookIds = Book::pluck('id');
        $categoryIds = Category::pluck('id');

        if ($bookIds->isEmpty() || $categoryIds->isEmpty()) {
            $this->command->error('Tidak ada data Book atau Category. Jalankan seeder yang relevan terlebih dahulu.');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return;
        }

        $bookCategoriesData = [];
        $chunkSize = 1000; // Ukuran chunk untuk insert massal
        $totalProcessed = 0;

        $this->command->getOutput()->progressStart($bookIds->count());

        BookCategory::withoutEvents(function () use ($bookIds, $categoryIds, &$bookCategoriesData, $chunkSize, &$totalProcessed) {
            // 2. Iterasi setiap buku dan kaitkan beberapa kategori secara acak
            foreach ($bookIds as $bookId) {
                // Pilih antara 1 hingga 3 kategori unik untuk setiap buku
                $randomCategoryIds = $categoryIds->random(rand(1, min(3, $categoryIds->count())))->unique();

                foreach ($randomCategoryIds as $categoryId) {
                    $bookCategoriesData[] = [
                        'book_id' => $bookId,
                        'category_id' => $categoryId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Jika data sudah mencapai ukuran chunk, insert ke DB
                if (count($bookCategoriesData) >= $chunkSize) {
                    DB::table('book_categories')->insert($bookCategoriesData);
                    $totalProcessed += count($bookCategoriesData);
                    $bookCategoriesData = []; // Kosongkan array
                }
                $this->command->getOutput()->progressAdvance();
            }

            // Insert sisa data jika ada
            if (! empty($bookCategoriesData)) {
                DB::table('book_categories')->insert($bookCategoriesData);
                $totalProcessed += count($bookCategoriesData);
            }
        });

        $this->command->getOutput()->progressFinish();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ BookCategorySeeder berhasil dijalankan, '.number_format($totalProcessed).' relasi Book-Category telah dibuat.');
    }
}
