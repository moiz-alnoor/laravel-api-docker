<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassTime extends Model
{
    protected $table = 'class_time';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'create_class_id', 'class_start_time', 'class_end_time', 'class_date'
    ];
}

