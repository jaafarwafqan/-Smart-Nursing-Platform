<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use SoftDeletes;

    /* الحقول المسموح بالكتابة الجماعية */
    protected $fillable = [
        'branch_id',
        'campaign_title',
        'description',
        'planned',
        'status',
        'start_date',
        'end_date',
        'organizers',
        'participants_count',
    ];

    /* التحويلات السحرية */
    protected $casts = [
        'planned'          => 'boolean',
        'campaign_datetime'=> 'datetime',
        'start_date'       => 'datetime',
        'end_date'         => 'datetime',
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
