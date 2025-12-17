<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Heading
        Faq::create([
            'section' => 'heading',
            'title' => 'Explore common questions about our services',
            'subtitle' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum odit perspiciatis fuga labore .',
            'image' => '/assets/images/faq.jpg',
        ]);

        // FAQs
        Faq::insert([
            [
                'section' => 'faq',
                'question' => 'What is this product?',
                'answer' => 'Our product is a comprehensive solution...',
            ],
            [
                'section' => 'faq',
                'question' => 'How do I get Started?',
                'answer' => 'This product is designed for teams...',
            ],
        ]);

    }
}
