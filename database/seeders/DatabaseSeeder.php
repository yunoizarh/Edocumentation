<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\FacultySeeder;
use App\Models\Admin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $admin = Admin::create([
            'name' => 'Admin Name',
            'email' => 'mimi@gmail.com',
            'password' => Hash::make('mimi'),
        ]);

        // Seed the Faculty table
        $this->call(FacultySeeder::class);

        // Seed the Department table
        $this->call(DepartmentSeeder::class);
    }
}
