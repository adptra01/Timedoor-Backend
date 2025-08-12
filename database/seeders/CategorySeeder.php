<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->count(3000)->create();

        $this->command->info('✅ CategorySeeder berhasil dijalankan, 3000 data Category dibuat.');
    }
}
