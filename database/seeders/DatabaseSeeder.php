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
        User::updateOrCreate(
            ['email' => 'Azharul Hakim'],
            [
                'name' => 'Azharul Hakim',
                'password' => bcrypt('202351063'),
            ]
        );

        // Classes
        $class = \App\Models\SchoolClass::firstOrCreate([
            'level' => 'XII',
            'major' => 'RPL',
            'class_letter' => '1',
        ]);

        // Students
        \App\Models\Student::updateOrCreate(
            ['nis' => '51063'],
            [
                'name' => 'Azharul Hakim',
                'class_id' => $class->id,
            ]
        );
    }
}
