<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'admin',
                'username' => 'Administrator',
                'password' => bcrypt('12345'),
                'level' => 1,
                'email' => 'admin@gmail.com'
            ],
            [
                'name' => 'Owner',
                'username' => 'Owner',
                'password' => bcrypt('12345'),
                'level' => 1,
                'email' => 'owner@gmail.com'
            ],
            [
                'name' => 'kasir',
                'username' => 'kasir',
                'password' => bcrypt('12345'),
                'level' => 1,
                'email' => 'kasir@gmail.com'
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
