<?php

namespace Database\Seeders;

use App\Models\NewsLetter;
use Illuminate\Database\Seeder;

class NewsLetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsLetter::insert([
            'title' => 'Try Cervanna Care Right Now!',
            'sub_title' => 'Boost the traffic to your website and social media accounts. online traffic into sales, and clients into advocates.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
