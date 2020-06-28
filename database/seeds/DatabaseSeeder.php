<?php

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
        $random = rand(1,5);
        factory(App\User::class,3)->create()->each(function ($u) use ($random) {
            $u->questions()
              ->saveMany(factory(App\Question::class , $random)->make());
        });
    }
}
