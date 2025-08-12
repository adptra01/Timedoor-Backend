<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookRatingRecalculatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Memulai perhitungan ulang avg_rating dan voters_count untuk Books...');

        // Nonaktifkan foreign key checks jika diperlukan (biasanya tidak untuk UPDATE)
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Update avg_rating (rata-rata dari semua rating)
        DB::statement('
            UPDATE books b
            SET b.avg_rating = (
                SELECT AVG(r.rating)
                FROM ratings r
                WHERE r.book_id = b.id
            )
            WHERE EXISTS (
                SELECT 1
                FROM ratings r
                WHERE r.book_id = b.id
            );
        ');

        // Update voters_count (jumlah rating > 5, sesuai deskripsi di PDF untuk Top 10 Authors)
        DB::statement('
            UPDATE books b
            SET b.voters_count = (
                SELECT COUNT(r.id)
                FROM ratings r
                WHERE r.book_id = b.id AND r.rating > 5
            )
            WHERE EXISTS (
                SELECT 1
                FROM ratings r
                WHERE r.book_id = b.id AND r.rating > 5
            );
        ');

        // Set avg_rating dan voters_count ke 0 jika tidak ada rating
        DB::statement('UPDATE books SET avg_rating = 0 WHERE avg_rating IS NULL;');
        DB::statement('UPDATE books SET voters_count = 0 WHERE voters_count IS NULL;');

        // Aktifkan kembali foreign key checks jika dinonaktifkan
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ Perhitungan ulang avg_rating dan voters_count selesai.');
    }
}
