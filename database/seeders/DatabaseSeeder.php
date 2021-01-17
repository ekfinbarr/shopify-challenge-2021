<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::factory(5)->hasMedia(3)->create();
        \App\Models\Media::factory(20)->hasComments(3)->hasTags(4)->create();
        \App\Models\Comment::factory(50)->create();
    }
}
