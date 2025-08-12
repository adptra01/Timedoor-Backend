<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::factory()->count(500000)->create();

        $this->command->info('✅ BookSeeder berhasil dijalankan, 500000 data Book dibuat.');
    }
}
