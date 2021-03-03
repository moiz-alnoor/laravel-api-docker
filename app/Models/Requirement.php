<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;
    protected $table = 'requirement';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'requirement', 'number'
    ];
}