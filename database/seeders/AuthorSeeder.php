<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $totalAuthors = 1000;
        $this->command->info("Memulai seeder untuk $totalAuthors Authors...");

        $chunkSize = 500;

        Author::withoutEvents(function () use ($totalAuthors, $chunkSize) {
            $authors = Author::factory()->count($totalAuthors)->make();

            $chunks = $authors->chunk($chunkSize);

            foreach ($chunks as $chunk) {
                $insertData = $chunk->map(function ($author) {
                    $data = $author->toArray();
                    $data['created_at'] = now();
                    $data['updated_at'] = now();

                    return $data;
                })->toArray();

                DB::table('authors')->insert($insertData);
            }
        });

        $this->command->info("✅ AuthorSeeder berhasil dijalankan, $totalAuthors data Author dibuat.");
    }
}
