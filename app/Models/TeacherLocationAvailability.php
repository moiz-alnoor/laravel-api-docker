<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherLocationAvailability extends Model
{
    protected $table = 'class_location';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'user_phone_number', 'longitude', 'latitude'
    ];
}

