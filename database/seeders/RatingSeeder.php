<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Rating;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Memulai proses seeder untuk Rating dalam jumlah besar...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Ambil semua ID relasi terlebih dahulu
        $bookIds = Book::pluck('id');
        $userIds = User::pluck('id');

        if ($bookIds->isEmpty() || $userIds->isEmpty()) {
            $this->command->error('Tidak ada data Book atau User. Jalankan seeder yang relevan terlebih dahulu.');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return;
        }

        $faker = Faker::create();
        $chunkSize = 2000; // Bisa ditingkatkan karena data rating lebih kecil
        $totalRatings = 500000;
        $ratings = [];

        $this->command->getOutput()->progressStart($totalRatings);

        Rating::withoutEvents(function () use ($bookIds, $userIds, $faker, $chunkSize, $totalRatings, &$ratings) {
            for ($i = 1; $i <= $totalRatings; $i++) {
                $ratings[] = [
                    'book_id' => $bookIds->random(),
                    'user_id' => $userIds->random(),
                    'rating' => $faker->numberBetween(1, 10),
                    'comment' => $faker->paragraph(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if (count($ratings) === $chunkSize) {
                    DB::table('ratings')->insert($ratings);
                    $ratings = []; // Reset array
                    $this->command->getOutput()->progressAdvance($chunkSize);
                }
            }

            if (! empty($ratings)) {
                DB::table('ratings')->insert($ratings);
                $this->command->getOutput()->progressAdvance(count($ratings));
            }
        });

        $this->command->getOutput()->progressFinish();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ RatingSeeder berhasil dijalankan, '.number_format($totalRatings).' data Rating telah dibuat.');
    }
}
