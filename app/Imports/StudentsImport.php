<?php

namespace App\Imports;

use App\Models\Student;

// Manual include since composer failed
require_once app_path('Libraries/SimpleXLSX.php');

use Shuchkin\SimpleXLSX;

class StudentsImport
{
    public function import($filePath)
    {
        if ($xlsx = SimpleXLSX::parse($filePath)) {
            // Get all rows
            $rows = $xlsx->rows();

            // Assume first row is header, skip it
            array_shift($rows);

            foreach ($rows as $row) {
                // Check if row has enough columns (Col 0 = NIS, Col 1 = Name)
                if (isset($row[0]) && isset($row[1])) {
                    $nis = $row[0];
                    $name = $row[1];

                    // Simple validation for non-empty values
                    if (!empty($nis) && !empty($name)) {
                        Student::updateOrCreate(
                            ['nis' => $nis],
                            ['name' => $name]
                        );
                    }
                }
            }
            return true;
        } else {
            return false; // Error parsing file
        }
    }
}
