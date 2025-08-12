<?php

namespace Database\Seeders;

use App\Models\BookCategory;
use Illuminate\Database\Seeder;

class BookCategorySeeder extends Seeder
{
    public function run(): void
    {
        BookCategory::factory()->count(1000)->create();

        $this->command->info('✅ BookCategorySeeder berhasil dijalankan, '.BookCategory::count().' data BookCategory dibuat.');
    }
}
