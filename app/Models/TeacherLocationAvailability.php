<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherLocationAvailability extends Model
{
    protected $table = 'teacher_location_availability';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'user_phone_number', 'longitude', 'latitude'
    ];

}

