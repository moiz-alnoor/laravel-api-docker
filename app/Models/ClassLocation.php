<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassLocation extends Model
{
    protected $table = 'class_location';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'create_class_id', 'longitude', 'latitude'
    ];
}

