<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'user';
    protected $primaryKey = 'phone_number';
    protected $fillable = [
        'name','image_loaction','phone_number', 'is_verified','user_type_id' 
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

}
