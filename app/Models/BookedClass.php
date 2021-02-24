<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedClass extends Model
{
    protected $table = 'booked_class';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'user_phone_number', 'select_subject_id', 'teacher_location_availability_id', 'teacher_time_availability_id','dialog_id'
    ];
}

