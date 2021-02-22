<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedClass extends Model
{
    protected $table = 'booked_class';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'create_class_id', 'user_phone_number', 'date'
    ];
}

