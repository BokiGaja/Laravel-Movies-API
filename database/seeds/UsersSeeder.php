<?php


class UsersSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        factory(\App\User::class, 10)->create();
    }
}