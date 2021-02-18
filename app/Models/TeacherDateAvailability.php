<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherDateAvailability extends Model
{
    use HasFactory;

    protected $table = 'teacher_date_availability';
    public $timestamps = false;
    //protected $primaryKey = 'id';
    protected $fillable = [
        'id','date','teacher_phone_number' 
    ];
}
