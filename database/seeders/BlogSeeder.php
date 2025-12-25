<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::insert([
            [
                'id' => 1,
                'title' => 'The Importance of Regular Health Checkups',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia quod dolore modi neque. Accusamus dolorem maiores non commodi maxime? Dolorum tempora magni impedit totam, mollitia ea itaque et possimus eligendi vel recusandae nesciunt ab deserunt a vitae ipsum sed earum quibusdam corporis cumque? Ipsum iusto quo et enim nisi repudiandae alias! Quibusdam ratione odio vel ea quo, et voluptas sunt suscipit cumque obcaecati fugit deserunt nesciunt repellendus ipsam, similique optio. Est excepturi voluptatum ipsam accusamus tempora, eligendi tenetur reiciendis facere sit, atque sed molestiae dolore. Cum aperiam dolores dolorem explicabo similique blanditiis officia accusantium vitae porro iusto? Commodi, ipsam nobis.',
                'image' => '/assets/images/blog.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
