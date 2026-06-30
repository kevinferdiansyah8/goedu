<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElearningMaterial extends Model
{
    protected $guarded = [];

    public function session()
    {
        return $this->belongsTo(ElearningSession::class, 'session_id');
    }

    public function getIconAttribute(): string
    {
        return match($this->tipe) {
            'youtube' => 'youtube',
            'link'    => 'link',
            default   => match(true) {
                str_contains($this->mime_type, 'pdf')        => 'file-text',
                str_contains($this->mime_type, 'video')      => 'video',
                str_contains($this->mime_type, 'image')      => 'image',
                str_contains($this->mime_type, 'word')       => 'file-text',
                str_contains($this->mime_type, 'powerpoint') => 'presentation',
                default => 'file',
            },
        };
    }
}
