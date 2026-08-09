<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $guarded = [];

    public function teacher() 
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function getNamaLengkapAttribute()
    {
        if ($this->tingkat === $this->nama_kelas) {
            return 'Kelas ' . $this->tingkat;
        }
        return 'Kelas ' . $this->tingkat . ' ' . $this->nama_kelas;
    }

    public function getNamaDisplayAttribute()
    {
        if ($this->tingkat === $this->nama_kelas) {
            return $this->tingkat;
        }
        return $this->tingkat . ' ' . $this->nama_kelas;
    }
}
