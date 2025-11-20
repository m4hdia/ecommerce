<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ProductSeeder::class,
        ]);

        User::firstOrCreate(
            ['email' => 'oussamaessalhi@gmail.com'],
            [
                'name' => 'Oussama Essalhi',
                'password' => Hash::make('oussamaessalhi'),
                'role' => 'admin',
            ]
        );
    }
}