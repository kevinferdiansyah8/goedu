<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SppBill extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
