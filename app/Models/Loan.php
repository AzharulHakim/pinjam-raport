<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'representative_id',
        'class_level',
        'major',
        'class_letter',
        'reason',
        'photo_path',
        'status',
        'borrowed_at',
        'returned_at',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function representative()
    {
        return $this->belongsTo(Student::class, 'representative_id');
    }
}
