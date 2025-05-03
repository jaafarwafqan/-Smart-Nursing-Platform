<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'branch_id','event_type','event_title','event_datetime',
        'location','lecturers','attendance','duration','description','planned'
    ];

    protected $casts = [
        'planned'        => 'boolean',
        'event_datetime' => 'datetime',
    ];

    /* علاقات */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
