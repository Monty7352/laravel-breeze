<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(1000)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $faker = Faker::create();
        $numberOfRecords = 100000;

        for ($i = 0; $i < $numberOfRecords; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password'=>$faker->password,
                // Add more columns as needed
            ]);
        }
    }
}
