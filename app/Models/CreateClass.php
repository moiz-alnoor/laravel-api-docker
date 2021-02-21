<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateClass extends Model
{
    protected $table = 'create_class';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'class_location_id', 'class_time_id', 'teacher_subject_id', 'class_status_id'
    ];
}

