<?php

use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run()
    {
        factory(\App\Movie::class, 10)->create();
    }
}