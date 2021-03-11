<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'Rating';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'user_phone_number', 'teacher_subject_id', 'rating' 
    ];
}

