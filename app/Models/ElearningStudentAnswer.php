<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningStudentAnswer extends Model
{
    protected $guarded = [];

    public function session()
    {
        return $this->belongsTo(ElearningSession::class, 'session_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function question()
    {
        return $this->belongsTo(ElearningQuestion::class, 'question_id');
    }
}
