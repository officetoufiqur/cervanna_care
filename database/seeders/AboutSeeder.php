<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\AboutItem;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::insert([
            [
                'id' => 1,
                'title' => 'Your Trusted Partner in Best Improvement.',
                'description' => "Servana was born out of the lessons we learned building Myhauzhelp. With MyHauzHelp, we saw firsthand the challenges working families face when looking for trustworthy home-based care and household support. We believe that true care begins at home. We are a tech-enabled home care platform dedicated to supporting families with trusted, professional help — whether it's medical support or day-to-day household assistance. We serve what matters most: your home and your health. Our mission is to create safe, well-managed, and healthy living environments by connecting you with the right support, exactly when you need it. From qualified medical caregivers — such as nurses and nurse aides — to experienced domestic workers, we bring care directly to your doorstep. We understand the pace and pressure of modern life. Whether you're a working parent, caring for an elderly loved one, recovering from surgery, or adjusting to life after childbirth, Servana makes home care seamless and stress-free. With Servana, care isn't just a service — it's a promise.",
                'image' => '/assets/images/about.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        AboutItem::insert([
            [
                'about_id' => 1,
                'tag' => 'Secure & Reliable',
                'tag_icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield h-6 w-6 text-cyan-600" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'about_id' => 1,
                'tag' => 'Expert Partnership',
                'tag_icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-handshake h-6 w-6 text-cyan-600" aria-hidden="true"><path d="m11 17 2 2a1 1 0 1 0 3-3"></path><path d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4"></path><path d="m21 3 1 11h-2"></path><path d="M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3"></path><path d="M3 4h8"></path></svg>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'about_id' => 1,
                'tag' => 'Premium Quality',
                'tag_icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star h-6 w-6 text-cyan-600" aria-hidden="true"><path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path></svg>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
