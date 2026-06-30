<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningAssignment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(ElearningSession::class, 'session_id');
    }

    public function submissions()
    {
        return $this->hasMany(ElearningAssignmentSubmission::class, 'assignment_id');
    }
}
