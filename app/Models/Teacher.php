<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class); }
    public function documents() { return $this->hasMany(TeacherDocument::class); }
    public function histories() { return $this->hasMany(TeacherHistory::class); }
    public function certifications() { return $this->hasMany(TeacherCertification::class); }
}
