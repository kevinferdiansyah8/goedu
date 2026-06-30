<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningSession extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function questions()
    {
        return $this->hasMany(ElearningQuestion::class, 'session_id')->orderBy('urutan');
    }

    public function pretestQuestions()
    {
        return $this->hasMany(ElearningQuestion::class, 'session_id')
            ->where('tipe', 'pretest')
            ->orderBy('urutan');
    }

    public function posttestQuestions()
    {
        return $this->hasMany(ElearningQuestion::class, 'session_id')
            ->where('tipe', 'posttest')
            ->orderBy('urutan');
    }

    public function materials()
    {
        return $this->hasMany(ElearningMaterial::class, 'session_id')->latest();
    }

    public function assignment()
    {
        return $this->hasOne(ElearningAssignment::class, 'session_id');
    }

    public function discussions()
    {
        return $this->hasMany(ElearningDiscussion::class, 'session_id')
            ->whereNull('parent_id')
            ->with('replies.user', 'user')
            ->latest();
    }

    public function studentAnswers()
    {
        return $this->hasMany(ElearningStudentAnswer::class, 'session_id');
    }
}
