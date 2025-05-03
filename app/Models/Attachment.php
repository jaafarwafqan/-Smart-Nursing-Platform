<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['path'];

    public function attachable()
    {
        return $this->morphTo();
    }

    /* رابط عام للتحميل */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
