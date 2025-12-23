<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventPartner;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::insert([
            [
                'id' => 1,
                'title' => 'Transformed for Better – Employer Edition 1 (May 2024)',
                'description' => 'The Transformed for Better workshop brought together a powerful circle of mothers committed to redefining home dynamics, parenting, and the role of domestic workers. Hosted by MyHauzHelp, the event created a safe space for learning, reflection, and meaningful connection. The day began with a heartfelt introduction from Rahab, CEO of then MyHauzHelp, who courageously highlighted the challenges faced by domestic workers—ranging from lack of recognition to emotional burnout. She shared the vision behind Transformed for Better: to build homes grounded in empathy, dignity, and mutual respect. The Transformed for Better workshop brought together a powerful circle of mothers committed to redefining home dynamics, parenting, and the role of domestic workers. Hosted by MyHauzHelp, the event created a safe space for learning, reflection, and meaningful connection. The day began with a heartfelt introduction from Rahab, CEO of then MyHauzHelp, who courageously highlighted the challenges faced by domestic workers—ranging from lack of recognition to emotional burnout. She shared the vision behind Transformed for Better: to build homes grounded in empathy, dignity, and mutual respect.',
                'image' => '/assets/images/event1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        EventPartner::insert([
            [
                'event_id' => 1,
                'name' => 'Kingdom Bank',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
