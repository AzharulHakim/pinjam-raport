<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // Classes
        $class1 = \App\Models\SchoolClass::create(['name' => 'XII RPL 1']);
        $class2 = \App\Models\SchoolClass::create(['name' => 'XII TKJ 1']);

        // Students
        \App\Models\Student::create([
            'nis' => '12345',
            'name' => 'Budi Santoso',
            'class_id' => $class1->id,
        ]);

        \App\Models\Student::create([
            'nis' => '67890',
            'name' => 'Siti Aminah',
            'class_id' => $class2->id,
        ]);
    }
}
