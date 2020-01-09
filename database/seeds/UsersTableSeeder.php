<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Admin

        User::create([
            'name' => 'Juan meneses',
            'email' => 'juan@gmail.com',
            'password' => bcrypt('123123'),
            'role' => 0,
        ]);

        // Ventanilla
        
        User::create([
            'name' => 'Carlos giraldo',
            'email' => 'carlos@gmail.com',
            'password' => bcrypt('123123'),
            'role' => 1,
        ]);

        // Cartografía
        
        User::create([
            'name' => 'Caliche micolta',
            'email' => 'caliche@gmail.com',
            'password' => bcrypt('123123'),
            'role' => 2,
        ]);

    }
}
