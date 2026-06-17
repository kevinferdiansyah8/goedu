<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherCertification extends Model
{
    protected $guarded = [];
    public function teacher() { return $this->belongsTo(Teacher::class); }
}
