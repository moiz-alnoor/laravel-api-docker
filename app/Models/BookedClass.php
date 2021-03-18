<?php

namespace App\Models;

//use App\Models\Notifiable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class BookedClass extends Model
{

    use Notifiable;

    protected $table = 'booked_class';
    public $timestamps = false;
    protected $primaryKey = 'id';
    // protected $forignKey = 'teacher_location_availability_id';
    protected $fillable = [
        'id', 'student_user_id', 'teacher_user_id', 'teacher_location_availability_id', 'teacher_time_availability_id', 'subject_id', 'status_id', 'grade_id',
    ];

    public function dialog()
    {
        return $this->belongsTo(Dialog::class, 'id', 'booked_class_id');
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_user_id', 'id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
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

    public function sendNotification()
    {
        $this->notify(new BookedClass($this)); //Pass the model data to the OneSignal Notificator
    }

    public function routeNotificationForOneSignal()
    {
        /*
         * you have to return the one signal player id tat will
         * receive the message of if you want you can return
         * an array of players id
         */
        return '8844bec0-c251-44c5-b852-d27f5687ca19';
        //return ['email' => 'mmoiz.aalnoor@gmail.com'];
        //return $this->data->user_one_signal_id;
    }
}
