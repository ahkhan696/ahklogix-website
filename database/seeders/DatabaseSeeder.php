<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // TODO: Change this password before going to production!
        User::firstOrCreate(
            ['email' => 'admin@ahklogix.com'],
            [
                'name'              => 'AHKLOGIX Admin',
                'password'          => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            ServicesSeeder::class,
            ProjectsSeeder::class,
            ReviewsSeeder::class,
            FaqsSeeder::class,
            PostsSeeder::class,
            SettingsSeeder::class,
        ]);
    }
}
