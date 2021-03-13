<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'teacher_user_id', 'student_user_id', 'rating', 'comment'
    ];
}

