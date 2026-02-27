<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolClass;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = ['X', 'XI', 'XII'];
        $majors = [
            'Nautika Kapal Niaga (NKN)',
            'Teknika Kapal Niaga (TKN)',
            'Teknik Mesin',
            'Teknik Otomotif',
            'Teknik Elektronika',
            'Teknik Ketenagalistrikan',
        ];
        $letters = ['A', 'B', 'C'];

        foreach ($levels as $level) {
            foreach ($majors as $major) {
                foreach ($letters as $letter) {
                    // Check logic: Maybe not all majors have all classes, but for seeding we create a standard set
                    SchoolClass::firstOrCreate([
                        'level' => $level,
                        'major' => $major,
                        'class_letter' => $letter,
                    ]);
                }
            }
        }
    }
}
