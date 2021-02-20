<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    use HasFactory;
    protected $table = 'teacher_subject';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'user_phone_number', 'subject_id', 'grade_id' 
    ];
}
