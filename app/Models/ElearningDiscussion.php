<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningDiscussion extends Model
{
    protected $guarded = [];

    public function session()
    {
        return $this->belongsTo(ElearningSession::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(ElearningDiscussion::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(ElearningDiscussion::class, 'parent_id')->with('user')->latest();
    }
}
