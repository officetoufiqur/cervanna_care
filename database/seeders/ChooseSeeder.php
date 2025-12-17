<?php

namespace Database\Seeders;

use App\Models\Choose;
use Illuminate\Database\Seeder;

class ChooseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Choose::insert([
            [
                'title' => 'Affordable, transparent pricing',
                'subtitle' => 'Clear, upfront costs with no hidden fees.',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dollar-sign text-primary" aria-hidden="true"><line x1="12" x2="12" y1="2" y2="22"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
