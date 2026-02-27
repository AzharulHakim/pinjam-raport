<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = ['level', 'major', 'class_letter'];

    public function getNameAttribute()
    {
        return "{$this->level} {$this->major} {$this->class_letter}";
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
