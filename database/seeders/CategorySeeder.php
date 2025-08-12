<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $totalCategories = 3000;
        $this->command->info("Memulai seeder untuk $totalCategories Categories...");

        $chunkSize = 500;

        Category::withoutEvents(function () use ($totalCategories, $chunkSize) {
            // Buat data di memori
            $categories = Category::factory()->count($totalCategories)->make();

            // Pecah menjadi beberapa bagian
            $chunks = $categories->chunk($chunkSize);

            foreach ($chunks as $chunk) {
                // Tambahkan timestamp dan insert secara massal
                $insertData = $chunk->map(function ($category) {
                    $data = $category->toArray();
                    $data['created_at'] = now();
                    $data['updated_at'] = now();

                    return $data;
                })->toArray();

                DB::table('categories')->insert($insertData);
            }
        });

        $this->command->info("✅ CategorySeeder berhasil dijalankan, $totalCategories data Category dibuat.");
    }
}
