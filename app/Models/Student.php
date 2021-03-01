<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function student()
    {
        return $this->belongsTo(User::class, 'student_phone_numbers', 'phone_number');
    }
}
