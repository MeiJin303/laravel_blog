<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

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
        $faker = Faker::create();

        foreach(range(1,10) as $index) {
            DB::table('users')->insert([
                'name' => $faker->firstName()." ".$faker->lastName(),
                'email' => $faker->email(),
                'password' => $faker->password(8, 10)
            ]);
        }

        foreach(range(1,500) as $index) {
            DB::table('posts')->insert([
                'title' => "Test title ".$index,
                'user_id' => rand(1, 10),
                'created_at' => $faker->dateTime(),
                'description' => $faker->realText(300)
            ]);
        }

        foreach(range(1,100) as $index) {
            DB::table('api_settings')->insert([
                'user_id' => rand(1, 10),
                'created_at' => $faker->dateTime(),
                'api_url' => $faker->url(),
                'execute_duration_min' => $faker->randomDigitNotZero(),
                'active' => 1
            ]);
        }
    }
}
