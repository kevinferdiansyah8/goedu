<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningQuestion extends Model
{
    protected $guarded = [];

    public function session()
    {
        return $this->belongsTo(ElearningSession::class, 'session_id');
    }

    public function answers()
    {
        return $this->hasMany(ElearningStudentAnswer::class, 'question_id');
    }
}
