<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedClass extends Model
{
    protected $table = 'booked_class';
    public $timestamps = false;
    protected $primaryKey = 'id';
   // protected $forignKey = 'teacher_location_availability_id';
    protected $fillable = [
        'id', 'student_user_id', 'teacher_user_id', 'teacher_location_availability_id', 'teacher_time_availability_id', 'subject_id', 'status_id', 'grade_id'
    ];

    
    public function dialog()
    {
        return $this->belongsTo(Dialog::class,'id', 'booked_class_id');
    }
    public function student()
    {
        return $this->belongsTo(User::class,'student_user_id', 'id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class,'status_id', 'id');
    }
    public function location()
    {
        return $this->belongsTo(TeacherLocationAvailability::class, 'teacher_location_availability_id', 'user_id');
    }
    public function subject()
    {
        return $this->belongsTo(subject::class, 'subject_id', 'id');
    }
    public function time()
    {
        return $this->belongsTo(TeacherTimeAvailability::class, 'teacher_time_availability_id', 'user_id');
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_user_id', 'id');
    }
    public function review()
    {
        return $this->belongsTo(Review::class, 'teacher_user_id', 'teacher_user_id');
    }
    public function charge()
    {
        return $this->belongsTo(Charge::class, 'teacher_user_id', 'user_id');
    }

}


