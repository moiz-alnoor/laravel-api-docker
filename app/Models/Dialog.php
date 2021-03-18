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
    'id', 'subject_id', 'grade_id', 'user_id', 'message', 'date'
    ];
}
