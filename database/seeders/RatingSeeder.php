<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    public function run(): void
    {

        Rating::factory()->count(500000)->create();
        $this->command->info('✅ RatingSeeder berhasil dijalankan, '.Rating::count().' data Rating dibuat.');
    }
}
