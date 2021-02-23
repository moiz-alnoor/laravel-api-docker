<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherTimeAvailability extends Model
{
    use HasFactory;

    protected $table = 'teacher_time_availability';
    public $timestamps = false;
    //protected $primaryKey = 'id';
    protected $fillable = [
        'id','from','to','date','teacher_phone_number' 
    ];
}
