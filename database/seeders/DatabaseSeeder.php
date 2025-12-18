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
        $this->call([
            FaqSeeder::class,
            BannerSeeder::class,
            NewsLetterSeeder::class,
            ChooseSeeder::class,
            ServiceSeeder::class
        ]);

         User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'number' => '1234567890',
            'email_verified_at' => now(),
        ]);
    }
}
