<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $totalUsers = 50000; // Jumlah user yang ingin dibuat
        $this->command->info("Memulai seeder untuk $totalUsers Users...");

        // Tidak perlu truncate karena `migrate:fresh` sudah melakukannya.

        // Buat satu user default yang bisa digunakan untuk login/testing
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Buat sisa user lainnya
        User::factory()->count($totalUsers - 1)->create();

        $this->command->info("✅ UserSeeder berhasil dijalankan, $totalUsers data User dibuat.");
    }
}
