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
        'id', 'student_phone_number', 'subject_id', 'teacher_location_availability_id', 'teacher_time_availability_id', 
        'status_id', 'teacher_phone_number', 'charge_id', 'rating_id', 'grade_id'
    ];

    
    public function dialog()
    {
        return $this->hasMany(Dialog::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class,'status_id', 'id');
    }
    public function location()
    {
        return $this->belongsTo(TeacherLocationAvailability::class, 'teacher_location_availability_id', 'id');
    }
    public function subject()
    {
        return $this->belongsTo(subject::class, 'subject_id', 'id');
    }
    public function time()
    {
        return $this->belongsTo(TeacherTimeAvailability::class, 'teacher_time_availability_id', 'id');
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_phone_number', 'phone_number');
    }
    public function rating()
    {
        return $this->belongsTo(Rating::class, 'rating_id', 'id');
    }
    public function charge()
    {
        return $this->belongsTo(Charge::class, 'charge_id', 'id');
    }

}


