<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // categories
        DB::table('categories')->insert([
            [
                "id" => 1,
                "name" => "LG",
                "sort_num" => 1
            ],
            [
                "id" => 2,
                "name" => "Nokia",
                "sort_num" => 2
            ],
            [
                "id" => 3,
                "name" => "HTC",
                "sort_num" => 3
            ],
            [
                "id" => 4,
                "name" => "OPPO",
                "sort_num" => 4
            ],
            [
                "id" => 5,
                "name" => "Apple",
                "sort_num" => 5
            ],
        ]);

        // users
        DB::table('users')->insert([
            [
                "id" => 1,
                "name" => "HaoNP",
                "email" => "haonp@gmail.com",
                "password" => Hash::make('123456')
            ]
        ]);
    }
}
