<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::factory()->count(1000)->create();

        $this->command->info('✅ AuthorSeeder berhasil dijalankan, 1000 data Author dibuat.');
    }
}
