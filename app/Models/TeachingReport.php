<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachingReport extends Model
{
    protected $guarded = [];

    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function schoolClass() { return $this->belongsTo(SchoolClass::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
}
