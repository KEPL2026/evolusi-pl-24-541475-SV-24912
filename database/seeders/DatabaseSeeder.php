<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Task::create([
            'title' => 'Tugas 1: Setup CI/CD Pipeline',
            'description' => 'Konfigurasi 4 stages: build, test, staging, production',
            'is_completed' => true,
        ]);

        Task::create([
            'title' => 'Tugas 2: Buat SSH Key Deploy',
            'description' => 'Generate ed25519 dan simpan di Actions Secrets',
            'is_completed' => true,
        ]);

        Task::create([
            'title' => 'Tugas 3: Uji Deployment',
            'description' => 'Jalankan deploy.sh lewat SSH ke runner',
            'is_completed' => false,
        ]);
    }
}
