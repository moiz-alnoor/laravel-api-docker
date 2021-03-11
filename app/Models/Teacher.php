<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Teacher extends Model
{
  

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'name', 'phone_number', 'password', 'user_type', 'image_location', 'is_verified', 'remember_token', 'created_at', 'updated_at', 'deleted_at'
    ];


   /*
    public function teacherCharge()
    { 
        return $this->hasOne(Charge::class,'user_phone_number');
    }
    public function teacherRating()
    {
        return $this->hasOne(Rating::class);
    }   
    */

    public function rating()
    {
        return $this->belongsTo(Rating::class, 'id', 'user_id');
    }
    public function charge()
    {
        return $this->belongsTo(Charge::class, 'id', 'user_id');
    }
    public function review()
    {
        return $this->belongsTo(Review::class, 'id', 'teacher_user_id');
    }

}
