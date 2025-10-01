<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $userData = [
            [
                'name' => 'Danis',
                'email' => 'm.daniswara.m@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ],
            [
                'name' => 'Kato',
                'email' => 'kato@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'user',
            ],
            [
                'name' => 'Riham',
                'email' => 'riham@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'user',
            ],
        ];

        foreach ($userData as $val) {
            User::updateOrCreate(['email' => $val['email']], $val);
        }
    }
}
