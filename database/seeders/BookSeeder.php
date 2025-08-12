<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Memulai proses seeder untuk Book dalam jumlah besar...');

        // Menonaktifkan foreign key checks untuk sementara (hanya untuk MySQL)
        // Untuk database lain seperti PostgreSQL, gunakan sintaks yang sesuai.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Ambil semua ID penulis terlebih dahulu untuk menghindari N+1 query problem
        $authorIds = Author::pluck('id');

        if ($authorIds->isEmpty()) {
            $this->command->error('Tidak ada data Author. Jalankan AuthorSeeder terlebih dahulu.');
            DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Aktifkan kembali sebelum keluar

            return;
        }

        $faker = Faker::create();
        $chunkSize = 1000; // Ukuran setiap chunk yang akan di-insert
        $totalBooks = 100000; // Total data yang ingin dibuat
        $books = [];

        $this->command->getOutput()->progressStart($totalBooks);

        // 2. Nonaktifkan model events untuk performa maksimal
        Book::withoutEvents(function () use ($authorIds, $faker, $chunkSize, $totalBooks, &$books) {
            for ($i = 1; $i <= $totalBooks; $i++) {
                // 3. Buat data sebagai array, ini lebih cepat dari factory()->make()
                $books[] = [
                    'title' => $faker->unique(false, 500000)->sentence(3),
                    'author_id' => $authorIds->random(),
                    'description' => $faker->paragraph(),
                    'published_year' => $faker->year(),
                    'stock' => $faker->numberBetween(0, 100),
                    'price' => $faker->randomFloat(2, 10, 100),
                    'avg_rating' => $faker->randomFloat(2, 1, 5),
                    'voters_count' => $faker->numberBetween(0, 1000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // 4. Jika chunk sudah mencapai ukuran yang ditentukan, insert ke DB
                if (count($books) === $chunkSize) {
                    DB::table('books')->insert($books);
                    $books = []; // Kosongkan array untuk chunk berikutnya
                    $this->command->getOutput()->progressAdvance($chunkSize);
                }
            }

            // 5. Insert sisa data yang belum mencapai ukuran chunk
            if (! empty($books)) {
                DB::table('books')->insert($books);
                $this->command->getOutput()->progressAdvance(count($books));
            }
        });

        $this->command->getOutput()->progressFinish();

        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ BookSeeder berhasil dijalankan, '.number_format($totalBooks).' data Book telah dibuat.');
    }
}
