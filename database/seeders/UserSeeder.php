<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::create([
            'name' => 'SuperAdmin', 
            'email' => 'super@test.com',
            'password' => bcrypt('password'),
            'phone_number' => '3221232212',
            'image' => 'defaultImage.jpg',
            'goal' => 'gain weight'
        ]);
        
        $superAdmin->assignRole('superAdmin');
        
        $admin = User::create([
            'name' => 'Admin', 
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'phone_number' => '3221232212',
            'image' => 'defaultImage.jpg',
            'goal' => 'gain weight'
        ]);

        $admin->assignRole('admin');
    }
}
