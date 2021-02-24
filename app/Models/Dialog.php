<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
    use HasFactory;
    protected $table = 'dialog';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id' ,'message', 'date', 'time','booked_class_id'
    ];
}
