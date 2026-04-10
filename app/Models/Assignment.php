<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $guarded = [];
    
    public function subject() { return $this->belongsTo(Subject::class); }
    public function schoolClass() { return $this->belongsTo(SchoolClass::class); }
    public function studentAssignments() { return $this->hasMany(StudentAssignment::class); }
}
