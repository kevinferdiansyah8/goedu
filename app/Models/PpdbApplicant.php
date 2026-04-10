<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpdbApplicant extends Model
{
    protected $guarded = [];

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
