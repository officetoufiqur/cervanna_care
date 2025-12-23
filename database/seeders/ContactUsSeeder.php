<?php

namespace Database\Seeders;

use App\Models\ContactUs;
use Illuminate\Database\Seeder;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactUs::insert([
            [
                'section' => 'contact',
                'heading' => 'Get In Touch',
                'sub_heading' => 'We are here to help and answer any question you might have',
                'title' => null,
                'subtitle' => null,
                'icon' => null,
                'map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d314063.8996500354!2d36.847397!3d-1.675244!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1172d84d49a7%3A0xf7cf0254b297924c!2sNairobi%2C%20Kenya!5e1!3m2!1sen!2sbd!4v1766489320830!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'section' => 'card',
                'heading' => null,
                'sub_heading' => null,
                'title' => 'Location',
                'subtitle' => '123 Main Street Nairobi, Kenya',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin h-7 w-7 text-blue-600" aria-hidden="true"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>',
                'map' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'section' => 'card',
                'heading' => null,
                'sub_heading' => null,
                'title' => 'Mail Us',
                'subtitle' => 'hello@example.com',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail h-7 w-7 text-cyan-600" aria-hidden="true"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg>',
                'map' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'section' => 'card',
                'heading' => null,
                'sub_heading' => null,
                'title' => 'Phone Us',
                'subtitle' => '+254 712 345 678',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone h-7 w-7 text-purple-600" aria-hidden="true"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path></svg>',
                'map' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
