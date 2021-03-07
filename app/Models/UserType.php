<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = 'user_type';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id' , 'type','user_id' 
    ];
}

