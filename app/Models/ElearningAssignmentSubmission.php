<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningAssignmentSubmission extends Model
{
    protected $guarded = [];

    public function assignment()
    {
        return $this->belongsTo(ElearningAssignment::class, 'assignment_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
