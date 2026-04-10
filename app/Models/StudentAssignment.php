<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAssignment extends Model
{
    protected $guarded = [];
    public function assignment() { return $this->belongsTo(Assignment::class); }
    public function student() { return $this->belongsTo(Student::class); }
}
