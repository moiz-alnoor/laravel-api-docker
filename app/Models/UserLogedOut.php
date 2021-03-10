<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class UserLogedOut extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //use SoftDeletes;
    protected $table = 'users_loged_out';
    public $timestamps = false;
    protected $fillable = [
        'id', 'name', 'phone_number', 'create_time', 'user_type'
    ];
    protected $primaryKey = 'id';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
  

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
 
}
