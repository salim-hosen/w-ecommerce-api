<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                "name" => "Admin",
                "email" => "admin@admin.com",
                "password" => \Hash::make("password"),
                "role" => "admin"
            ],
            [
                "name" => "Buyer",
                "email" => "buyer@buyer.com",
                "password" => \Hash::make("password"),
                "role" => "buyer"
            ],
        ];

        \App\Models\User::insert($users);
    }
}
