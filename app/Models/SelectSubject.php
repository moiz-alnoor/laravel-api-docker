<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectSubject extends Model
{
    use HasFactory;
    protected $table = 'select_subject';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'user_id', 'subject_id', 'grade_id'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    public function rating()
    {
        return $this->belongsTo(Rating::class, 'rating_id', 'id');
    }
    public function charge()
    {
        return $this->belongsTo(Charge::class, 'charge_id', 'id');
    }
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id', 'id');
    }
}
