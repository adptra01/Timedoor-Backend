<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $totalUsers = 50000; // Jumlah user yang ingin dibuat
        $this->command->info("Memulai seeder untuk $totalUsers Users...");

        $chunkSize = 1000; // Ukuran chunk untuk insert massal

        User::withoutEvents(function () use ($totalUsers, $chunkSize) {
            // Buat data di memori
            $users = User::factory()->count($totalUsers)->make();

            // Pecah menjadi beberapa bagian
            $chunks = $users->chunk($chunkSize);

            foreach ($chunks as $chunk) {
                // Tambahkan timestamp dan insert secara massal
                $insertData = $chunk->map(function ($user) {
                    $data = $user->toArray();
                    $data['created_at'] = now();
                    $data['updated_at'] = now();

                    return $data;
                })->toArray();

                DB::table('users')->insert($insertData);
            }
        });

        $this->command->info("✅ UserSeeder berhasil dijalankan, $totalUsers data User dibuat.");
    }
}
