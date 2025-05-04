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
        'campaign_type',
        'campaign_title',
        'campaign_datetime',
        'location',
        'audience',      // عدد الجمهور أو الفئة المستهدفة (اختياري)
        'description',
        'planned',
    ];

    /* التحويلات السحرية */
    protected $casts = [
        'planned'          => 'boolean',
        'campaign_datetime'=> 'datetime',
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
