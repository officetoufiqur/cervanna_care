<?php

namespace Database\Seeders;

use App\Models\Foundation;
use Illuminate\Database\Seeder;

class FoundationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Foundation::insert([
            [
                'heading' => "Shaping Africa's Future Through Care",
                'subheading' => "We're committed to transforming home-based care into an accessible standard for every family",
                'vision_title' => 'To Shape an Africa Where Quality Home-Based Care is a Standard',
                'vision_subtitle' => 'We envision a future where quality home-based care is not a luxury — but a standard, accessible to every family in Africa.',
                'mission_title' => 'To Become the Leading Home Care Platform',
                'mission_subtitle' => 'Were empowering families to live healthier, happier lives through trusted support and compassionate, tech-driven solutions.',
                'image' => '/assets/images/foundation.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
