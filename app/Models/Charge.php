<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;
    protected $table = 'charge';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'amount','user_id'
    ];
}


