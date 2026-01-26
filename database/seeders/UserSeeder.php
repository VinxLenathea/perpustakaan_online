<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Master Admin',
            'email' => 'master@admin.com',
            'password' => bcrypt('masteradmin123'),
            'role' => 'master_admin',
        ]);
    }
}
