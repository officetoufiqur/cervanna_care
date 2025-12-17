<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::insert([
            [
                'title' => 'Caring Hands, Professional Hearts',
                'sub_title' => 'ervanna makes it easy to find reliable, professional caregivers — whether it’s medical support or household help — so you’re never alone in the journey',
                'btn_text' => 'Learn More',
                'image' => '/assets/images/hero.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
