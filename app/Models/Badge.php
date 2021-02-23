<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;
    protected $table = 'badge';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'badge'
    ];
}
